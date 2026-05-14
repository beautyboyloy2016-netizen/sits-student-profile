@extends('admin.layouts.master_layout')

@section('pageTitle', 'AR Aging / Outstanding Invoices')
@section('pageHeading', 'AR Aging / Outstanding Invoices')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> As of Date</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.ar_aging') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group"><label>As of</label>
                            <input type="date" name="as_of" class="form-control" value="{{ $asOf }}" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.ar_aging') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.reports._print_layout', ['reportTitle' => 'AR Aging Report', 'reportSubtitle' => "As of $asOf"])

    <div class="row mb-3">
        @foreach (['current'=>'Current','0-30'=>'0-30 Days','31-60'=>'31-60 Days','61-90'=>'61-90 Days','90+'=>'Over 90 Days'] as $k=>$label)
            <div class="col">
                <div class="small-box bg-{{ $k === 'current' ? 'success' : ($k === '90+' ? 'danger' : 'info') }}">
                    <div class="inner">
                        <h4 class="m-0">${{ number_format($totals[$k] ?? 0, 2) }}</h4>
                        <p class="m-0">{{ $label }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @foreach (['current'=>'Current','0-30'=>'0-30 Days','31-60'=>'31-60 Days','61-90'=>'61-90 Days','90+'=>'Over 90 Days'] as $k=>$label)
        @php $list = $buckets[$k] ?? []; @endphp
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>{{ $label }}</strong> · {{ count($list) }} invoices · ${{ number_format($totals[$k] ?? 0, 2) }}
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-1">
                        <thead class="thead-light"><tr><th>Invoice #</th><th>Student</th><th>Due Date</th><th>Total</th><th>Paid</th><th class="text-danger">Balance</th></tr></thead>
                        <tbody>
                            @foreach ($list as $inv)
                                <tr>
                                    <td>{{ $inv->invoice_no }}</td>
                                    <td>{{ optional($inv->student)->latin_name ?? '-' }}</td>
                                    <td>{{ optional($inv->due_date)?->format('d/m/Y') ?? '-' }}</td>
                                    <td>{{ number_format($inv->total_amount, 2) }}</td>
                                    <td>{{ number_format($inv->paid_amount, 2) }}</td>
                                    <td class="text-right text-danger font-weight-bold">{{ number_format($inv->balance, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <div class="text-right"><h5>Total Outstanding: <strong>${{ number_format($grandBalance, 2) }}</strong></h5></div>
@endsection
