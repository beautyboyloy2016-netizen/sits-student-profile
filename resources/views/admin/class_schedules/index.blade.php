@extends('admin.layouts.master_layout')

@section('pageTitle', 'Class Schedules - ' . $class->class_code)

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Schedules for {{ $class->class_code }} - {{ $class->course->name ?? '' }} ({{ $class->level->name ?? '' }})</h3>
          <div class="card-tools">
            <a href="{{ route('classes.index') }}" class="btn btn-secondary btn-sm">Back to Classes</a>
          </div>
        </div>
        <div class="card-body" id="app">
          <div class="row mb-4">
            <div class="col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-chalkboard-teacher"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Teacher</span>
                  <span class="info-box-number">{{ $class->teacher->name_kh ?? 'Not assigned' }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-door-open"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Room</span>
                  <span class="info-box-number">{{ $class->room->room_no ?? 'Not assigned' }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <h5>Current Schedules</h5>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr><th>Day</th><th>Start Time</th><th>End Time</th><th>Duration</th><th>Actions</th></tr>
                </thead>
                <tbody>
                  @forelse($class->schedules as $schedule)
                  <tr>
                    <td>{{ ucfirst($schedule->day_of_week) }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>
                      @php
                        $start = \Carbon\Carbon::parse($schedule->start_time);
                        $end = \Carbon\Carbon::parse($schedule->end_time);
                        $diff = $start->diffInMinutes($end);
                        echo floor($diff / 60) . 'h ' . ($diff % 60) . 'm';
                      @endphp
                    </td>
                    <td>
                      <form action="{{ route('classes.schedules.destroy', [$class, $schedule]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this schedule?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr><td colspan="5" class="text-center">No schedules yet.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="col-md-4">
              <h5>Add Schedule</h5>
              <form action="{{ route('classes.schedules.store', $class) }}" method="POST">
                @csrf
                <div class="form-group">
                  <label>Day of Week <span class="text-danger">*</span></label>
                  <select name="day_of_week" class="form-control tom-select" required>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                    <option value="sunday">Sunday</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Start Time <span class="text-danger">*</span></label>
                  <input type="text" name="start_time" class="form-control flatpickr-time" placeholder="HH:MM" required>
                </div>
                <div class="form-group">
                  <label>End Time <span class="text-danger">*</span></label>
                  <input type="text" name="end_time" class="form-control flatpickr-time" placeholder="HH:MM" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add Schedule</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.tom-select').forEach(function(el) {
    new window.TomSelect(el, { create: false });
  });
  document.querySelectorAll('.flatpickr-time').forEach(function(el) {
    window.flatpickr(el, {
      enableTime: true,
      noCalendar: true,
      dateFormat: 'H:i',
      time_24hr: true,
    });
  });
});
</script>
@endpush
