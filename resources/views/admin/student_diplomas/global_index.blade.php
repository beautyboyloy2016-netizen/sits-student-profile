@extends('admin.layouts.master_layout')

@section('title', 'All Student Diplomas')

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">Student Diplomas</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Diplomas</li>
      </ol>
    </div>
  </div>

  <div class="card card-outline card-primary mb-3">
    <div class="card-body">
      <form action="{{ route('student-diplomas.index') }}" method="GET" class="form-inline">
        <div class="input-group w-100">
          <input type="text" name="search" class="form-control"
            placeholder="{{ __('app.search_student_placeholder') }}"
            value="{{ request('search') }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i> {{ __('app.search') }}
            </button>
            @if (request('search'))
              <a href="{{ route('student-diplomas.index') }}" class="btn btn-default">
                <i class="fas fa-times"></i> {{ __('app.reset') }}
              </a>
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">All Diplomas ({{ $diplomas->total() }})</h3>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Diploma No</th>
            <th>Student</th>
            <th>Grade</th>
            <th>GPA</th>
            <th>Graduation Date</th>
            <th>Issue Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($diplomas as $diploma)
            <tr>
              <td>{{ $diplomas->firstItem() + $loop->index }}</td>
              <td>{{ $diploma->diploma_no }}</td>
              <td>
                @if ($diploma->student)
                  <a href="{{ route('students.show', $diploma->student) }}">{{ $diploma->student->khmer_name }}</a>
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>{{ $diploma->grade ?? '—' }}</td>
              <td>{{ $diploma->gpa !== null ? number_format($diploma->gpa, 2) : '—' }}</td>
              <td>
                {{ $diploma->graduation_date ? \Carbon\Carbon::parse($diploma->graduation_date)->format('d/m/Y') : '—' }}
              </td>
              <td>{{ $diploma->issue_date ? \Carbon\Carbon::parse($diploma->issue_date)->format('d/m/Y') : '—' }}</td>
              <td>
                <span
                  class="badge badge-{{ $diploma->status === 'approved' ? 'success' : ($diploma->status === 'draft' ? 'warning' : 'secondary') }}">
                  {{ ucfirst($diploma->status) }}
                </span>
              </td>
              <td>
                @if ($diploma->student)
                  <a href="{{ route('students.diplomas.index', $diploma->student) }}" class="btn btn-xs btn-info">
                    <i class="fas fa-eye"></i> View
                  </a>
                  <a href="{{ route('students.diplomas.print', [$diploma->student, $diploma]) }}" target="_blank" class="btn btn-xs btn-primary">
                    <i class="fas fa-print"></i> Print
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center text-muted">No diplomas found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($diplomas->hasPages())
      <div class="card-footer clearfix">
        {{ $diplomas->links() }}
      </div>
    @endif
  </div>
@endsection
