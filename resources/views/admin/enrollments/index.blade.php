@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.enrollments') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.enrollments') }}</h3>
      <div class="card-tools">
        <a href="{{ route('enrollments.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </a>
      </div>
    </div>
    <div class="card-body">
      <table id="enrollments-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.student') }}</th>
            <th>{{ __('app.class') }}</th>
            <th>{{ __('app.academic_years') }}</th>
            <th>{{ __('app.shifts') }}</th>
            <th>{{ __('app.enroll_date') }}</th>
            <th width="100">{{ __('app.status') }}</th>
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
      $('#enrollments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('enrollments.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'student_name',
            name: 'students.khmer_name',
            searchable: false
          },
          {
            data: 'class_name',
            name: 'classes.class_code',
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
            data: 'enroll_date_fmt',
            name: 'enroll_date',
            searchable: false
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
