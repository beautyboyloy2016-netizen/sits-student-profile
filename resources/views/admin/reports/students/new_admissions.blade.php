@extends('admin.layouts.master_layout')

@section('pageTitle', 'New Admissions Report')
@section('pageHeading', 'New Admissions Report')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.new_admissions') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group"><label>From</label>
                            <input type="date" name="from" class="form-control" value="{{ $from }}"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>To</label>
                            <input type="date" name="to" class="form-control" value="{{ $to }}"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>Class</label>
                            <select name="class_id" class="form-control">
                                <option value="">All</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->class_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>Academic Year</label>
                            <select name="academic_year_id" class="form-control">
                                <option value="">All</option>
                                @foreach ($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ request('academic_year_id') == $ay->id ? 'selected' : '' }}>{{ $ay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.new_admissions') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.reports._print_layout', ['reportTitle' => 'New Admissions Report', 'reportSubtitle' => "$from to $to"])

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th><th>Date</th><th>Student</th><th>Class</th><th>Course</th><th>Year</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $e)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($e->enroll_date)?->format('d/m/Y') }}</td>
                            <td>{{ optional($e->student)->student_code }} · {{ optional($e->student)->latin_name }}</td>
                            <td>{{ optional($e->class)->class_code ?? '-' }}</td>
                            <td>{{ optional(optional($e->class)->course)->name ?? '-' }}</td>
                            <td>{{ optional($e->academicYear)->name ?? '-' }}</td>
                            <td><span class="badge badge-{{ $e->status === 'active' ? 'success' : 'secondary' }}">{{ $e->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">Total: <strong>{{ $rows->count() }}</strong> admissions</div>
    </div>
@endsection
