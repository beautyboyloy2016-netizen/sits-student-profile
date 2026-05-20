@extends('admin.layouts.master_layout')

@section('pageTitle', 'Class Report')
@section('pageHeading', 'Class Report')

@section('content')
  @php($reportTitle = 'Class Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.class_report') }}">
        <div class="row">
          <div class="col-md-4">
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
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['active', 'completed', 'cancelled'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-5 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.class_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
              <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i
                  class="fas fa-print mr-1"></i>Print</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  @include('admin.reports._print_layout', ['reportTitle' => $reportTitle])

  <div class="row mb-3">
    <div class="col-md-3">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $stats['total'] }}</h3>
          <p>Total Classes</p>
        </div>
        <div class="icon"><i class="fas fa-school"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['active'] }}</h3>
          <p>Active Classes</p>
        </div>
        <div class="icon"><i class="fas fa-play-circle"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['completed'] }}</h3>
          <p>Completed</p>
        </div>
        <div class="icon"><i class="fas fa-flag-checkered"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $stats['students'] }}</h3>
          <p>Active Students</p>
        </div>
        <div class="icon"><i class="fas fa-user-friends"></i></div>
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
              <th>Class</th>
              <th>Course / Level</th>
              <th>Academic Year</th>
              <th>Teacher</th>
              <th>Room</th>
              <th>Shift</th>
              <th>Students</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $class)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $class->class_code }}</td>
                <td>{{ optional($class->course)->name ?? '-' }} @if ($class->level)
                    <br><small class="text-muted">{{ $class->level->name }}</small>
                  @endif
                </td>
                <td>{{ optional($class->academicYear)->name ?? '-' }}</td>
                <td>{{ optional($class->teacher)->name_en ?? (optional($class->teacher)->name_kh ?? '-') }}</td>
                <td>{{ optional($class->room)->room_no ?? '-' }}</td>
                <td>{{ optional($class->shift)->name ?? '-' }}</td>
                <td class="text-center">{{ $class->studying_enrollments_count }}</td>
                <td><span class="badge badge-light">{{ $class->status }}</span></td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">No classes found.</td>
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
