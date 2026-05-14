@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.permissions') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-key mr-2"></i>{{ __('app.permissions') }}</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPermissionModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <table id="permissions-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.module') }}</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.display_name') }}</th>
            <th>{{ __('app.description') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <!-- Add Permission Modal -->
  <div class="modal fade" id="addPermissionModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.permission') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group"><label>{{ __('app.name') }} (system) <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" placeholder="e.g. students.view" required>
            </div>
            <div class="form-group"><label>{{ __('app.module') }} <span class="text-danger">*</span></label>
              <input type="text" name="module" class="form-control" placeholder="e.g. students" required>
            </div>
            <div class="form-group"><label>{{ __('app.display_name') }} <span class="text-danger">*</span></label>
              <input type="text" name="display_name" class="form-control" required>
            </div>
            <div class="form-group"><label>{{ __('app.description') }}</label>
              <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Permission Modal -->
  <div class="modal fade" id="editPermissionModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="editPermissionForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">{{ __('app.edit') }} {{ __('app.permission') }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group"><label>{{ __('app.name') }} (system) <span class="text-danger">*</span></label>
              <input type="text" name="name" id="editPermName" class="form-control" required>
            </div>
            <div class="form-group"><label>{{ __('app.module') }} <span class="text-danger">*</span></label>
              <input type="text" name="module" id="editPermModule" class="form-control" required>
            </div>
            <div class="form-group"><label>{{ __('app.display_name') }} <span class="text-danger">*</span></label>
              <input type="text" name="display_name" id="editPermDisplayName" class="form-control" required>
            </div>
            <div class="form-group"><label>{{ __('app.description') }}</label>
              <textarea name="description" id="editPermDescription" class="form-control" rows="2"></textarea>
            </div>
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
      $('#permissions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('permissions.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'module',
            name: 'module'
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'display_name',
            name: 'display_name'
          },
          {
            data: 'description',
            name: 'description'
          },
          {
            data: 'action',
            orderable: false,
            searchable: false,
            className: 'text-center'
          },
        ],
        language: {
          url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') +
            '.json'
        },
        responsive: true,
        pageLength: 20,
      });

      $(document).on('click', '.btn-edit-permission', function() {
        var btn = $(this);
        $('#editPermName').val(btn.data('name'));
        $('#editPermModule').val(btn.data('module'));
        $('#editPermDisplayName').val(btn.data('display_name'));
        $('#editPermDescription').val(btn.data('description'));
        $('#editPermissionForm').attr('action', '/admin/permissions/' + btn.data('id'));
        $('#editPermissionModal').modal('show');
      });
    });
  </script>
@endpush
