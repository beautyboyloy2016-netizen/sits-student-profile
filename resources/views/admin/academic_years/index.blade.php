@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.academic_years') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.academic_years') }}</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAYModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <table id="ay-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.start_date') }}</th>
            <th>{{ __('app.end_date') }}</th>
            <th width="80">{{ __('app.is_current') }}</th>
            <th width="80">{{ __('app.status') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <!-- Add Academic Year Modal -->
  <div class="modal fade" id="addAYModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('academic-years.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.academic_years') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required placeholder="e.g. 2024-2025">
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.start_date') }}</label>
                  <input type="text" name="start_date" class="form-control flatpickr-date" placeholder="YYYY-MM-DD">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.end_date') }}</label>
                  <input type="text" name="end_date" class="form-control flatpickr-date" placeholder="YYYY-MM-DD">
                </div>
              </div>
            </div>
            <div class="form-check mb-3">
              <input type="checkbox" name="is_current" value="1" class="form-check-input" id="is_current_add">
              <label class="form-check-label" for="is_current_add">{{ __('app.set_as_current_year') }}</label>
            </div>
            <div class="form-group">
              <label>{{ __('app.status') }}</label>
              <select name="status" class="form-control tom-select">
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
                <option value="closed">{{ __('app.closed') }}</option>
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

  <!-- Edit Academic Year Modal -->
  <div class="modal fade" id="editAYModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="editAYForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">{{ __('app.edit') }} {{ __('app.academic_years') }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" id="edit_ay_name" class="form-control" required>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.start_date') }}</label>
                  <input type="text" name="start_date" id="edit_ay_start" class="form-control flatpickr-date">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('app.end_date') }}</label>
                  <input type="text" name="end_date" id="edit_ay_end" class="form-control flatpickr-date">
                </div>
              </div>
            </div>
            <div class="form-check mb-3">
              <input type="checkbox" name="is_current" value="1" class="form-check-input" id="edit_is_current">
              <label class="form-check-label" for="edit_is_current">{{ __('app.set_as_current_year') }}</label>
            </div>
            <div class="form-group">
              <label>{{ __('app.status') }}</label>
              <select name="status" id="edit_ay_status" class="form-control">
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
                <option value="closed">{{ __('app.closed') }}</option>
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
      var table = $('#ay-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('academic-years.index') }}',
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
            data: 'start_date_fmt',
            name: 'start_date',
            searchable: false
          },
          {
            data: 'end_date_fmt',
            name: 'end_date',
            searchable: false
          },
          {
            data: 'is_current_badge',
            name: 'is_current',
            searchable: false
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

      $(document).on('click', '.btn-edit-ay', function() {
        var btn = $(this);
        var id = btn.data('id');
        $('#edit_ay_name').val(btn.data('name'));
        $('#edit_ay_start').val(btn.data('start_date'));
        $('#edit_ay_end').val(btn.data('end_date'));
        $('#edit_is_current').prop('checked', btn.data('is_current') == '1');
        $('#edit_ay_status').val(btn.data('status'));
        $('#editAYForm').attr('action', '/admin/academic-years/' + id);
        $('#editAYModal').modal('show');
      });
    });
  </script>
@endpush
