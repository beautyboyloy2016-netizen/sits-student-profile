@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.fee_types') . ' - ' . __('app.app_name'))

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-tags mr-2"></i>{{ __('app.fee_types') }}</h3>
    <div class="card-tools">
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFeeTypeModal">
        <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
      </button>
    </div>
  </div>
  <div class="card-body">
    <table id="fee-types-table" class="table table-bordered table-striped table-hover w-100">
      <thead>
        <tr>
          <th width="50">#</th>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.amount') }}</th>
          <th width="90">{{ __('app.status') }}</th>
          <th width="100">{{ __('app.actions') }}</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Add Fee Type Modal -->
<div class="modal fade" id="addFeeTypeModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('fees.types.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.fee_types') }}</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>{{ __('app.name') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required></div>
          <div class="form-group"><label>{{ __('app.amount') }} ($) <span class="text-danger">*</span></label>
            <input type="number" name="amount" class="form-control" step="0.01" min="0" required></div>
          <div class="form-group"><label>{{ __('app.status') }}</label>
            <select name="status" class="form-control tom-select">
              <option value="active">{{ __('app.active') }}</option>
              <option value="inactive">{{ __('app.inactive') }}</option>
            </select></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Fee Type Modal -->
<div class="modal fade" id="editFeeTypeModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editFeeTypeForm" method="POST">
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title">{{ __('app.edit') }} {{ __('app.fee_types') }}</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>{{ __('app.name') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" id="editFeeTypeName" class="form-control" required></div>
          <div class="form-group"><label>{{ __('app.amount') }} ($) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="editFeeTypeAmount" class="form-control" step="0.01" min="0" required></div>
          <div class="form-group"><label>{{ __('app.status') }}</label>
            <select name="status" id="editFeeTypeStatus" class="form-control">
              <option value="active">{{ __('app.active') }}</option>
              <option value="inactive">{{ __('app.inactive') }}</option>
            </select></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
          <button type="submit" class="btn btn-warning">{{ __('app.update') }}</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#fee-types-table').DataTable({
        processing: true, serverSide: true,
        ajax: '{{ route("fees.types") }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'amount_fmt', name: 'amount', searchable: false },
            { data: 'status_badge', name: 'status', searchable: false },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' },
        ],
        language: { url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') + '.json' },
        responsive: true, pageLength: 15,
    });

    $(document).on('click', '.btn-edit-fee-type', function() {
        var btn = $(this);
        $('#editFeeTypeName').val(btn.data('name'));
        $('#editFeeTypeAmount').val(btn.data('amount'));
        $('#editFeeTypeStatus').val(btn.data('status'));
        $('#editFeeTypeForm').attr('action', '/admin/fees/types/' + btn.data('id'));
        $('#editFeeTypeModal').modal('show');
    });
});
</script>
@endpush
