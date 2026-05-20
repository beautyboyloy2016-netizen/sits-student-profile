@extends('admin.layouts.master_layout')

@section('pageTitle', 'Student Card Report')
@section('pageHeading', 'Student Card Report')

@section('content')
  @php($reportTitle = 'Student Card Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.student_card_report') }}">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group"><label>From</label><input type="date" name="from" class="form-control"
                value="{{ $from }}"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group"><label>To</label><input type="date" name="to" class="form-control"
                value="{{ $to }}"></div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['active', 'expired', 'lost', 'cancelled'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.student_card_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
              <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i
                  class="fas fa-print mr-1"></i>Print</button>
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
          <p>Total Cards</p>
        </div>
        <div class="icon"><i class="fas fa-id-card"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['active'] }}</h3>
          <p>Active</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $stats['expired'] }}</h3>
          <p>Expired</p>
        </div>
        <div class="icon"><i class="fas fa-hourglass-end"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $stats['lost'] }}</h3>
          <p>Lost</p>
        </div>
        <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
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
              <th>Card No</th>
              <th>Student</th>
              <th>Branch</th>
              <th>Issue Date</th>
              <th>Expire Date</th>
              <th>Issuer</th>
              <th>Prints</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $card)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $card->card_no }}</td>
                <td>{{ optional($card->student)->student_code }} -
                  {{ optional($card->student)->latin_name ?? (optional($card->student)->khmer_name ?? '-') }}</td>
                <td>{{ optional(optional($card->student)->branch)->name_en ?? '-' }}</td>
                <td>{{ optional($card->issue_date)?->format('d/m/Y') }}</td>
                <td>{{ optional($card->expire_date)?->format('d/m/Y') }}</td>
                <td>{{ optional($card->issuer)->name ?? '-' }}</td>
                <td class="text-center">{{ $card->print_count }}</td>
                <td><span class="badge badge-light">{{ $card->status }}</span></td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">No cards found.</td>
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
