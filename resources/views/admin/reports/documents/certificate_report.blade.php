@extends('admin.layouts.master_layout')

@section('pageTitle', 'Certificate Report')
@section('pageHeading', 'Certificate Report')

@section('content')
  @php($reportTitle = 'Certificate Report')

  <div class="card card-outline card-primary mb-3 no-print">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filters</h3>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('reports.certificate_report') }}">
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
              <label>Certificate Type</label>
              <select name="certificate_type" class="form-control">
                <option value="">All</option>
                @foreach (['appreciation', 'achievement', 'participation', 'completion', 'excellent_student', 'other'] as $type)
                  <option value="{{ $type }}" {{ request('certificate_type') === $type ? 'selected' : '' }}>
                    {{ ucwords(str_replace('_', ' ', $type)) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                @foreach (['draft', 'approved', 'printed', 'cancelled'] as $status)
                  <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="text-right">
          <a href="{{ route('reports.certificate_report') }}" class="btn btn-sm btn-default mr-1">Reset</a>
          <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>View</button>
          <button type="button" onclick="window.print()" class="btn btn-sm btn-info"><i
              class="fas fa-print mr-1"></i>Print</button>
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
          <p>Total Certificates</p>
        </div>
        <div class="icon"><i class="fas fa-certificate"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $stats['approved'] }}</h3>
          <p>Approved</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $stats['printed'] }}</h3>
          <p>Printed</p>
        </div>
        <div class="icon"><i class="fas fa-print"></i></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3>{{ $stats['draft'] }}</h3>
          <p>Draft</p>
        </div>
        <div class="icon"><i class="fas fa-file-alt"></i></div>
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
              <th>Certificate No</th>
              <th>Student</th>
              <th>Type</th>
              <th>Class</th>
              <th>Issue Date</th>
              <th>Status</th>
              <th>Approver</th>
              <th>Prints</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $certificate)
              <tr>
                <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                <td>{{ $certificate->certificate_no }}</td>
                <td>{{ optional($certificate->student)->student_code }} -
                  {{ optional($certificate->student)->latin_name ?? (optional($certificate->student)->khmer_name ?? '-') }}
                </td>
                <td>{{ ucwords(str_replace('_', ' ', $certificate->certificate_type)) }}</td>
                <td>{{ optional($certificate->class)->class_code ?? '-' }}</td>
                <td>{{ optional($certificate->issue_date)?->format('d/m/Y') }}</td>
                <td><span class="badge badge-light">{{ $certificate->status }}</span></td>
                <td>{{ optional($certificate->approver)->name ?? '-' }}</td>
                <td class="text-center">{{ $certificate->print_count }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">No certificates found.</td>
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
