<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\ReportLog;
use App\Models\Student;
use App\Models\StudentInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Reports Module
 *
 * Provides 8 priority reports plus a catalog index.
 * Each report supports HTML view + CSV export + browser-printable view.
 *
 * Reports auto-log to `report_logs` (and `export_logs` when exporting).
 */
class ReportController extends Controller
{
    /** Catalog page: list of available reports. */
    public function index()
    {
        return view('admin.reports.index');
    }

    /* ─────────────────────────────────────────────────────────
     | 1. Student Master List
     | --------------------------------------------------------- */
    public function students(Request $request)
    {
        $query = $this->studentMasterQuery($request);
        $rows  = $query->paginate(50)->withQueryString();

        $branches       = Branch::orderBy('name_en')->get();
        $academicYears  = AcademicYear::orderByDesc('start_date')->get();
        $classes        = ClassModel::with('course')->orderBy('class_code')->get();

        $this->logReport('students_master_list', 'Student Master List', $request->all(), 'view');

        return view('admin.reports.students.index', compact('rows', 'branches', 'academicYears', 'classes'));
    }

    public function studentsExport(Request $request)
    {
        $query = $this->studentMasterQuery($request);
        $this->logReport('students_master_list', 'Student Master List', $request->all(), 'csv');

        return $this->streamCsv('students-master-list-' . now()->format('Ymd-His') . '.csv',
            ['#', 'Student Code', 'Khmer Name', 'Latin Name', 'Gender', 'DOB', 'Phone', 'Email', 'Branch', 'Status'],
            function () use ($query) {
                $i = 0;
                foreach ($query->cursor() as $s) {
                    yield [
                        ++$i,
                        $s->student_code,
                        $s->khmer_name,
                        $s->latin_name,
                        optional($s->gender)->name_en ?? '-',
                        optional($s->date_of_birth)?->format('Y-m-d'),
                        $s->phone,
                        $s->email,
                        optional($s->branch)->name_en ?? '-',
                        $s->status,
                    ];
                }
            }
        );
    }

    private function studentMasterQuery(Request $request)
    {
        $q = Student::with(['gender', 'branch']);

        if ($branchId = current_branch_id()) {
            $q->where('branch_id', $branchId);
        }
        if ($request->filled('status'))    $q->where('status', $request->status);
        if ($request->filled('gender_id')) $q->where('gender_id', $request->gender_id);
        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($w) use ($s) {
                $w->where('student_code', 'like', "%$s%")
                    ->orWhere('khmer_name', 'like', "%$s%")
                    ->orWhere('latin_name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%");
            });
        }
        if ($request->filled('class_id')) {
            $q->whereHas('enrollments', fn($w) => $w->where('class_id', $request->class_id));
        }
        if ($request->filled('academic_year_id')) {
            $q->whereHas('enrollments', fn($w) => $w->where('academic_year_id', $request->academic_year_id));
        }

