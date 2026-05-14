@extends('admin.layouts.master_layout')

@section('pageTitle', 'Daily Cash Receipts')
@section('pageHeading', 'Daily Cash Receipts')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.daily_cash_receipts') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group"><label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>Payment Method</label>
                            <select name="method" class="form-control">
                                <option value="">All</option>
                                <option value="cash" {{ request('method')=='cash'?'selected':'' }}>Cash</option>
                                <option value="bank" {{ request('method')=='bank'?'selected':'' }}>Bank</option>
                                <option value="check" {{ request('method')=='check'?'selected':'' }}>Check</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.daily_cash_receipts') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.reports._print_layout', ['reportTitle' => 'Daily Cash Receipts', 'reportSubtitle' => $date])

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th><th>Time</th><th>Student</th><th>Method</th><th>Invoice</th><th>Amount</th><th>Receiver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->payment_date ? \Carbon\Carbon::parse($p->payment_date)->format('H:i') : '-' }}</td>
                                    <td>{{ optional($p->student)->latin_name ?? '-' }}</td>
                                    <td><span class="badge badge-light">{{ $p->payment_method }}</span></td>
                                    <td>{{ optional($p->invoice)->invoice_no ?? '-' }}</td>
                                    <td class="text-right">{{ number_format($p->amount, 2) }}</td>
                                    <td>{{ optional($p->receiver)->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">No receipts for this date.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right"><strong>Grand Total: {{ number_format($grandTotal, 2) }}</strong></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Summary by Method</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Method</th><th class="text-right">Total</th></tr></thead>
                        <tbody>
                            @forelse ($totalsByMethod as $m => $t)
                                <tr><td>{{ ucfirst($m) }}</td><td class="text-right">{{ number_format($t, 2) }}</td></tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted">-</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot><tr class="font-weight-bold"><td>Total</td><td class="text-right">{{ number_format($grandTotal, 2) }}</td></tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
