@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.roles') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-user-tag mr-2"></i>{{ __('app.roles') }}</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRoleModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <table id="roles-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.display_name') }}</th>
            <th>{{ __('app.description') }}</th>
            <th>{{ __('app.permissions') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.role') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.name') }} (system) <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control" placeholder="e.g. admin" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.display_name') }} <span class="text-danger">*</span></label>
                  <input type="text" name="display_name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group"><label>{{ __('app.description') }}</label>
              <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            @include('admin.roles._permissions_table', ['permissions' => $permissions, 'prefix' => 'add'])
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form id="editRoleForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">{{ __('app.edit') }} {{ __('app.role') }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.name') }} (system) <span class="text-danger">*</span></label>
                  <input type="text" name="name" id="editRoleName" class="form-control" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.display_name') }} <span class="text-danger">*</span></label>
                  <input type="text" name="display_name" id="editRoleDisplayName" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group"><label>{{ __('app.description') }}</label>
              <textarea name="description" id="editRoleDescription" class="form-control" rows="2"></textarea>
            </div>
            @include('admin.roles._permissions_table', ['permissions' => $permissions, 'prefix' => 'edit'])
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
      $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('roles.index') }}',
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
            data: 'display_name',
            name: 'display_name'
          },
          {
            data: 'description',
            name: 'description'
          },
          {
            data: 'permissions_count',
            name: 'permissions_count',
            searchable: false,
            className: 'text-center'
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
        pageLength: 15,
      });

      $(document).on('click', '.btn-edit-role', function() {
        var btn = $(this);
        $('#editRoleName').val(btn.data('name'));
        $('#editRoleDisplayName').val(btn.data('display_name'));
        $('#editRoleDescription').val(btn.data('description'));
        $('#editRoleForm').attr('action', '/admin/roles/' + btn.data('id'));

        // Pre-check the role's current permissions in the edit matrix
        var perms = btn.data('permissions') || [];
        // jQuery auto-parses JSON in data-* but if it's a string, parse it
        if (typeof perms === 'string') {
          try { perms = JSON.parse(perms); } catch (e) { perms = []; }
        }
        var $matrix = $('.perm-matrix[data-prefix="edit"]');
        $matrix.find('.perm-check-item').prop('checked', false);
        perms.forEach(function(id) {
          $matrix.find('.perm-check-item[value="' + id + '"]').prop('checked', true);
        });
        // Refresh group + master checkbox states
        refreshMatrixState($matrix);

        $('#editRoleModal').modal('show');
      });

      // ── Permissions matrix interactions ─────────────────────────────
      // Rule: master/group checkbox is CHECKED only when ALL its items are checked.
      // Otherwise it is UNCHECKED (no indeterminate/mixed state).
      function refreshMatrixState($matrix) {
        // For each module group, check only if every item in that module is checked
        $matrix.find('.perm-check-group').each(function() {
          var module = $(this).data('module');
          var $items = $matrix.find('.perm-check-item[data-module="' + module + '"]');
          var allChecked = $items.length > 0 && $items.filter(':checked').length === $items.length;
          $(this).prop('checked', allChecked).prop('indeterminate', false);
        });
        // Top-level master: checked only if every single item is checked
        var $all = $matrix.find('.perm-check-all');
        var $allItems = $matrix.find('.perm-check-item');
        var allItemsChecked = $allItems.length > 0 && $allItems.filter(':checked').length === $allItems.length;
        $all.prop('checked', allItemsChecked).prop('indeterminate', false);
      }

      // Master "select all" toggles every item
      $(document).on('change', '.perm-check-all', function() {
        var $matrix = $(this).closest('.perm-matrix');
        var checked = $(this).prop('checked');
        $matrix.find('.perm-check-item, .perm-check-group')
          .prop('checked', checked)
          .prop('indeterminate', false);
      });

      // Group master toggles items in that module
      $(document).on('change', '.perm-check-group', function() {
        var $matrix = $(this).closest('.perm-matrix');
        var module = $(this).data('module');
        var checked = $(this).prop('checked');
        $matrix.find('.perm-check-item[data-module="' + module + '"]').prop('checked', checked);
        refreshMatrixState($matrix);
      });

      // Item change refreshes group + master state
      $(document).on('change', '.perm-check-item', function() {
        refreshMatrixState($(this).closest('.perm-matrix'));
      });

      // Reset Add modal each time it's opened
      $('#addRoleModal').on('show.bs.modal', function() {
        var $matrix = $(this).find('.perm-matrix');
        $matrix.find('.perm-check-item, .perm-check-group, .perm-check-all')
          .prop('checked', false).prop('indeterminate', false);
      });
    });
  </script>
@endpush
