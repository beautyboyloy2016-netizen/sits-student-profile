@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.dashboard') . ' - ' . __('app.app_name'))

@section('content')
  <div id="app">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $stats['total_students'] }}</h3>
            <p>{{ __('app.total_students') }}</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="{{ route('students.index') }}" class="small-box-footer">{{ __('app.more_info') }} <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $stats['active_students'] }}</h3>
            <p>{{ __('app.active_students') }}</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-check"></i>
          </div>
          <a href="{{ route('students.index') }}" class="small-box-footer">{{ __('app.more_info') }} <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $stats['total_enrollments'] }}</h3>
            <p>{{ __('app.active_enrollments') }}</p>
          </div>
          <div class="icon">
            <i class="fas fa-book"></i>
          </div>
          <a href="{{ route('enrollments.index') }}" class="small-box-footer">{{ __('app.more_info') }} <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $stats['total_courses'] }}</h3>
            <p>{{ __('app.active_courses') }}</p>
          </div>
          <div class="icon">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <a href="{{ route('courses.index') }}" class="small-box-footer">{{ __('app.more_info') }} <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ __('app.recent_students') }}</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>{{ __('app.student_id') }}</th>
                  <th>{{ __('app.khmer_name') }}</th>
                  <th>{{ __('app.gender') }}</th>
                  <th>{{ __('app.status') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentStudents as $student)
                  <tr>
                    <td>{{ $student->student_code }}</td>
                    <td>{{ $student->khmer_name }}</td>
                    <td>{{ $student->gender->name_kh ?? '-' }}</td>
                    <td><span
                        class="badge badge-{{ $student->status == 'active' ? 'success' : 'secondary' }}">{{ $student->status }}</span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">{{ __('app.no_data') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ __('app.recent_enrollments') }}</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>{{ __('app.student') }}</th>
                  <th>{{ __('app.class') }}</th>
                  <th>{{ __('app.course') }}</th>
                  <th>{{ __('app.status') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentEnrollments as $enrollment)
                  <tr>
                    <td>{{ $enrollment->student->khmer_name ?? '-' }}</td>
                    <td>{{ $enrollment->class->class_code ?? '-' }}</td>
                    <td>{{ $enrollment->class->course->name ?? '-' }}</td>
                    <td><span
                        class="badge badge-{{ $enrollment->status == 'studying' ? 'success' : 'secondary' }}">{{ $enrollment->status }}</span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">{{ __('app.no_data') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
