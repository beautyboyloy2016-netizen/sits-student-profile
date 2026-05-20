@extends('admin.layouts.master_layout')

@section('pageTitle', 'Payment Report')
@section('pageHeading', 'Payment Report')

@section('content')
  @php($reportTitle = 'Payment Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.payment_report') }}">
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
              <label>Method</label>
              <select name="method" class="form-control">
                <option value="">All</option>
                @foreach (['cash', 'bank', 'aba', 'wing', 'other'] as $method)
                  <option value="{{ $method }}" {{ request('method') === $method ? 'selected' : '' }}>
                    {{ strtoupper($method) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end justify-content-end">
            <div class="mb-3">
              <a href="{{ route('reports.payment_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
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
    <div class="col-md-4">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ number_format($stats['grand_total'], 2) }}</h3>
          <p>Total Amount</p>
        </div>
        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $stats['count'] }}</h3>
          <p>Payments</p>
        </div>
        <div class="icon"><i class="fas fa-receipt"></i></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['students'] }}</h3>
          <p>Students Covered</p>
        </div>
        <div class="icon"><i class="fas fa-user-graduate"></i></div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm mb-0">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Payment No</th>
                  <th>Date</th>
                  <th>Student</th>
                  <th>Method</th>
                  <th>Invoice</th>
                  <th>Amount</th>
                  <th>Receiver</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($rows as $payment)
                  <tr>
                    <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                    <td>{{ $payment->payment_no }}</td>
                    <td>{{ optional($payment->payment_date)?->format('d/m/Y') }}</td>
                    <td>{{ optional($payment->student)->student_code }} -
                      {{ optional($payment->student)->latin_name ?? (optional($payment->student)->khmer_name ?? '-') }}
                    </td>
                    <td><span class="badge badge-light">{{ strtoupper($payment->payment_method) }}</span></td>
                    <td>{{ optional($payment->invoice)->invoice_no ?? '-' }}</td>
                    <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ optional($payment->receiver)->name ?? '-' }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted">No payments found.</td>
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
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Method Totals</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <thead>
              <tr>
                <th>Method</th>
                <th class="text-right">Amount</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($totalsByMethod as $method => $amount)
                <tr>
                  <td>{{ strtoupper($method) }}</td>
                  <td class="text-right">{{ number_format($amount, 2) }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="2" class="text-center text-muted">No totals.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
