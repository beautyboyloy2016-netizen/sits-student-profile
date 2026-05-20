@extends('admin.layouts.master_layout')

@section('pageTitle', 'Audit Log Report')
@section('pageHeading', 'Audit Log Report')

@section('content')
  @php($reportTitle = 'Audit Log Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.audit_log_report') }}">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group"><label>From</label><input type="date" name="from" class="form-control"
                value="{{ $from }}"></div>
          </div>
          <div class="col-md-2">
            <div class="form-group"><label>To</label><input type="date" name="to" class="form-control"
                value="{{ $to }}"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Action</label>
              <select name="action" class="form-control">
                <option value="">All</option>
                @foreach (['created', 'updated', 'deleted', 'restored'] as $action)
                  <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                    {{ ucfirst($action) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Table</label>
              <select name="table_name" class="form-control select2">
                <option value="">All Tables</option>
                @foreach ($tableOptions as $tableName)
                  <option value="{{ $tableName }}" {{ request('table_name') === $tableName ? 'selected' : '' }}>
                    {{ $tableName }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-2 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.audit_log_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  @include('admin.reports._print_layout', [
      'reportTitle' => $reportTitle,
      'reportSubtitle' => $from . ' to ' . $to,
  ])

  <div class="row mb-3">
    <div class="col-md-3">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $stats['total'] }}</h3>
          <p>Total Logs</p>
        </div>
        <div class="icon"><i class="fas fa-history"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['created'] }}</h3>
          <p>Created</p>
        </div>
        <div class="icon"><i class="fas fa-plus-circle"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['updated'] }}</h3>
          <p>Updated</p>
        </div>
        <div class="icon"><i class="fas fa-edit"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $stats['deleted'] }}</h3>
          <p>Deleted</p>
        </div>
        <div class="icon"><i class="fas fa-trash"></i></div>
      </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">By Action</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <thead>
              <tr>
                <th>Action</th>
                <th class="text-right">Count</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($actionTotals as $action => $count)
                <tr>
                  <td>{{ ucfirst($action) }}</td>
                  <td class="text-right">{{ $count }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="2" class="text-center text-muted">No activity.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Top Tables</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <thead>
              <tr>
                <th>Table</th>
                <th class="text-right">Count</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($topTables as $tableName => $count)
                <tr>
                  <td>{{ $tableName }}</td>
                  <td class="text-right">{{ $count }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="2" class="text-center text-muted">No activity.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
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
              <th>Time</th>
              <th>User</th>
              <th>Action</th>
              <th>Table</th>
              <th>Record</th>
              <th>IP</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $log)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $log->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                <td>{{ optional($log->user)->name ?? '-' }}</td>
                <td><span class="badge badge-light">{{ $log->action }}</span></td>
                <td>{{ $log->table_name }}</td>
                <td>{{ $log->record_id ?? '-' }}</td>
                <td>{{ $log->ip_address ?? '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted">No audit logs found.</td>
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
