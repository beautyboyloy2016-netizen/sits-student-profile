@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.invoices') . ' - ' . __('app.app_name'))

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-file-invoice-dollar mr-2"></i>{{ __('app.invoices') }}</h3>
    <div class="card-tools">
      <a href="{{ route('fees.invoices.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i>{{ __('app.create_invoice') }}
      </a>
    </div>
  </div>
  <div class="card-body">
    <table id="invoices-table" class="table table-bordered table-striped table-hover w-100">
      <thead>
        <tr>
          <th width="50">#</th>
          <th>{{ __('app.invoice_no') }}</th>
          <th>{{ __('app.student') }}</th>
          <th>{{ __('app.invoice_date') }}</th>
          <th>{{ __('app.total_amount') }}</th>
          <th>{{ __('app.balance') }}</th>
          <th width="90">{{ __('app.status') }}</th>
          <th width="60">{{ __('app.actions') }}</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#invoices-table').DataTable({
        processing: true, serverSide: true,
        ajax: '{{ route("fees.invoices") }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'invoice_no', name: 'invoice_no' },
            { data: 'student_name', name: 'student_id', searchable: false },
            { data: 'invoice_date', name: 'invoice_date' },
            { data: 'total_fmt', name: 'total_amount', searchable: false },
            { data: 'balance_fmt', name: 'balance', searchable: false },
            { data: 'status_badge', name: 'status', searchable: false },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' },
        ],
        language: { url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') + '.json' },
        responsive: true, pageLength: 15,
    });
});
</script>
@endpush
