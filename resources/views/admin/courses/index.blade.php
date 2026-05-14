@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.courses') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.courses') }}</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCourseModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <table id="courses-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.description') }}</th>
            <th width="70">Classes</th>
            <th width="80">{{ __('app.status') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <!-- Add Course Modal -->
  <div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.courses') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>{{ __('app.description') }}</label>
              <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            <div class="form-group">
              <label>{{ __('app.status') }}</label>
              <select name="status" class="form-control tom-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
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

  <!-- Edit Course Modal -->
  <div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="editCourseForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">{{ __('app.edit') }} {{ __('app.courses') }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" id="edit_course_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>{{ __('app.description') }}</label>
              <textarea name="description" id="edit_course_desc" class="form-control" rows="2"></textarea>
            </div>
            <div class="form-group">
              <label>{{ __('app.status') }}</label>
              <select name="status" id="edit_course_status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
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
      var table = $('#courses-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('courses.index') }}',
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
            data: 'description',
            name: 'description'
          },
          {
            data: 'classes_count',
            name: 'classes_count',
            searchable: false,
            className: 'text-center'
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

      $(document).on('click', '.btn-edit-course', function() {
        var btn = $(this);
        $('#edit_course_name').val(btn.data('name'));
        $('#edit_course_desc').val(btn.data('description'));
        $('#edit_course_status').val(btn.data('status'));
        $('#editCourseForm').attr('action', '/admin/courses/' + btn.data('id'));
        $('#editCourseModal').modal('show');
      });
    });
  </script>
@endpush
