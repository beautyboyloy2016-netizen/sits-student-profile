@extends('admin.layouts.master_layout')

@section('pageTitle', 'Edit Enrollment - Student Profile Management')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Enrollment</h3>
        </div>
        <div class="card-body" id="app">
          <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Student <span class="text-danger">*</span></label>
                  <select name="student_id" class="form-control tom-select" required>
                    <option value="">Select Student</option>
                    @foreach ($students as $student)
                      <option value="{{ $student->id }}"
                        {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>
                        {{ $student->student_code }} - {{ $student->khmer_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Class <span class="text-danger">*</span></label>
                  <select name="class_id" class="form-control tom-select" required>
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                      <option value="{{ $class->id }}"
                        {{ old('class_id', $enrollment->class_id) == $class->id ? 'selected' : '' }}>
                        {{ $class->class_code }} - {{ $class->course->name ?? '' }} ({{ $class->level->name ?? '' }})
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Academic Year</label>
                  <select name="academic_year_id" class="form-control tom-select">
                    <option value="">Select Year</option>
                    @foreach ($academicYears as $year)
                      <option value="{{ $year->id }}"
                        {{ old('academic_year_id', $enrollment->academic_year_id) == $year->id ? 'selected' : '' }}>
                        {{ $year->name }} {{ $year->is_current ? '(Current)' : '' }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Shift</label>
                  <select name="shift_id" class="form-control tom-select">
                    <option value="">Select Shift</option>
                    @foreach ($shifts as $shift)
                      <option value="{{ $shift->id }}"
                        {{ old('shift_id', $enrollment->shift_id) == $shift->id ? 'selected' : '' }}>{{ $shift->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Enroll Date</label>
                  <input type="text" name="enroll_date" class="form-control flatpickr"
                    value="{{ old('enroll_date', $enrollment->enroll_date?->format('Y-m-d')) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Study Time Label</label>
                  <input type="text" name="study_time_label" class="form-control"
                    value="{{ old('study_time_label', $enrollment->study_time_label) }}"
                    placeholder="e.g. Morning, Afternoon">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status <span class="text-danger">*</span></label>
                  <select name="status" class="form-control" required>
                    <option value="studying" {{ old('status', $enrollment->status) == 'studying' ? 'selected' : '' }}>
                      Studying</option>
                    <option value="completed" {{ old('status', $enrollment->status) == 'completed' ? 'selected' : '' }}>
                      Completed</option>
                    <option value="dropped" {{ old('status', $enrollment->status) == 'dropped' ? 'selected' : '' }}>
                      Dropped</option>
                    <option value="transferred"
                      {{ old('status', $enrollment->status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea name="note" class="form-control" rows="2">{{ old('note', $enrollment->note) }}</textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Enrollment</button>
              <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">Cancel</a>
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
        window.flatpickr(el, {
          dateFormat: 'Y-m-d'
        });
      });
      document.querySelectorAll('.tom-select').forEach(function(el) {
        new window.TomSelect(el, {
          create: false
        });
      });
    });
  </script>
@endpush
