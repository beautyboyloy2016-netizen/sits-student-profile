@extends('admin.layouts.master_layout')

@section('pageTitle', 'Student Summary Report')
@section('pageHeading', 'Student Summary Report')

@section('content')
  @php($reportTitle = 'Student Summary Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.student_report') }}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Search</label>
              <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                placeholder="Code, name, phone, email">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['active', 'inactive', 'graduated', 'suspended', 'dropped'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.student_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
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
          <p>Total Students</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['active'] }}</h3>
          <p>Active</p>
        </div>
        <div class="icon"><i class="fas fa-user-check"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['graduated'] }}</h3>
          <p>Graduated</p>
        </div>
        <div class="icon"><i class="fas fa-graduation-cap"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3>{{ $stats['inactive'] }}</h3>
          <p>Inactive</p>
        </div>
        <div class="icon"><i class="fas fa-user-slash"></i></div>
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
              <th>Student Code</th>
              <th>Student</th>
              <th>Branch</th>
              <th>Gender</th>
              <th>Enrollments</th>
              <th>Phone</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $student)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $student->student_code }}</td>
                <td>{{ $student->khmer_name }} @if ($student->latin_name)
                    <br><small class="text-muted">{{ $student->latin_name }}</small>
                  @endif
                </td>
                <td>{{ optional($student->branch)->name_en ?? '-' }}</td>
                <td>{{ optional($student->gender)->name_en ?? '-' }}</td>
                <td class="text-center">{{ $student->enrollments_count }}</td>
                <td>{{ $student->phone ?? '-' }}</td>
                <td><span
                    class="badge badge-{{ $student->status === 'active' ? 'success' : 'secondary' }}">{{ $student->status }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No students found.</td>
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
