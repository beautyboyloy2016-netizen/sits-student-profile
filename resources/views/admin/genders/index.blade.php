@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.genders') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.genders') }}</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addGenderModal">
          <i class="fas fa-plus mr-1"></i> {{ __('app.add') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <table id="genders-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name_kh') }}</th>
            <th>{{ __('app.name_en') }}</th>
            <th width="80">{{ __('app.sort_order') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <!-- Add Gender Modal -->
  <div class="modal fade" id="addGenderModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('genders.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white"><i class="fas fa-plus mr-2"></i>{{ __('app.add') }} {{ __('app.genders') }}
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('app.name_kh') }} <span class="text-danger">*</span></label>
              <input type="text" name="name_kh" class="form-control" required placeholder="ឈ្មោះភេទ">
            </div>
            <div class="form-group">
              <label>{{ __('app.name_en') }} <span class="text-danger">*</span></label>
              <input type="text" name="name_en" class="form-control" required placeholder="Gender Name">
            </div>
            <div class="form-group">
              <label>{{ __('app.sort_order') }}</label>
              <input type="number" name="sort_order" class="form-control" value="0" min="0">
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

  <!-- Edit Gender Modal -->
  <div class="modal fade" id="editGenderModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="editGenderForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>{{ __('app.edit') }} {{ __('app.genders') }}</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit_gender_id">
            <div class="form-group">
              <label>{{ __('app.name_kh') }} <span class="text-danger">*</span></label>
              <input type="text" name="name_kh" id="edit_name_kh" class="form-control" required>
            </div>
            <div class="form-group">
              <label>{{ __('app.name_en') }} <span class="text-danger">*</span></label>
              <input type="text" name="name_en" id="edit_name_en" class="form-control" required>
            </div>
            <div class="form-group">
              <label>{{ __('app.sort_order') }}</label>
              <input type="number" name="sort_order" id="edit_sort_order" class="form-control" value="0"
                min="0">
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
      var table = $('#genders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('genders.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name_kh',
            name: 'name_kh'
          },
          {
            data: 'name_en',
            name: 'name_en'
          },
          {
            data: 'sort_order',
            name: 'sort_order',
            className: 'text-center'
          },
          {
            data: 'action',
            name: 'action',
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
        order: [
          [3, 'asc']
        ],
      });

      // Edit modal trigger
      $(document).on('click', '.btn-edit-gender', function() {
        var btn = $(this);
        $('#edit_gender_id').val(btn.data('id'));
        $('#edit_name_kh').val(btn.data('name_kh'));
        $('#edit_name_en').val(btn.data('name_en'));
        $('#edit_sort_order').val(btn.data('sort_order'));
        $('#editGenderForm').attr('action', '/admin/genders/' + btn.data('id'));
        $('#editGenderModal').modal('show');
      });
    });
  </script>
@endpush
