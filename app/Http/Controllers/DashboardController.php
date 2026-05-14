<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\ClassModel;
use App\Models\StudentInvoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $branchId = current_branch_id();

        // Scope a query to the current branch when one is selected
        $studentQ  = fn() => $branchId ? Student::where('branch_id', $branchId)       : Student::query();
        $enrollQ   = fn() => $branchId ? Enrollment::where('branch_id', $branchId)     : Enrollment::query();
        $classQ    = fn() => $branchId ? ClassModel::where('branch_id', $branchId)     : ClassModel::query();
        $invoiceQ  = fn() => $branchId ? StudentInvoice::where('branch_id', $branchId) : StudentInvoice::query();
        $paymentQ  = fn() => $branchId ? Payment::where('branch_id', $branchId)        : Payment::query();

        $stats = [
            'total_students'   => $studentQ()->count(),
            'active_students'  => $studentQ()->where('status', 'active')->count(),
            'total_enrollments'=> $enrollQ()->where('status', 'studying')->count(),
            'total_courses'    => Course::where('status', 'active')->count(),
            'total_classes'    => $classQ()->where('status', 'active')->count(),
            'total_invoices'   => $invoiceQ()->count(),
            'unpaid_invoices'  => $invoiceQ()->whereIn('status', ['unpaid', 'partial'])->count(),
            'total_payments'   => $paymentQ()->sum('amount'),
        ];

        $recentStudents = $studentQ()->with(['gender'])
            ->latest()
            ->take(5)
            ->get();

        $recentEnrollments = $enrollQ()->with(['student', 'class'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStudents', 'recentEnrollments'));
    }
}
