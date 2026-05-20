@extends('admin.layouts.master_layout')

@section('pageTitle', 'Diploma Report')
@section('pageHeading', 'Diploma Report')

@section('content')
  @php($reportTitle = 'Diploma Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.diploma_report') }}">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group"><label>From</label><input type="date" name="from" class="form-control"
                value="{{ $from }}"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group"><label>To</label><input type="date" name="to" class="form-control"
                value="{{ $to }}"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Course</label>
              <select name="course_id" class="form-control select2">
                <option value="">All Courses</option>
                @foreach ($courses as $course)
                  <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['draft', 'approved', 'printed', 'cancelled'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="text-right">
          <a href="{{ route('reports.diploma_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
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
          <p>Total Diplomas</p>
        </div>
        <div class="icon"><i class="fas fa-scroll"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['approved'] }}</h3>
          <p>Approved</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['printed'] }}</h3>
          <p>Printed</p>
        </div>
        <div class="icon"><i class="fas fa-print"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3>{{ $stats['draft'] }}</h3>
          <p>Draft</p>
        </div>
        <div class="icon"><i class="fas fa-file-alt"></i></div>
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
              <th>Diploma No</th>
              <th>Student</th>
              <th>Course / Level</th>
              <th>Issue Date</th>
              <th>Grade / GPA</th>
              <th>Status</th>
              <th>Approver</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $diploma)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $diploma->diploma_no }}</td>
                <td>{{ optional($diploma->student)->student_code }} -
                  {{ optional($diploma->student)->latin_name ?? (optional($diploma->student)->khmer_name ?? '-') }}</td>
                <td>{{ optional($diploma->course)->name ?? '-' }} @if ($diploma->level)
                    <br><small class="text-muted">{{ $diploma->level->name }}</small>
                  @endif
                </td>
                <td>{{ optional($diploma->issue_date)?->format('d/m/Y') }}</td>
                <td>{{ $diploma->grade ?? '-' }} @if ($diploma->gpa)
                    <br><small class="text-muted">GPA {{ number_format($diploma->gpa, 2) }}</small>
                  @endif
                </td>
                <td><span class="badge badge-light">{{ $diploma->status }}</span></td>
                <td>{{ optional($diploma->approver)->name ?? '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No diplomas found.</td>
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
