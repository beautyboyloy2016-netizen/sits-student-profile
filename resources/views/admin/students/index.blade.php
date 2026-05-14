@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.all_students') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.all_students') }}</h3>
      <div class="card-tools">
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-user-plus mr-1"></i> {{ __('app.add_student') }}
        </a>
      </div>
    </div>
    <div class="card-body">
      <!-- Filters -->
      <div class="row mb-3">
        <div class="col-md-3">
          <select id="filter-status" class="form-control form-control-sm">
            <option value="">{{ __('app.all_status') }}</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="graduated">Graduated</option>
            <option value="suspended">Suspended</option>
            <option value="dropped">Dropped</option>
          </select>
        </div>
        <div class="col-md-3">
          <select id="filter-gender" class="form-control form-control-sm">
            <option value="">{{ __('app.all_genders') }}</option>
            @foreach ($genders as $g)
              <option value="{{ $g->id }}">{{ $g->name_kh }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button id="btn-filter" class="btn btn-secondary btn-sm"><i
              class="fas fa-filter mr-1"></i>{{ __('app.filter') }}</button>
          <button id="btn-reset" class="btn btn-light btn-sm"><i class="fas fa-undo"></i></button>
        </div>
      </div>

      <table id="students-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="45">#</th>
            <th width="50">{{ __('app.photo') }}</th>
            <th>{{ __('app.student_code') }}</th>
            <th>{{ __('app.khmer_name') }}</th>
            <th>{{ __('app.latin_name') }}</th>
            <th>{{ __('app.gender') }}</th>
            <th>{{ __('app.phone') }}</th>
            <th width="80">{{ __('app.status') }}</th>
            <th width="100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      var statusFilter = '',
        genderFilter = '';

      var table = $('#students-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('students.index') }}',
          data: function(d) {
            d.status = statusFilter;
            d.gender_id = genderFilter;
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'photo_html',
            name: 'photo_path',
            orderable: false,
            searchable: false
          },
          {
            data: 'student_code',
            name: 'student_code'
          },
          {
            data: 'khmer_name',
            name: 'khmer_name'
          },
          {
            data: 'latin_name',
            name: 'latin_name'
          },
          {
            data: 'gender_name',
            name: 'gender_id',
            searchable: false
          },
          {
            data: 'phone',
            name: 'phone'
          },
          {
            data: 'status_badge',
            name: 'status',
            searchable: false
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

      $('#btn-filter').on('click', function() {
        statusFilter = $('#filter-status').val();
        genderFilter = $('#filter-gender').val();
        table.ajax.reload();
      });
      $('#btn-reset').on('click', function() {
        statusFilter = '';
        genderFilter = '';
        $('#filter-status, #filter-gender').val('');
        table.search('').ajax.reload();
      });
    });
  </script>
@endpush
