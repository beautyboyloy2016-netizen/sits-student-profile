@extends('admin.layouts.print_layout')

@section('pageTitle', __('app.diploma') . ' - ' . $student->khmer_name)

@section('styles')
<style>
  .diploma-page {
    max-width: 900px;
    margin: 0 auto;
    border: 10px double #1a3c6e;
    padding: 55px 70px;
    background: #fff;
    position: relative;
    font-family: 'Georgia', 'Times New Roman', serif;
    text-align: center;
  }
  .diploma-page::before {
    content: '';
    position: absolute;
    top: 14px; left: 14px; right: 14px; bottom: 14px;
    border: 2px solid #1a3c6e;
    pointer-events: none;
  }
  .dip-org {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a3c6e;
    text-transform: uppercase;
    letter-spacing: 1.5px;
  }
  .dip-title {
    font-size: 2.4rem;
    font-weight: 700;
    color: #1a3c6e;
    margin: 35px 0 12px;
    text-transform: uppercase;
    letter-spacing: 3px;
  }
  .dip-subtitle {
    font-size: 1.05rem;
    color: #555;
    margin-bottom: 35px;
  }
  .dip-recipient {
    font-size: 1.7rem;
    font-weight: 700;
    color: #222;
    margin: 25px 0;
    border-bottom: 2px solid #1a3c6e;
    display: inline-block;
    padding: 0 30px 8px;
  }
  .dip-body {
    font-size: 1.1rem;
    color: #444;
    line-height: 1.9;
    margin: 30px 0;
  }
  .dip-details {
    display: flex;
    justify-content: center;
    gap: 50px;
    margin: 30px 0;
    flex-wrap: wrap;
  }
  .dip-detail-item {
    text-align: center;
  }
  .dip-detail-label {
    font-size: 0.85rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
  }
  .dip-detail-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a3c6e;
  }
  .dip-meta {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
  .dip-meta-item {
    text-align: center;
    min-width: 200px;
  }
  .dip-meta-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 6px;
  }
  .dip-meta-value {
    font-size: 1rem;
    font-weight: 600;
    color: #222;
  }
  .dip-seal {
    width: 100px;
    height: 100px;
    border: 3px dashed #1a3c6e;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1a3c6e;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
  }
  @media print {
    .diploma-page { border: 10px double #1a3c6e !important; }
  }
</style>
@endsection

@section('content')
  <div class="diploma-page">
    <div class="dip-org">{{ config('app.name') }}</div>
    <div style="font-size: 0.9rem; color: #666; margin-bottom: 10px;">{{ __('app.official_diploma') }}</div>

    <div class="dip-title">{{ __('app.diploma') }}</div>
    <div class="dip-subtitle">{{ __('app.conferred_upon') }}</div>

    <div class="dip-recipient">{{ $student->khmer_name }}</div>
    @if ($student->latin_name)
      <div style="font-size: 0.95rem; color: #666; margin-top: 4px;">{{ $student->latin_name }}</div>
    @endif

    <div class="dip-body">
      {!! nl2br(e($diploma->description ?? __('app.default_diploma_text'))) !!}
    </div>

    <div class="dip-details">
      @if ($diploma->grade)
        <div class="dip-detail-item">
          <div class="dip-detail-label">{{ __('app.grade') }}</div>
          <div class="dip-detail-value">{{ $diploma->grade }}</div>
        </div>
      @endif
      @if ($diploma->gpa !== null)
        <div class="dip-detail-item">
          <div class="dip-detail-label">{{ __('app.gpa') }}</div>
          <div class="dip-detail-value">{{ number_format($diploma->gpa, 2) }}</div>
        </div>
      @endif
      @if ($diploma->graduation_date)
        <div class="dip-detail-item">
          <div class="dip-detail-label">{{ __('app.graduation_date') }}</div>
          <div class="dip-detail-value">{{ \Carbon\Carbon::parse($diploma->graduation_date)->format('d/m/Y') }}</div>
        </div>
      @endif
    </div>

    <div class="dip-meta">
      <div class="dip-meta-item">
        <div class="dip-meta-label">{{ __('app.diploma_no') }}</div>
        <div class="dip-meta-value">{{ $diploma->diploma_no }}</div>
      </div>
      <div class="dip-meta-item">
        <div class="dip-seal">{{ __('app.seal') }}</div>
      </div>
      <div class="dip-meta-item">
        <div class="dip-meta-label">{{ __('app.issue_date') }}</div>
        <div class="dip-meta-value">{{ $diploma->issue_date ? \Carbon\Carbon::parse($diploma->issue_date)->format('d/m/Y') : '—' }}</div>
      </div>
    </div>
  </div>
@endsection
