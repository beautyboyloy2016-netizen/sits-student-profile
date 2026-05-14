@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.guardians') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.guardians') }}</h3>
      <div class="card-tools">
        <a href="{{ route('guardians.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </a>
      </div>
    </div>
    <div class="card-body">
      <table id="guardians-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name_kh') }}</th>
            <th>{{ __('app.name_en') }}</th>
            <th>{{ __('app.phone') }}</th>
            <th>Occupation</th>
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
      $('#guardians-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('guardians.index') }}',
        columns: [{
            data: 'DT_RowIndex',
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
            data: 'phone',
            name: 'phone'
          },
          {
            data: 'occupation',
            name: 'occupation'
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
    });
  </script>
@endpush
