@extends('admin.layouts.master_layout')

@section('pageTitle', 'Revenue Report')
@section('pageHeading', 'Revenue Report')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.revenue') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group"><label>From</label>
                            <input type="date" name="from" class="form-control" value="{{ $from }}"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>To</label>
                            <input type="date" name="to" class="form-control" value="{{ $to }}"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>Group By</label>
                            <select name="group_by" class="form-control">
                                <option value="day" {{ $groupBy=='day'?'selected':'' }}>Day</option>
                                <option value="month" {{ $groupBy=='month'?'selected':'' }}>Month</option>
                                <option value="branch" {{ $groupBy=='branch'?'selected':'' }}>Branch</option>
                                <option value="fee_type" {{ $groupBy=='fee_type'?'selected':'' }}>Fee Type</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.revenue') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.reports._print_layout', ['reportTitle' => 'Revenue Report', 'reportSubtitle' => "$from to $to"])

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr><th>{{ ucfirst($groupBy) }}</th><th class="text-center">Transactions</th><th class="text-right">Total</th></tr>
                </thead>
                <tbody>
                    @forelse ($summary as $row)
                        <tr>
                            <td>{{ $row->key }}</td>
                            <td class="text-center">{{ $row->count }}</td>
                            <td class="text-right">{{ number_format($row->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No data.</td></tr>
                    @endforelse
                </tbody>
                <tfoot class="font-weight-bold">
                    <tr><td>Grand Total</td><td class="text-center">{{ $summary->sum('count') }}</td><td class="text-right">{{ number_format($grandTotal, 2) }}</td></tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
