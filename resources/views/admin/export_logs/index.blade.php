@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.export_logs') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-file-export mr-2"></i>{{ __('app.export_logs') }}</h3>
    </div>
    <div class="card-body">
      <table id="export-logs-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.export_type') }}</th>
            <th>{{ __('app.file_path') }}</th>
            <th>{{ __('app.exported_by') }}</th>
            <th>{{ __('app.exported_at') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#export-logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('export-logs.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'export_type',
            name: 'export_type'
          },
          {
            data: 'file_path',
            name: 'file_path'
          },
          {
            data: 'exporter_name',
            name: 'exported_by',
            searchable: false
          },
          {
            data: 'exported_at_fmt',
            name: 'exported_at',
            searchable: false
          },
        ],
        language: {
          url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') +
            '.json'
        },
        responsive: true,
        pageLength: 25,
        order: [
          [4, 'desc']
        ],
      });
    });
  </script>
@endpush
