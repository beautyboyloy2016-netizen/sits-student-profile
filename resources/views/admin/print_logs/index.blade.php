@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.print_logs') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-print mr-2"></i>{{ __('app.print_logs') }}</h3>
    </div>
    <div class="card-body">
      <table id="print-logs-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.printed_at') }}</th>
            <th>{{ __('app.type') }}</th>
            <th>{{ __('app.template') }}</th>
            <th>{{ __('app.printed_by') }}</th>
            <th>{{ __('app.printer') }}</th>
            <th>{{ __('app.copies') }}</th>
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
      $('#print-logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('print-logs.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'printed_at_fmt',
            name: 'printed_at',
            searchable: false
          },
          {
            data: 'printable_type',
            name: 'printable_type'
          },
          {
            data: 'template_name',
            name: 'template_id',
            searchable: false
          },
          {
            data: 'printer_name_col',
            name: 'printed_by',
            searchable: false
          },
          {
            data: 'printer_name',
            name: 'printer_name'
          },
          {
            data: 'copies',
            name: 'copies',
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
      });
    });
  </script>
@endpush
