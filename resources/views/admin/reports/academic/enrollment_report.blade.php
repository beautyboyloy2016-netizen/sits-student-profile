@extends('admin.layouts.master_layout')

@section('pageTitle', 'Enrollment Report')
@section('pageHeading', 'Enrollment Report')

@section('content')
  @php($reportTitle = 'Enrollment Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.enrollment_report') }}">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group"><label>From</label><input type="date" name="from" class="form-control"
                value="{{ $from }}"></div>
          </div>
          <div class="col-md-2">
            <div class="form-group"><label>To</label><input type="date" name="to" class="form-control"
                value="{{ $to }}"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Class</label>
              <select name="class_id" class="form-control select2">
                <option value="">All Classes</option>
                @foreach ($classes as $class)
                  <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->class_code }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Academic Year</label>
              <select name="academic_year_id" class="form-control select2">
                <option value="">All Years</option>
                @foreach ($academicYears as $year)
                  <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['studying', 'completed', 'dropped', 'transferred'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="text-right">
          <a href="{{ route('reports.enrollment_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
          <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
          <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i
              class="fas fa-print mr-1"></i>Print</button>
        </div>
      </form>
    </div>
  </div>

  @include('admin.reports._print_layout', [
      'reportTitle' => $reportTitle,
      'reportSubtitle' => $from . ' to ' . $to,
  ])

  <div class="row mb-3">
    <div class="col-md-3">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $stats['total'] }}</h3>
          <p>Total Enrollments</p>
        </div>
        <div class="icon"><i class="fas fa-user-plus"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['studying'] }}</h3>
          <p>Studying</p>
        </div>
        <div class="icon"><i class="fas fa-book-reader"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['completed'] }}</h3>
          <p>Completed</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $stats['dropped'] }}</h3>
          <p>Dropped</p>
        </div>
        <div class="icon"><i class="fas fa-times-circle"></i></div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm mb-0">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Enroll Date</th>
              <th>Student</th>
              <th>Class</th>
              <th>Academic Year</th>
              <th>Shift</th>
              <th>Status</th>
              <th>Branch</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $enrollment)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ optional($enrollment->enroll_date)?->format('d/m/Y') }}</td>
                <td>{{ optional($enrollment->student)->student_code }} -
                  {{ optional($enrollment->student)->latin_name ?? (optional($enrollment->student)->khmer_name ?? '-') }}
                </td>
                <td>{{ optional($enrollment->class)->class_code ?? '-' }}</td>
                <td>{{ optional($enrollment->academicYear)->name ?? '-' }}</td>
                <td>{{ optional($enrollment->shift)->name ?? '-' }}</td>
                <td><span class="badge badge-light">{{ $enrollment->status }}</span></td>
                <td>{{ optional(optional($enrollment->student)->branch)->name_en ?? '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No enrollments found.</td>
              </tr>
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
