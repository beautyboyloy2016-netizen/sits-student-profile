@extends('admin.layouts.master_layout')

@section('pageTitle', 'Class Roster')
@section('pageHeading', 'Class Roster')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> Select Class</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.class_roster') }}">
                <div class="row">
                    <div class="col-md-4">
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
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.class_roster') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @if ($class)
        @php
            $reportTitle = "Class Roster: {$class->class_code}";
            $reportSubtitle = optional($class->course)->name . ' | ' . optional($class->academicYear)->name . ' | ' . optional($class->shift)->name;
        @endphp
        @include('admin.reports._print_layout', compact('reportTitle', 'reportSubtitle'))
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="40">#</th>
                        <th width="80">Photo</th>
                        <th>Code</th>
                        <th>Latin Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Primary Guardian / Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $s)
                        @php
                            $primary = $s->guardians->where('pivot.is_primary', true)->first() ?? $s->guardians->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if ($s->photo_path)
                                    <img src="{{ asset('storage/' . $s->photo_path) }}" class="img-thumbnail" style="max-height:40px;max-width:40px;">
                                @else
                                    <div class="bg-light rounded text-muted small d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;">-</div>
                                @endif
                            </td>
                            <td>{{ $s->student_code }}</td>
                            <td>{{ $s->latin_name }}</td>
                            <td>{{ optional($s->gender)->name_en ?? '-' }}</td>
                            <td>{{ $s->phone ?? '-' }}</td>
                            <td>
                                @if ($primary)
                                    {{ $primary->name_en ?? $primary->name_kh }} <small>({{ $primary->pivot->relationship ?? '' }})</small><br>
                                    <small class="text-muted">{{ $primary->phone ?? '-' }}</small>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">No students in this class.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($class)
            <div class="card-footer">Total students: <strong>{{ $students->count() }}</strong></div>
        @endif
    </div>
@endsection
