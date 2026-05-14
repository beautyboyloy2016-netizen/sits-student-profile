<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use App\Models\StudentInvoice;
use App\Models\StudentInvoiceItem;
use App\Models\Payment;
use App\Models\Student;
use App\Http\Requests\Fee\StoreFeeTypeRequest;
use App\Http\Requests\Fee\UpdateFeeTypeRequest;
use App\Http\Requests\Fee\StoreInvoiceRequest;
use App\Http\Requests\Fee\UpdateInvoiceRequest;
use App\Http\Requests\Fee\StorePaymentRequest;
use App\Http\Requests\Fee\UpdatePaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FeeController extends Controller
{
    public function feeTypes(Request $request)
    {
        if ($request->ajax()) {
            $data = FeeType::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('amount_fmt', fn($r) => '$' . number_format($r->amount, 2))
                ->addColumn('status_badge', fn($r) => $r->status === 'active'
                    ? '<span class="badge badge-success">' . __('app.active') . '</span>'
                    : '<span class="badge badge-secondary">' . __('app.inactive') . '</span>')
                ->addColumn('action', function($row) {
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-fee-type mr-1"'
                        . ' data-id="' . $row->id . '"'
                        . ' data-name="' . e($row->name) . '"'
                        . ' data-amount="' . $row->amount . '"'
                        . ' data-status="' . $row->status . '"'
                        . '><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="' . route('fees.types.destroy', $row->id) . '" method="POST" class="d-inline">'
                        . csrf_field() . '<input type="hidden" name="_method" value="DELETE">'
                        . '<button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button></form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        return view('admin.fees.fee_types');
    }

    public function storeFeeType(StoreFeeTypeRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $feeType = FeeType::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Fee type created successfully.', 'feeType' => $feeType]);
        }

        flash()->success('Fee type created successfully.');
        return redirect()->route('fees.types');
    }

    public function updateFeeType(UpdateFeeTypeRequest $request, FeeType $feeType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $feeType->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Fee type updated successfully.', 'feeType' => $feeType]);
        }

        flash()->success('Fee type updated successfully.');
        return redirect()->route('fees.types');
    }

    public function destroyFeeType(FeeType $feeType)
    {
        $feeType->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['message' => 'Fee type deleted successfully.']);
        }

        flash()->success('Fee type deleted successfully.');
        return redirect()->route('fees.types');
    }

    public function invoices(Request $request)
    {
        if ($request->ajax()) {
            $data = StudentInvoice::with(['student']);

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('student_invoices.branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student_name', fn($r) => $r->student?->khmer_name ?? '-')
                ->addColumn('status_badge', fn($r) => match($r->status) {
                    'paid' => '<span class="badge badge-success">' . __('app.paid') . '</span>',
                    'partial' => '<span class="badge badge-warning">' . __('app.partial') . '</span>',
                    'overdue' => '<span class="badge badge-danger">' . __('app.overdue') . '</span>',
                    default => '<span class="badge badge-secondary">' . __('app.'.$r->status) . '</span>',
                })
                ->addColumn('total_fmt', fn($r) => '$' . number_format($r->total_amount, 2))
                ->addColumn('balance_fmt', fn($r) => '$' . number_format($r->balance, 2))
                ->addColumn('action', fn($row) => '<a href="' . route('fees.invoices.show', $row->id) . '" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>')
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        return view('admin.fees.invoices');
    }

    public function createInvoice()
    {
        $students = Student::where('status', 'active')->orderBy('khmer_name')->get();
        $feeTypes = FeeType::where('status', 'active')->get();

        return view('admin.fees.create_invoice', compact('students', 'feeTypes'));
    }

    public function storeInvoice(StoreInvoiceRequest $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.fee_type_id' => 'nullable|exists:fee_types,id',
            'items.*.description' => 'nullable|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $total += $item['qty'] * $item['unit_price'];
            }

            $invoice = StudentInvoice::create([
                'branch_id'     => current_branch_id(),
                'invoice_no'    => 'INV-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
                'student_id'    => $validated['student_id'],
                'invoice_date'  => $validated['invoice_date'],
                'due_date'      => $validated['due_date'],
                'total_amount'  => $total,
                'balance'       => $total,
                'status'        => 'unpaid',
                'created_by'    => auth()->id(),
            ]);

            foreach ($validated['items'] as $item) {
                $itemTotal = $item['qty'] * $item['unit_price'];
                StudentInvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'fee_type_id' => $item['fee_type_id'],
                    'description' => $item['description'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'total' => $itemTotal,
                ]);
            }

            DB::commit();

            flash()->success('Invoice created successfully.');
            return redirect()->route('fees.invoices');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to create invoice.');
            return back()->withInput();
        }
    }

    public function showInvoice(StudentInvoice $invoice)
    {
        $invoice->load(['student', 'items.feeType']);
        return view('admin.fees.show_invoice', compact('invoice'));
    }

    public function editInvoice(StudentInvoice $invoice)
    {
        $invoice->load(['student', 'items.feeType']);
        $feeTypes = FeeType::where('status', 'active')->get();
        return view('admin.fees.edit_invoice', compact('invoice', 'feeTypes'));
    }

    public function updateInvoice(UpdateInvoiceRequest $request, StudentInvoice $invoice)
    {
        DB::beginTransaction();
        try {
            $invoice->update([
                'invoice_date'    => $request->invoice_date,
                'due_date'        => $request->due_date,
                'discount_amount' => $request->discount_amount ?? 0,
                'status'          => $request->status,
                'updated_by'      => auth()->id(),
            ]);

            if ($request->has('items')) {
                $invoice->items()->delete();
                $total = 0;
                foreach ($request->items as $item) {
                    $itemTotal = $item['qty'] * $item['unit_price'];
                    $total += $itemTotal;
                    \App\Models\StudentInvoiceItem::create([
                        'invoice_id'  => $invoice->id,
                        'fee_type_id' => $item['fee_type_id'] ?? null,
                        'description' => $item['description'] ?? null,
                        'qty'         => $item['qty'],
                        'unit_price'  => $item['unit_price'],
                        'total'       => $itemTotal,
                    ]);
                }
                $discount = $request->discount_amount ?? $invoice->discount_amount;
                $invoice->update([
                    'total_amount' => $total,
                    'balance'      => max(0, $total - $discount - $invoice->paid_amount),
                ]);
            }

            DB::commit();
            flash()->success('Invoice updated successfully.');
            return redirect()->route('fees.invoices.show', $invoice);
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to update invoice.');
            return back()->withInput();
        }
    }

    public function payments(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::with(['student', 'invoice']);

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('payments.branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student_name', fn($r) => $r->student?->khmer_name ?? '-')
                ->addColumn('invoice_no', fn($r) => $r->invoice?->invoice_no ?? '-')
                ->addColumn('amount_fmt', fn($r) => '$' . number_format($r->amount, 2))
                ->addColumn('payment_date_fmt', fn($r) => $r->payment_date ? \Carbon\Carbon::parse($r->payment_date)->format('d/m/Y') : '-')
                ->rawColumns([])
                ->make(true);
        }
        return view('admin.fees.payments');
    }

    public function createPayment()
    {
        $students = Student::where('status', 'active')->orderBy('khmer_name')->get();
        $invoices = StudentInvoice::whereIn('status', ['unpaid', 'partial'])->with('student')->get();

        return view('admin.fees.create_payment', compact('students', 'invoices'));
    }

    public function storePayment(StorePaymentRequest $request)
    {
        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'branch_id'      => current_branch_id(),
                'payment_no'     => 'PAY-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
                'invoice_id'     => $request->invoice_id,
                'student_id'     => $request->student_id,
                'payment_date'   => $request->payment_date,
                'amount'         => $request->amount,
                'payment_method' => $request->payment_method,
                'received_by'    => auth()->id(),
                'note'           => $request->note,
            ]);

            if ($request->invoice_id) {
                $invoice = StudentInvoice::find($request->invoice_id);
                $newPaid = $invoice->paid_amount + $request->amount;
                $invoice->update([
                    'paid_amount' => $newPaid,
                    'balance'     => max(0, $invoice->total_amount - $newPaid - $invoice->discount_amount),
                    'status'      => $newPaid >= $invoice->total_amount ? 'paid' : 'partial',
                ]);
            }

            DB::commit();
            flash()->success('Payment recorded successfully.');
            return redirect()->route('fees.payments');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to record payment.');
            return back()->withInput();
        }
    }

    public function editPayment(Payment $payment)
    {
        $payment->load(['student', 'invoice']);
        $invoices = StudentInvoice::whereIn('status', ['unpaid', 'partial'])->with('student')->get();
        return view('admin.fees.edit_payment', compact('payment', 'invoices'));
    }

    public function updatePayment(UpdatePaymentRequest $request, Payment $payment)
    {
        DB::beginTransaction();
        try {
            $oldAmount   = $payment->amount;
            $oldInvoiceId = $payment->invoice_id;

            $payment->update([
                'invoice_id'     => $request->invoice_id,
                'payment_date'   => $request->payment_date,
                'amount'         => $request->amount,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
            ]);

            if ($oldInvoiceId && $oldInvoiceId !== $request->invoice_id) {
                $oldInvoice = StudentInvoice::find($oldInvoiceId);
                if ($oldInvoice) {
                    $revertPaid = max(0, $oldInvoice->paid_amount - $oldAmount);
                    $oldInvoice->update([
                        'paid_amount' => $revertPaid,
                        'balance'     => max(0, $oldInvoice->total_amount - $revertPaid - $oldInvoice->discount_amount),
                        'status'      => $revertPaid <= 0 ? 'unpaid' : ($revertPaid >= $oldInvoice->total_amount ? 'paid' : 'partial'),
                    ]);
                }
            }

            if ($request->invoice_id) {
                $invoice = StudentInvoice::find($request->invoice_id);
                if ($invoice) {
                    $paymentsTotal = $invoice->payments()->where('id', '!=', $payment->id)->sum('amount') + $request->amount;
                    $invoice->update([
                        'paid_amount' => $paymentsTotal,
                        'balance'     => max(0, $invoice->total_amount - $paymentsTotal - $invoice->discount_amount),
                        'status'      => $paymentsTotal >= $invoice->total_amount ? 'paid' : ($paymentsTotal > 0 ? 'partial' : 'unpaid'),
                    ]);
                }
            }

            DB::commit();
            flash()->success('Payment updated successfully.');
            return redirect()->route('fees.payments');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to update payment.');
            return back()->withInput();
        }
    }
}
