@extends('admin.layouts.master_layout')

@section('title', 'All Room Assignments')

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">Room Assignments</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Room Assignments</li>
      </ol>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">All Room Assignments ({{ $assignments->total() }})</h3>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Student</th>
            <th>Building</th>
            <th>Room</th>
            <th>Room Type</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($assignments as $assignment)
            <tr>
              <td>{{ $assignments->firstItem() + $loop->index }}</td>
              <td>
                @if ($assignment->student)
                  <a href="{{ route('students.show', $assignment->student) }}">{{ $assignment->student->khmer_name }}</a>
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>{{ $assignment->room?->building?->name ?? '—' }}</td>
              <td>{{ $assignment->room?->room_no ?? '—' }}</td>
              <td>{{ $assignment->room?->room_type ? ucwords(str_replace('_', ' ', $assignment->room->room_type)) : '—' }}
              </td>
              <td>
                {{ $assignment->check_in_date ? \Carbon\Carbon::parse($assignment->check_in_date)->format('d/m/Y') : '—' }}
              </td>
              <td>
                {{ $assignment->check_out_date ? \Carbon\Carbon::parse($assignment->check_out_date)->format('d/m/Y') : '—' }}
              </td>
              <td>
                <span class="badge badge-{{ $assignment->status === 'active' ? 'success' : 'secondary' }}">
                  {{ ucfirst($assignment->status) }}
                </span>
              </td>
              <td>
                @if ($assignment->student)
                  <a href="{{ route('students.room-assignments.index', $assignment->student) }}"
                    class="btn btn-xs btn-info">
                    <i class="fas fa-eye"></i> View
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center text-muted">No room assignments found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($assignments->hasPages())
      <div class="card-footer clearfix">
        {{ $assignments->links() }}
      </div>
    @endif
  </div>
@endsection
