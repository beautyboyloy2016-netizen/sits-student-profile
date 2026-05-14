{{-- Reusable wrapper for printable reports.
     Provides consistent header (branch info + title + date) and print CSS. --}}
@php
    $branch = $branch ?? (\App\Models\Branch::find(current_branch_id()));
@endphp
<style media="print">
    body { background: #fff !important; }
    .no-print, .main-sidebar, .main-header, .main-footer, .content-header { display: none !important; }
    .content-wrapper { margin-left: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
    @page { margin: 1cm; }
</style>

<div class="report-print-header text-center mb-3">
    @if ($branch)
        <h4 class="mb-0">{{ $branch->name_en }} @if ($branch->name_kh)<small>({{ $branch->name_kh }})</small>@endif</h4>
        <small class="text-muted">{{ $branch->address }} @if ($branch->phone) · {{ $branch->phone }}@endif</small>
    @else
        <h4 class="mb-0">{{ config('app.name') }}</h4>
    @endif
    <h5 class="mt-2 mb-0"><strong>{{ $reportTitle ?? '' }}</strong></h5>
    @isset($reportSubtitle)
        <small class="text-muted">{{ $reportSubtitle }}</small><br>
    @endisset
    <small class="text-muted">Generated: {{ now()->format('d/m/Y H:i') }} · By: {{ auth()->user()->name ?? '' }}</small>
</div>
