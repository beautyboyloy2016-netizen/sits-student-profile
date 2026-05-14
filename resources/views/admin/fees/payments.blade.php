@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.payments') . ' - ' . __('app.app_name'))

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-money-bill-wave mr-2"></i>{{ __('app.payments') }}</h3>
    <div class="card-tools">
      <a href="{{ route('fees.payments.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i>{{ __('app.record_payment') }}
      </a>
    </div>
  </div>
  <div class="card-body">
    <table id="payments-table" class="table table-bordered table-striped table-hover w-100">
      <thead>
        <tr>
          <th width="50">#</th>
          <th>{{ __('app.payment_no') }}</th>
          <th>{{ __('app.student') }}</th>
          <th>{{ __('app.invoice_no') }}</th>
          <th>{{ __('app.amount') }}</th>
          <th>{{ __('app.payment_method') }}</th>
          <th>{{ __('app.payment_date') }}</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#payments-table').DataTable({
        processing: true, serverSide: true,
        ajax: '{{ route("fees.payments") }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'payment_no', name: 'payment_no' },
            { data: 'student_name', name: 'student_id', searchable: false },
            { data: 'invoice_no', name: 'invoice_id', searchable: false },
            { data: 'amount_fmt', name: 'amount', searchable: false },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'payment_date_fmt', name: 'payment_date', searchable: false },
        ],
        language: { url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') + '.json' },
        responsive: true, pageLength: 15,
    });
});
</script>
@endpush
