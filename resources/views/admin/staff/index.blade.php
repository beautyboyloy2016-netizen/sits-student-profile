@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.staff') . ' - ' . __('app.app_name'))
@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.staff') }}</h3>
      <div class="card-tools">
        <a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }}
        </a>
      </div>
    </div>
    <div class="card-body">
      <table id="staff-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>{{ __('app.staff_code') ?? 'Code' }}</th>
            <th>{{ __('app.name_kh') }}</th>
            <th>{{ __('app.name_en') }}</th>
            <th>{{ __('app.gender') }}</th>
            <th>Position</th>
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
      $('#staff-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('staff.index') }}',
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'staff_code',
            name: 'staff_code'
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
            data: 'gender_name',
            name: 'gender_id',
            searchable: false
          },
          {
            data: 'position',
            name: 'position'
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
