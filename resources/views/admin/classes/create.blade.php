@extends('admin.layouts.master_layout')

@section('pageTitle', 'Add Class - Student Profile Management')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Add New Class</h3>
        </div>
        <div class="card-body" id="app">
          <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Class Code <span class="text-danger">*</span></label>
                  <input type="text" name="class_code" class="form-control" value="{{ old('class_code') }}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Course <span class="text-danger">*</span></label>
                  <select name="course_id" class="form-control tom-select" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                      <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Level</label>
                  <select name="level_id" class="form-control tom-select">
                    <option value="">Select Level</option>
                    @foreach($levels as $level)
                      <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }} ({{ $level->course->name ?? '' }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Academic Year</label>
                  <select name="academic_year_id" class="form-control tom-select">
                    <option value="">Select Year</option>
                    @foreach($academicYears as $year)
                      <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }} {{ $year->is_current ? '(Current)' : '' }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Shift</label>
                  <select name="shift_id" class="form-control tom-select">
                    <option value="">Select Shift</option>
                    @foreach($shifts as $shift)
                      <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Teacher</label>
                  <select name="teacher_id" class="form-control tom-select">
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                      <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name_kh }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Room</label>
                  <select name="room_id" class="form-control tom-select">
                    <option value="">Select Room</option>
                    @foreach($rooms as $room)
                      <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->room_no }} ({{ $room->building->name ?? '' }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Start Date</label>
                  <input type="text" name="start_date" class="form-control flatpickr" value="{{ old('start_date') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>End Date</label>
                  <input type="text" name="end_date" class="form-control flatpickr" value="{{ old('end_date') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Status <span class="text-danger">*</span></label>
                  <select name="status" class="form-control" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Class</button>
              <a href="{{ route('classes.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.flatpickr').forEach(function(el) {
    window.flatpickr(el, { dateFormat: 'Y-m-d' });
  });
  document.querySelectorAll('.tom-select').forEach(function(el) {
    new window.TomSelect(el, { create: false });
  });
});
</script>
@endpush
