@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.branches') . ' - ' . __('app.app_name'))
@section('pageHeading', __('app.branches'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
  <li class="breadcrumb-item active">{{ __('app.branches') }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title"><i class="fas fa-code-branch mr-2"></i>{{ __('app.branches') }}</h3>
          <a href="{{ route('branches.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> {{ __('app.add_branch') }}
          </a>
        </div>
        <div class="card-body">
          <table id="branchesTable" class="table table-bordered table-hover table-sm" width="100%">
            <thead class="thead-light">
              <tr>
                <th width="40">#</th>
                <th width="80">{{ __('app.branch_code') }}</th>
                <th>ឈ្មោះ (ខ្មែរ)</th>
                <th>ឈ្មោះ (English)</th>
                <th width="130">ទូរស័ព្ទ</th>
                <th width="100">{{ __('app.main_branch') }}</th>
                <th width="90">{{ __('app.status') }}</th>
                <th width="100" class="text-center">{{ __('app.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Branch Switch Panel --}}
  <div class="row mt-2">
    <div class="col-md-6">
      <div class="card card-info card-outline">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-exchange-alt mr-1"></i> {{ __('app.switch_branch') }}</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('branches.switch') }}" method="POST" class="form-inline">
            @csrf
            <select name="branch_id" class="form-control mr-2">
              @foreach (\App\Models\Branch::active()->orderBy('sort_order')->get() as $b)
                <option value="{{ $b->id }}" {{ session('current_branch_id') == $b->id ? 'selected' : '' }}>
                  {{ $b->name_kh }} ({{ $b->code }}){{ $b->is_main ? ' ★' : '' }}
                </option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-info">
              <i class="fas fa-exchange-alt mr-1"></i> {{ __('app.switch_branch') }}
            </button>
          </form>
          @if (session('current_branch_id'))
            <small class="text-muted mt-2 d-block">
              <i class="fas fa-info-circle mr-1"></i>
              {{ __('app.current_branch') }}:
              <strong>{{ \App\Models\Branch::find(session('current_branch_id'))?->name_kh }}</strong>
            </small>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#branchesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('branches.index') }}',
        order: [
          [0, 'asc']
        ],
        pageLength: 25,
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'code',
            name: 'code'
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
            data: 'is_main_badge',
            name: 'is_main',
            orderable: false,
            searchable: false
          },
          {
            data: 'status_badge',
            name: 'status',
            orderable: false,
            searchable: false
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
        ],
      });

      // SweetAlert2 delete confirm
      $(document).on('click', '.btn-swal-delete', function() {
        const form = $(this).closest('form');
        Swal.fire({
          title: 'Delete this branch?',
          text: 'This action cannot be undone.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
          if (result.isConfirmed) form.submit();
        });
      });
    });
  </script>
@endpush
