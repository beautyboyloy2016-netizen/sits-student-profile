@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.file_access_logs') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>{{ __('app.file_access_logs') }}</h3>
    </div>
    <div class="card-body">
      <table id="file-access-logs-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.time') }}</th>
            <th>{{ __('app.user') }}</th>
            <th>{{ __('app.action') }}</th>
            <th>{{ __('app.file') }}</th>
            <th>{{ __('app.student') }}</th>
            <th>{{ __('app.ip') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#file-access-logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('file-access-logs.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'created_at_fmt',
            name: 'created_at',
            searchable: false
          },
          {
            data: 'user_name',
            name: 'user_id',
            searchable: false
          },
          {
            data: 'action',
            name: 'action'
          },
          {
            data: 'file_name',
            name: 'student_file_id',
            searchable: false
          },
          {
            data: 'student_name',
            name: 'student_file_id',
            searchable: false
          },
          {
            data: 'ip_address',
            name: 'ip_address'
          },
        ],
        language: {
          url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') +
            '.json'
        },
        responsive: true,
        pageLength: 25,
      });
    });
  </script>
@endpush
