@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.shifts') . ' - ' . __('app.app_name'))
@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.shifts') }}</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addShiftModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <table id="shifts-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.start_time') }}</th>
            <th>{{ __('app.end_time') }}</th>
            <th width="80">{{ __('app.status') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <!-- Add Shift Modal -->
  <div class="modal fade" id="addShiftModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('shifts.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.shifts') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.start_time') }}</label>
                  <input type="text" name="start_time" class="form-control flatpickr-time" placeholder="HH:MM">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.end_time') }}</label>
                  <input type="text" name="end_time" class="form-control flatpickr-time" placeholder="HH:MM">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>{{ __('app.status') }}</label>
              <select name="status" class="form-control tom-select">
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>{{ __('app.save') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Shift Modal -->
  <div class="modal fade" id="editShiftModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="editShiftForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">{{ __('app.edit') }} {{ __('app.shifts') }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" id="edit_shift_name" class="form-control" required>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.start_time') }}</label>
                  <input type="text" name="start_time" id="edit_start_time" class="form-control flatpickr-time" placeholder="HH:MM">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.end_time') }}</label>
                  <input type="text" name="end_time" id="edit_end_time" class="form-control flatpickr-time" placeholder="HH:MM">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>{{ __('app.status') }}</label>
              <select name="status" id="edit_shift_status" class="form-control">
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-warning"><i
                class="fas fa-save mr-1"></i>{{ __('app.update') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      var table = $('#shifts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('shifts.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'start_time',
            name: 'start_time'
          },
          {
            data: 'end_time',
            name: 'end_time'
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

      $(document).on('click', '.btn-edit-shift', function() {
        var btn = $(this);
        $('#edit_shift_name').val(btn.data('name'));
        $('#edit_start_time').val(btn.data('start_time'));
        $('#edit_end_time').val(btn.data('end_time'));
        $('#edit_shift_status').val(btn.data('status'));
        $('#editShiftForm').attr('action', '/admin/shifts/' + btn.data('id'));
        $('#editShiftModal').modal('show');
      });
    });
  </script>
@endpush
