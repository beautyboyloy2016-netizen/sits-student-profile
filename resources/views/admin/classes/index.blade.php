@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.classes') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.classes') }}</h3>
      <div class="card-tools">
        <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </a>
      </div>
    </div>
    <div class="card-body">
      <table id="classes-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.class_code') }}</th>
            <th>{{ __('app.courses') }}</th>
            <th>{{ __('app.level') }}</th>
            <th>{{ __('app.academic_years') }}</th>
            <th>{{ __('app.shifts') }}</th>
            <th>{{ __('app.teacher') }}</th>
            <th>{{ __('app.enrollments') }}</th>
            <th width="80">{{ __('app.status') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#classes-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('classes.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'class_code',
            name: 'class_code'
          },
          {
            data: 'course_name',
            name: 'courses.name',
            searchable: false
          },
          {
            data: 'level_name',
            name: 'levels.name',
            searchable: false
          },
          {
            data: 'academic_year_name',
            name: 'academic_years.name',
            searchable: false
          },
          {
            data: 'shift_name',
            name: 'shifts.name',
            searchable: false
          },
          {
            data: 'teacher_name',
            name: 'staff.name_en',
            searchable: false
          },
          {
            data: 'enrollments_count',
            name: 'enrollments_count',
            searchable: false,
            className: 'text-center'
          },
          {
            data: 'status_badge',
            name: 'status',
            searchable: false
          },
          {
            data: 'action',
            orderable: false,
            searchable: false,
            className: 'text-center'
          }
        ],
        language: {
          url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') +
            '.json'
        },
        responsive: true,
        pageLength: 15,
      });
    });
  </script>
@endpush
