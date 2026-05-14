@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.student_update_requests') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ __('app.student_update_requests') }}</h3>
    </div>
    <div class="card-body">
      <table id="update-requests-table" class="table table-bordered table-striped table-hover w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('app.student') }}</th>
            <th>{{ __('app.field_name') }}</th>
            <th>{{ __('app.old_value') }}</th>
            <th>{{ __('app.new_value') }}</th>
            <th>{{ __('app.reason') }}</th>
            <th>{{ __('app.requested_by') }}</th>
            <th>{{ __('app.status') }}</th>
            <th>{{ __('app.actions') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function () {
      $('#update-requests-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("student-update-requests.index") }}',
        columns: [
          { data: 'DT_RowIndex', name: 'id', searchable: false, orderable: false, width: '50px' },
          { data: 'student_name', name: 'student.khmer_name' },
          { data: 'field_label', name: 'field_name' },
          { data: 'old_value_short', name: 'old_value', searchable: false },
          { data: 'new_value_short', name: 'new_value', searchable: false },
          { data: 'reason_short', name: 'reason', searchable: false },
          { data: 'requested_by_name', name: 'requester.name', searchable: false },
          { data: 'status_badge', name: 'status', searchable: false, orderable: false },
          { data: 'actions', name: 'actions', searchable: false, orderable: false },
        ],
        language: { url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') + '.json' },
        responsive: true,
        pageLength: 15,
      });
    });
  </script>
@endpush
