@extends('admin.layouts.master_layout')

@section('pageTitle', 'Student Master List - Reports')
@section('pageHeading', 'Student Master List')

@section('content')
    @php
        $reportTitle = 'Student Master List';
        $reportSubtitle = optional(\App\Models\Branch::find(current_branch_id()))->name_en ?? '';
    @endphp

    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.students') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Code / Name / Phone">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Class</label>
                            <select name="class_id" class="form-control select2">
                                <option value="">All Classes</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->class_code }} @if($c->course) · {{ $c->course->name }}@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Academic Year</label>
                            <select name="academic_year_id" class="form-control select2">
                                <option value="">All Years</option>
                                @foreach ($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ request('academic_year_id') == $ay->id ? 'selected' : '' }}>{{ $ay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.students') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <a href="{{ route('reports.students.export', request()->all()) }}" class="btn btn-sm btn-success"><i class="fas fa-file-csv mr-1"></i>CSV</a>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.reports._print_layout')

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="40">#</th>
                            <th>Student Code</th>
                            <th>Khmer Name</th>
                            <th>Latin Name</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $s)
                            <tr>
                                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                                <td>{{ $s->student_code }}</td>
                                <td>{{ $s->khmer_name }}</td>
                                <td>{{ $s->latin_name }}</td>
                                <td>{{ optional($s->gender)->name_en ?? '-' }}</td>
                                <td>{{ optional($s->date_of_birth)?->format('d/m/Y') }}</td>
                                <td>{{ $s->phone ?? '-' }}</td>
                                <td>{{ $s->email ?? '-' }}</td>
                                <td>{{ optional($s->branch)->name_en ?? '-' }}</td>
                                <td><span class="badge badge-{{ $s->status === 'active' ? 'success' : 'secondary' }}">{{ $s->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($rows->hasPages())
            <div class="card-footer no-print">{{ $rows->links() }}</div>
        @endif
    </div>
@endsection
