@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.reports') . ' - ' . __('app.app_name'))
@section('pageHeading', __('app.reports'))

@section('content')
    @php
        $reports = [
            ['cat' => 'Students', 'icon' => 'fa-user-graduate', 'color' => 'primary', 'items' => [
                ['route' => 'reports.students',           'title' => 'Student Master List',          'desc' => 'Complete student directory with filters by branch, class, gender, status'],
                ['route' => 'reports.new_admissions',     'title' => 'New Admissions',               'desc' => 'Enrollments within a date range, broken down by class & academic year'],
            ]],
            ['cat' => 'Academic', 'icon' => 'fa-book', 'color' => 'info', 'items' => [
                ['route' => 'reports.class_roster',       'title' => 'Class Roster',                 'desc' => 'Printable list of all students in a class with guardian contacts'],
                ['route' => 'reports.monthly_attendance', 'title' => 'Monthly Attendance',           'desc' => 'Per-student attendance summary for a class & month with %'],
            ]],
            ['cat' => 'Finance', 'icon' => 'fa-dollar-sign', 'color' => 'success', 'items' => [
                ['route' => 'reports.daily_cash_receipts','title' => 'Daily Cash Receipts',          'desc' => 'Payments collected on a given day, grouped by method'],
                ['route' => 'reports.ar_aging',           'title' => 'AR Aging / Outstanding',       'desc' => 'Unpaid invoices bucketed: current, 0-30, 31-60, 61-90, 90+ days'],
                ['route' => 'reports.revenue',            'title' => 'Revenue Report',               'desc' => 'Total payments by date range, grouped by day, month, branch or fee type'],
                ['route' => 'reports.fee_statement',      'title' => 'Student Fee Statement',        'desc' => 'Per-student ledger of all invoices and payments'],
            ]],
        ];
    @endphp

    <div class="row">
        @foreach ($reports as $cat)
            <div class="col-12">
                <h5 class="mb-3 mt-2">
                    <i class="fas {{ $cat['icon'] }} text-{{ $cat['color'] }} mr-2"></i>{{ $cat['cat'] }}
                </h5>
            </div>
            @foreach ($cat['items'] as $r)
                <div class="col-md-6 col-lg-4 mb-3">
                    <a href="{{ route($r['route']) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm hover-shadow report-card">
                            <div class="card-body">
                                <h6 class="card-title text-{{ $cat['color'] }}">
                                    <i class="fas fa-chart-bar mr-1"></i> {{ $r['title'] }}
                                </h6>
                                <p class="card-text text-muted small mb-0">{{ $r['desc'] }}</p>
                            </div>
                            <div class="card-footer bg-white border-top-0 text-right">
                                <span class="text-{{ $cat['color'] }} small">
                                    Open <i class="fas fa-arrow-right ml-1"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endforeach
    </div>

    <style>
        .report-card { transition: transform 0.15s, box-shadow 0.15s; cursor: pointer; }
        .report-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.08) !important; }
    </style>
@endsection
