@extends('admin.layouts.master_layout')

@section('pageTitle', 'Monthly Attendance')
@section('pageHeading', 'Monthly Attendance per Student')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> Select Class & Month</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.monthly_attendance') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Class <span class="text-danger">*</span></label>
                            <select name="class_id" class="form-control select2" required>
                                <option value="">-- Choose Class --</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->class_code }} · {{ optional($c->course)->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>Month</label>
                            <input type="month" name="month" class="form-control" value="{{ $month }}" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.monthly_attendance') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @if ($class)
        @php
            $reportTitle = "Monthly Attendance: {$class->class_code}";
            $reportSubtitle = $month . ' · ' . $class->course->name ?? '';
        @endphp
        @include('admin.reports._print_layout', compact('reportTitle', 'reportSubtitle'))
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th class="text-center">Present</th>
                        <th class="text-center">Late</th>
                        <th class="text-center">Absent</th>
                        <th class="text-center">Excused</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->s->student_code }} · {{ $r->s->latin_name }}</td>
                            <td class="text-center"><span class="badge badge-success">{{ $r->present }}</span></td>
                            <td class="text-center"><span class="badge badge-warning">{{ $r->late }}</span></td>
                            <td class="text-center"><span class="badge badge-danger">{{ $r->absent }}</span></td>
                            <td class="text-center"><span class="badge badge-secondary">{{ $r->excused }}</span></td>
                            <td class="text-center font-weight-bold">{{ $r->total }}</td>
                            <td class="text-center font-weight-bold">{{ $r->pct }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($class)
            <div class="card-footer">
                Class days recorded: <strong>{{ $rows->max('total') ?? 0 }}</strong> · Avg attendance: <strong>{{ $rows->avg('pct') ? round($rows->avg('pct'), 1) : 0 }}%</strong>
            </div>
        @endif
    </div>
@endsection
