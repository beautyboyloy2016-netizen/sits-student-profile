{{-- Reusable report filter card. Usage: include('admin.reports._filter_card', compact('reportTitle')) and then @yield('filters') or @stack('filters') inside your view. --}}
<div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-1"></i> {{ $reportTitle ?? 'Report Filters' }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
