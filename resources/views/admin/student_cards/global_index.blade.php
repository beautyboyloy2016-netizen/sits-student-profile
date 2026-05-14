@extends('admin.layouts.master_layout')

@section('title', 'All Student Cards')

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">Student Cards</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Student Cards</li>
      </ol>
    </div>
  </div>

  <div class="card card-outline card-primary mb-3">
    <div class="card-body">
      <form action="{{ route('student-cards.index') }}" method="GET" class="form-inline">
        <div class="input-group w-100">
          <input type="text" name="search" class="form-control"
            placeholder="{{ __('app.search_student_placeholder') }}"
            value="{{ request('search') }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i> {{ __('app.search') }}
            </button>
            @if (request('search'))
              <a href="{{ route('student-cards.index') }}" class="btn btn-default">
                <i class="fas fa-times"></i> {{ __('app.reset') }}
              </a>
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>

  <form action="{{ route('student-cards.bulk-print') }}" method="POST" target="_blank">
    @csrf
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">All Student Cards ({{ $cards->total() }})</h3>
        <button type="submit" class="btn btn-primary btn-sm">
          <i class="fas fa-print"></i> {{ __('app.print_selected') }}
        </button>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th style="width: 40px;">
                <input type="checkbox" id="select-all-cards">
              </th>
              <th>#</th>
              <th>Card No</th>
              <th>Student</th>
              <th>Template</th>
              <th>Issue Date</th>
              <th>Expire Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($cards as $card)
              <tr>
                <td>
                  <input type="checkbox" name="card_ids[]" value="{{ $card->id }}" class="card-checkbox">
                </td>
                <td>{{ $cards->firstItem() + $loop->index }}</td>
                <td>{{ $card->card_no }}</td>
                <td>
                  @if ($card->student)
                    <a href="{{ route('students.show', $card->student) }}">{{ $card->student->khmer_name }}</a>
                  @else
                    <span class="text-muted">N/A</span>
                  @endif
                </td>
                <td>{{ $card->template?->name ?? '—' }}</td>
                <td>{{ $card->issue_date ? \Carbon\Carbon::parse($card->issue_date)->format('d/m/Y') : '—' }}</td>
                <td>{{ $card->expire_date ? \Carbon\Carbon::parse($card->expire_date)->format('d/m/Y') : '—' }}</td>
                <td>
                  <span class="badge badge-{{ $card->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($card->status) }}
                  </span>
                </td>
                <td>
                  @if ($card->student)
                    <a href="{{ route('students.cards.index', $card->student) }}" class="btn btn-xs btn-info">
                      <i class="fas fa-eye"></i> View
                    </a>
                    <a href="{{ route('students.cards.print', [$card->student, $card]) }}" target="_blank" class="btn btn-xs btn-primary">
                      <i class="fas fa-print"></i> Print
                    </a>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">No student cards found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($cards->hasPages())
        <div class="card-footer clearfix">
          {{ $cards->links() }}
        </div>
      @endif
    </div>
  </form>
@endsection

@push('scripts')
<script>
  document.getElementById('select-all-cards').addEventListener('change', function () {
    const checked = this.checked;
    document.querySelectorAll('.card-checkbox').forEach(function (cb) {
      cb.checked = checked;
    });
  });
</script>
@endpush
