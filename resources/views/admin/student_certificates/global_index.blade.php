@extends('admin.layouts.master_layout')

@section('title', 'All Student Certificates')

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">Student Certificates</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Certificates</li>
      </ol>
    </div>
  </div>

  <div class="card card-outline card-primary mb-3">
    <div class="card-body">
      <form action="{{ route('student-certificates.index') }}" method="GET" class="form-inline">
        <div class="input-group w-100">
          <input type="text" name="search" class="form-control"
            placeholder="{{ __('app.search_student_placeholder') }}"
            value="{{ request('search') }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i> {{ __('app.search') }}
            </button>
            @if (request('search'))
              <a href="{{ route('student-certificates.index') }}" class="btn btn-default">
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
      <h3 class="card-title">All Certificates ({{ $certificates->total() }})</h3>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Certificate No</th>
            <th>Student</th>
            <th>Type</th>
            <th>Title</th>
            <th>Issue Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($certificates as $cert)
            <tr>
              <td>{{ $certificates->firstItem() + $loop->index }}</td>
              <td>{{ $cert->certificate_no }}</td>
              <td>
                @if ($cert->student)
                  <a href="{{ route('students.show', $cert->student) }}">{{ $cert->student->khmer_name }}</a>
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>{{ ucwords(str_replace('_', ' ', $cert->certificate_type)) }}</td>
              <td>{{ $cert->title ?? '—' }}</td>
              <td>{{ $cert->issue_date ? \Carbon\Carbon::parse($cert->issue_date)->format('d/m/Y') : '—' }}</td>
              <td>
                <span
                  class="badge badge-{{ $cert->status === 'approved' ? 'success' : ($cert->status === 'draft' ? 'warning' : 'secondary') }}">
                  {{ ucfirst($cert->status) }}
                </span>
              </td>
              <td>
                @if ($cert->student)
                  <a href="{{ route('students.certificates.index', $cert->student) }}" class="btn btn-xs btn-info">
                    <i class="fas fa-eye"></i> View
                  </a>
                  <a href="{{ route('students.certificates.print', [$cert->student, $cert]) }}" target="_blank" class="btn btn-xs btn-primary">
                    <i class="fas fa-print"></i> Print
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">No certificates found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($certificates->hasPages())
      <div class="card-footer clearfix">
        {{ $certificates->links() }}
      </div>
    @endif
  </div>
@endsection
