@extends('admin.layouts.master_layout')

@section('pageTitle', 'Room Report')
@section('pageHeading', 'Room Report')

@section('content')
  @php($reportTitle = 'Room Report')
  @php($occupancyRate = $stats['capacity'] > 0 ? round(($stats['occupied_beds'] / $stats['capacity']) * 100, 1) : 0)

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.room_report') }}">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label>Building</label>
              <select name="building_id" class="form-control select2">
                <option value="">All Buildings</option>
                @foreach ($buildings as $building)
                  <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                    {{ $building->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['available', 'full', 'maintenance', 'inactive'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.room_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
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
          <p>Total Rooms</p>
        </div>
        <div class="icon"><i class="fas fa-door-open"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['available'] }}</h3>
          <p>Available</p>
        </div>
        <div class="icon"><i class="fas fa-check"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $stats['occupied_beds'] }}/{{ $stats['capacity'] }}</h3>
          <p>Occupied Capacity</p>
        </div>
        <div class="icon"><i class="fas fa-bed"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $occupancyRate }}%</h3>
          <p>Occupancy Rate</p>
        </div>
        <div class="icon"><i class="fas fa-chart-pie"></i></div>
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
              <th>Room</th>
              <th>Building</th>
              <th>Branch</th>
              <th>Type</th>
              <th>Capacity</th>
              <th>Occupied</th>
              <th>Monthly Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $room)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $room->room_no }}</td>
                <td>{{ optional($room->building)->name ?? '-' }}</td>
                <td>{{ optional(optional($room->building)->branch)->name_en ?? '-' }}</td>
                <td>{{ ucfirst($room->room_type) }}</td>
                <td class="text-center">{{ $room->capacity }}</td>
                <td class="text-center">{{ $room->active_assignments_count }}</td>
                <td class="text-right">{{ number_format($room->monthly_price, 2) }}</td>
                <td><span class="badge badge-light">{{ $room->status }}</span></td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">No rooms found.</td>
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
