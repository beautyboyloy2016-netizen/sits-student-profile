@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.audit_logs') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-history mr-2"></i>{{ __('app.audit_logs') }}</h3>
    </div>
    <div class="card-body">
      <table id="audit-logs-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.time') }}</th>
            <th>{{ __('app.user') }}</th>
            <th>{{ __('app.action') }}</th>
            <th>{{ __('app.table_name') }}</th>
            <th>{{ __('app.record_id') }}</th>
            <th>{{ __('app.ip_address') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#audit-logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('audit-logs.index') }}',
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
            data: 'table_name',
            name: 'table_name'
          },
          {
            data: 'record_id',
            name: 'record_id',
            className: 'text-center'
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
        order: [
          [1, 'desc']
        ],
      });
    });
  </script>
@endpush
