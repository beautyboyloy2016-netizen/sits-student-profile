@extends('admin.layouts.master_layout')

@section('pageTitle', 'Users - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-users mr-2"></i>{{ __('app.users') }}</h3>
      <div class="card-tools">
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add_user') }}
        </a>
      </div>
    </div>
    <div class="card-body">
      <table id="users-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.email') }}</th>
            <th>{{ __('app.phone') }}</th>
            <th>{{ __('app.roles') }}</th>
            <th width="90">{{ __('app.status') }}</th>
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
      $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users.index') }}',
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
            data: 'email',
            name: 'email'
          },
          {
            data: 'phone',
            name: 'phone'
          },
          {
            data: 'roles_list',
            name: 'roles',
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
          },
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
