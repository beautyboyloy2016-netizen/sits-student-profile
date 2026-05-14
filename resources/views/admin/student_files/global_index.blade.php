@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.student_files') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.student_files') }}</h3>
    </div>
    <div class="card-body">
      <table id="student-files-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('app.student') }}</th>
            <th>{{ __('app.file_type') }}</th>
            <th>{{ __('app.file_name') }}</th>
            <th>{{ __('app.file_size') }}</th>
            <th>{{ __('app.is_primary') }}</th>
            <th>{{ __('app.uploaded_by') }}</th>
            <th>{{ __('app.uploaded_at') }}</th>
            <th>{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#student-files-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('student-files.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            name: 'id',
            searchable: false,
            orderable: false,
            width: '50px'
          },
          {
            data: 'student_name',
            name: 'student.khmer_name'
          },
          {
            data: 'file_type_label',
            name: 'file_type'
          },
          {
            data: 'original_name',
            name: 'original_name'
          },
          {
            data: 'size_label',
            name: 'size',
            searchable: false
          },
          {
            data: 'is_primary_label',
            name: 'is_primary',
            searchable: false,
            orderable: false
          },
          {
            data: 'uploaded_by_name',
            name: 'uploader.name',
            searchable: false
          },
          {
            data: 'uploaded_at_fmt',
            name: 'created_at',
            searchable: false
          },
          {
            data: 'actions',
            name: 'actions',
            searchable: false,
            orderable: false
          },
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