        return $q->orderBy('student_code');
    }

    /* ─────────────────────────────────────────────────────────
     | 2. New Admissions Report
     | --------------------------------------------------------- */
    public function newAdmissions(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->endOfMonth()->toDateString());

        $rows = Enrollment::with(['student.gender', 'class.course', 'academicYear', 'branch'])
            ->whereBetween('enroll_date', [$from, $to])
            ->when(current_branch_id(), fn($q, $b) => $q->where('branch_id', $b))
            ->when($request->class_id, fn($q, $c) => $q->where('class_id', $c))
            ->when($request->academic_year_id, fn($q, $a) => $q->where('academic_year_id', $a))
            ->orderBy('enroll_date')
            ->get();

        $classes        = ClassModel::with('course')->orderBy('class_code')->get();
        $academicYears  = AcademicYear::orderByDesc('start_date')->get();

        $this->logReport('new_admissions', 'New Admissions Report', compact('from', 'to'), 'view');

        return view('admin.reports.students.new_admissions', compact('rows', 'from', 'to', 'classes', 'academicYears'));
    }

    /* ─────────────────────────────────────────────────────────
     | 3. Class Roster
     | --------------------------------------------------------- */
    public function classRoster(Request $request)
    {
        $classes = ClassModel::with(['course', 'academicYear', 'teacher', 'shift'])
            ->orderBy('class_code')
            ->get();

        $class    = null;
        $students = collect();

        if ($request->filled('class_id')) {
            $class = ClassModel::with(['course', 'academicYear', 'teacher', 'shift', 'room'])
                ->find($request->class_id);

            if ($class) {
                $students = Student::with(['gender', 'guardians'])
                    ->whereHas('enrollments', fn($q) => $q->where('class_id', $class->id))
                    ->orderBy('student_code')
                    ->get();

                $this->logReport('class_roster', "Class Roster: {$class->class_code}",
                    ['class_id' => $class->id], 'view');
            }
        }

        return view('admin.reports.academic.class_roster', compact('classes', 'class', 'students'));
    }

    /* ─────────────────────────────────────────────────────────
     | 4. Monthly Attendance per Student
     | --------------------------------------------------------- */
    public function monthlyAttendance(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        [$y, $m] = explode('-', $month);
        $start = Carbon::create($y, $m, 1)->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $classes  = ClassModel::with('course')->orderBy('class_code')->get();
        $rows     = collect();
        $class    = null;

        if ($request->filled('class_id')) {
            $class = ClassModel::with('course')->find($request->class_id);

            $students = Student::whereHas('enrollments', fn($q) => $q->where('class_id', $request->class_id))
                ->orderBy('student_code')->get();

            $attendances = Attendance::students()
                ->where('class_id', $request->class_id)
                ->whereBetween('date', [$start, $end])
                ->get()
                ->groupBy('attendable_id');

            $rows = $students->map(function ($s) use ($attendances) {
                $att = $attendances->get($s->id, collect());
                $present = $att->where('status', 'present')->count();
                $late    = $att->where('status', 'late')->count();
                $absent  = $att->where('status', 'absent')->count();
                $excused = $att->where('status', 'excused')->count();
                $total   = $att->count();
                $pct     = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;
                return (object) compact('s', 'present', 'late', 'absent', 'excused', 'total', 'pct');
            });

            $this->logReport('monthly_attendance', "Monthly Attendance: {$class?->class_code} ($month)",
                $request->only(['class_id', 'month']), 'view');
        }

        return view('admin.reports.attendance.monthly', compact('classes', 'class', 'rows', 'month', 'start', 'end'));
    }

    /* ─────────────────────────────────────────────────────────
     | 5. Daily Cash Receipts
     | --------------------------------------------------------- */
    public function dailyCashReceipts(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $payments = Payment::with(['student', 'invoice', 'receiver', 'branch'])
            ->whereDate('payment_date', $date)
            ->when(current_branch_id(), fn($q, $b) => $q->where('branch_id', $b))
            ->when($request->method, fn($q, $m) => $q->where('payment_method', $m))
            ->orderBy('payment_date')
            ->get();

        $totalsByMethod = $payments->groupBy('payment_method')->map(fn($g) => $g->sum('amount'));
        $grandTotal     = $payments->sum('amount');

        $this->logReport('daily_cash_receipts', "Daily Cash Receipts ($date)",
            compact('date'), 'view');

        return view('admin.reports.finance.daily_cash_receipts',
            compact('payments', 'date', 'totalsByMethod', 'grandTotal'));
    }

    /* ─────────────────────────────────────────────────────────
     | 6. Outstanding Invoices / AR Aging
     | --------------------------------------------------------- */
    public function arAging(Request $request)
    {
        $asOf = $request->input('as_of', now()->toDateString());
        $asOfC = Carbon::parse($asOf);

        $invoices = StudentInvoice::with(['student', 'branch'])
            ->whereIn('status', ['unpaid', 'partial', 'overdue'])
            ->where('balance', '>', 0)
            ->when(current_branch_id(), fn($q, $b) => $q->where('branch_id', $b))
            ->orderBy('due_date')
            ->get();

        // Bucket by aging
        $buckets = ['current' => [], '0-30' => [], '31-60' => [], '61-90' => [], '90+' => []];
        $totals  = ['current' => 0, '0-30' => 0, '31-60' => 0, '61-90' => 0, '90+' => 0];

        foreach ($invoices as $inv) {
            $due  = $inv->due_date ? Carbon::parse($inv->due_date) : null;
            $days = $due ? $due->diffInDays($asOfC, false) : 0; // negative = future

            if (!$due || $days < 0) {
                $key = 'current';
            } elseif ($days <= 30) {
                $key = '0-30';
            } elseif ($days <= 60) {
                $key = '31-60';
            } elseif ($days <= 90) {
                $key = '61-90';
            } else {
                $key = '90+';
            }
            $buckets[$key][] = $inv;
            $totals[$key]   += (float) $inv->balance;
        }

        $grandBalance = array_sum($totals);

        $this->logReport('ar_aging', "AR Aging as of $asOf", compact('asOf'), 'view');

        return view('admin.reports.finance.ar_aging',
            compact('buckets', 'totals', 'grandBalance', 'asOf'));
    }

    /* ─────────────────────────────────────────────────────────
     | 7. Revenue Report
     | --------------------------------------------------------- */
    public function revenue(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->endOfMonth()->toDateString());
        $groupBy = $request->input('group_by', 'day'); // day|month|branch|fee_type

        $payments = Payment::with(['branch', 'invoice.items.feeType'])
            ->whereBetween('payment_date', [$from, $to])
            ->when(current_branch_id(), fn($q, $b) => $q->where('branch_id', $b))
            ->get();

        $grouped = match ($groupBy) {
            'month'    => $payments->groupBy(fn($p) => Carbon::parse($p->payment_date)->format('Y-m')),
            'branch'   => $payments->groupBy(fn($p) => optional($p->branch)->name_en ?? 'Unknown'),
            'fee_type' => $this->groupPaymentsByFeeType($payments),
            default    => $payments->groupBy(fn($p) => Carbon::parse($p->payment_date)->format('Y-m-d')),
        };

        $summary = $grouped->map(fn($g, $k) => (object) [
            'key'   => $k,
            'count' => is_array($g) ? count($g) : $g->count(),
            'total' => is_array($g) ? array_sum(array_column($g, 'amount')) : $g->sum('amount'),
        ])->values();

        $grandTotal = $payments->sum('amount');

        $this->logReport('revenue', "Revenue Report ($from to $to)",
            compact('from', 'to', 'groupBy'), 'view');

        return view('admin.reports.finance.revenue',
            compact('summary', 'from', 'to', 'groupBy', 'grandTotal'));
    }

    private function groupPaymentsByFeeType($payments)
    {
        // Approximate by allocating payment proportionally to invoice items
        $bucket = [];
        foreach ($payments as $p) {
            $items = $p->invoice?->items ?? collect();
            $invTotal = max(0.01, (float) ($p->invoice->total_amount ?? 0));
            foreach ($items as $it) {
                $name = optional($it->feeType)->name ?? 'Other';
                $share = ((float) $it->total / $invTotal) * (float) $p->amount;
                $bucket[$name] = ($bucket[$name] ?? 0) + $share;
            }
        }
        return collect($bucket)->map(fn($v) => ['amount' => $v]);
    }

    /* ─────────────────────────────────────────────────────────
     | 8. Student Fee Statement (per student)
     | --------------------------------------------------------- */
    public function feeStatement(Request $request)
    {
        $student   = null;
        $invoices  = collect();
        $payments  = collect();
        $totals    = ['invoiced' => 0, 'paid' => 0, 'balance' => 0];

        if ($request->filled('student_id')) {
            $student = Student::with('branch')->find($request->student_id);

            if ($student) {
                $invoices = StudentInvoice::with('items.feeType')
                    ->where('student_id', $student->id)
                    ->orderBy('invoice_date')
                    ->get();

                $payments = Payment::with('invoice')
                    ->where('student_id', $student->id)
                    ->orderBy('payment_date')
                    ->get();

                $totals['invoiced'] = $invoices->sum('total_amount');
                $totals['paid']     = $payments->sum('amount');
                $totals['balance']  = $invoices->sum('balance');

                $this->logReport('fee_statement', "Fee Statement: {$student->student_code}",
                    ['student_id' => $student->id], 'view');
            }
        }

        // For the dropdown, restrict to current branch
        $students = Student::when(current_branch_id(), fn($q, $b) => $q->where('branch_id', $b))
            ->orderBy('student_code')->limit(500)->get(['id', 'student_code', 'khmer_name', 'latin_name']);

        return view('admin.reports.finance.fee_statement',
            compact('student', 'invoices', 'payments', 'totals', 'students'));
    }

    /* ─────────────────────────────────────────────────────────
     | Helpers
     | --------------------------------------------------------- */
    private function logReport(string $type, string $title, $filters, string $format): void
    {
        try {
            ReportLog::create([
                'branch_id'     => current_branch_id(),
                'report_type'   => $type,
                'report_title'  => $title,
                'filters'       => is_array($filters) ? json_encode($filters) : (string) $filters,
                'export_format' => $format,
                'generated_by'  => auth()->id(),
                'generated_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            // Logging failure should never break the report
        }
    }

    /** Stream a CSV without loading everything into memory. */
    private function streamCsv(string $filename, array $headers, \Closure $rowGenerator): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rowGenerator) {
            $h = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fwrite($h, "\xEF\xBB\xBF");
            fputcsv($h, $headers);
            foreach ($rowGenerator() as $row) {
                fputcsv($h, $row);
            }
            fclose($h);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
