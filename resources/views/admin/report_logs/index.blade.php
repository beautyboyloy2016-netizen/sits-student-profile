@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.report_logs') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>{{ __('app.report_logs') }}</h3>
    </div>
    <div class="card-body">
      <table id="report-logs-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.report_type') }}</th>
            <th>{{ __('app.report_title') }}</th>
            <th>{{ __('app.format') }}</th>
            <th>{{ __('app.generated_by') }}</th>
            <th>{{ __('app.generated_at') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#report-logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('report-logs.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'report_type',
            name: 'report_type'
          },
          {
            data: 'report_title',
            name: 'report_title'
          },
          {
            data: 'export_format',
            name: 'export_format',
            className: 'text-center'
          },
          {
            data: 'generator_name',
            name: 'generated_by',
            searchable: false
          },
          {
            data: 'generated_at_fmt',
            name: 'generated_at',
            searchable: false
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
