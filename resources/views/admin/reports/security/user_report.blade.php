@extends('admin.layouts.master_layout')

@section('pageTitle', 'User Access Report')
@section('pageHeading', 'User Access Report')

@section('content')
  @php($reportTitle = 'User Access Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.user_report') }}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group"><label>Search</label><input type="text" name="search" class="form-control"
                value="{{ request('search') }}" placeholder="Name, email, phone, role"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['active', 'inactive', 'blocked'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.user_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
              <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i
                  class="fas fa-print mr-1"></i>Print</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  @include('admin.reports._print_layout', ['reportTitle' => $reportTitle])

  <div class="row mb-3">
    <div class="col-md-3">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $stats['total'] }}</h3>
          <p>Total Users</p>
        </div>
        <div class="icon"><i class="fas fa-users-cog"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['active'] }}</h3>
          <p>Active</p>
        </div>
        <div class="icon"><i class="fas fa-user-check"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $stats['blocked'] }}</h3>
          <p>Blocked</p>
        </div>
        <div class="icon"><i class="fas fa-user-lock"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['recent_logins'] }}</h3>
          <p>Logins in 30 Days</p>
        </div>
        <div class="icon"><i class="fas fa-clock"></i></div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm mb-0">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Contact</th>
              <th>Primary Branch</th>
              <th>Roles</th>
              <th>Extra Branches</th>
              <th>Status</th>
              <th>Last Login</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $user)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email ?? '-' }}<br><small class="text-muted">{{ $user->phone ?? '-' }}</small></td>
                <td>{{ optional($user->branch)->name_en ?? '-' }}</td>
                <td>
                  {{ $user->roles->pluck('display_name')->filter()->implode(', ') ?: $user->roles->pluck('name')->implode(', ') ?: '-' }}
                </td>
                <td>{{ $user->branches->pluck('name_en')->implode(', ') ?: '-' }}</td>
                <td><span class="badge badge-light">{{ $user->status }}</span></td>
                <td>{{ $user->last_login_at?->format('d/m/Y H:i') ?? '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No users found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if ($rows->hasPages())
      <div class="card-footer no-print">{{ $rows->links() }}</div>
    @endif
  </div>
@endsection
