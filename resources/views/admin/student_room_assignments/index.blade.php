@extends('admin.layouts.master_layout')

@section('title', 'Room Assignments')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Room Assignments: {{ $student->khmer_name }}</h1></div>
        <div class="col-sm-6">
          <a href="{{ route('students.show', $student) }}" class="btn btn-secondary float-right">Back to Student</a>
        </div>
</div>
<div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header"><h3 class="card-title">Assign Room</h3></div>
            <div class="card-body">
              <form action="{{ route('students.room-assignments.store', $student) }}" method="POST">
                @csrf
                <div class="form-group">
                  <label>Room</label>
                  <select name="room_id" class="form-control" required>
                    <option value="">-- Select Room --</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->building?->name }} - {{ $room->room_no }} ({{ $room->room_type }})</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Check In Date</label>
                  <input type="text" name="check_in_date" class="form-control flatpickr-date">
                </div>
                <div class="form-group">
                  <label>Note</label>
                  <textarea name="note" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Assign</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr><th>Building</th><th>Room</th><th>Check In</th><th>Check Out</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                  @foreach($student->roomAssignments as $assignment)
                  <tr>
                    <td>{{ $assignment->room?->building?->name }}</td>
                    <td>{{ $assignment->room?->room_no }}</td>
                    <td>{{ $assignment->check_in_date }}</td>
                    <td>{{ $assignment->check_out_date }}</td>
                    <td><span class="badge badge-{{ $assignment->status === 'active' ? 'success' : 'secondary' }}">{{ $assignment->status }}</span></td>
                    <td>
                      @if($assignment->status === 'active')
                      <form action="{{ route('students.room-assignments.destroy', [$student, $assignment]) }}" method="POST" class="d-inline" onsubmit="return confirm('Check out?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-warning">Check Out</button>
                      </form>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endsection
