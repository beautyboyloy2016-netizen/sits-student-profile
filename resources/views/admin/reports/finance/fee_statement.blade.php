@extends('admin.layouts.master_layout')

@section('pageTitle', 'Student Fee Statement')
@section('pageHeading', 'Student Fee Statement')

@section('content')
    <div class="card card-outline card-primary mb-3 no-print">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-1"></i> Select Student</h3></div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.fee_statement') }}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Student <span class="text-danger">*</span></label>
                            <select name="student_id" class="form-control select2" required>
                                <option value="">-- Choose Student --</option>
                                @foreach ($students as $s)
                                    <option value="{{ $s->id }}" {{ request('student_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->student_code }} · {{ $s->latin_name }} {{ $s->khmer_name ? '('.$s->khmer_name.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('reports.fee_statement') }}" class="btn btn-sm btn-default mr-1">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
                    <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>

    @if ($student)
        @include('admin.reports._print_layout', ['reportTitle' => 'Fee Statement', 'reportSubtitle' => $student->student_code . ' · ' . $student->latin_name])

        <div class="row mb-3">
            <div class="col-md-4"><div class="small-box bg-info"><div class="inner"><h4>${{ number_format($totals['invoiced'], 2) }}</h4><p>Total Invoiced</p></div></div></div>
            <div class="col-md-4"><div class="small-box bg-success"><div class="inner"><h4>${{ number_format($totals['paid'], 2) }}</h4><p>Total Paid</p></div></div></div>
            <div class="col-md-4"><div class="small-box bg-danger"><div class="inner"><h4>${{ number_format($totals['balance'], 2) }}</h4><p>Outstanding Balance</p></div></div></div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header"><strong>Invoices</strong></div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="thead-light"><tr><th>Date</th><th>Invoice #</th><th>Items</th><th class="text-right">Total</th><th class="text-right">Balance</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach ($invoices as $inv)
                                    <tr>
                                        <td>{{ optional($inv->invoice_date)?->format('d/m/Y') }}</td>
                                        <td>{{ $inv->invoice_no }}</td>
                                        <td>
                                            @foreach ($inv->items as $it)
                                                <span class="badge badge-light">{{ optional($it->feeType)->name ?? 'Other' }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-right">{{ number_format($inv->total_amount, 2) }}</td>
                                        <td class="text-right">{{ number_format($inv->balance, 2) }}</td>
                                        <td><span class="badge badge-{{ $inv->status === 'paid' ? 'success' : ($inv->status === 'partial' ? 'warning' : 'danger') }}">{{ $inv->status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header"><strong>Payments</strong></div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="thead-light"><tr><th>Date</th><th>Invoice</th><th class="text-right">Amount</th><th>Method</th></tr></thead>
                            <tbody>
                                @foreach ($payments as $p)
                                    <tr>
                                        <td>{{ optional($p->payment_date)?->format('d/m/Y') }}</td>
                                        <td>{{ optional($p->invoice)->invoice_no ?? '-' }}</td>
                                        <td class="text-right">{{ number_format($p->amount, 2) }}</td>
                                        <td>{{ $p->payment_method }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
