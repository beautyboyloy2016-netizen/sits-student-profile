@extends('admin.layouts.print_layout')

@section('pageTitle', __('app.certificate') . ' - ' . $student->khmer_name)

@section('styles')
<style>
  .certificate-page {
    max-width: 800px;
    margin: 0 auto;
    border: 8px double #c5a059;
    padding: 50px 60px;
    background: #fff;
    position: relative;
    font-family: 'Georgia', 'Times New Roman', serif;
    text-align: center;
  }
  .certificate-page::before {
    content: '';
    position: absolute;
    top: 10px; left: 10px; right: 10px; bottom: 10px;
    border: 2px solid #c5a059;
    pointer-events: none;
  }
  .cert-logo {
    width: 80px;
    height: 80px;
    object-fit: contain;
    margin-bottom: 12px;
  }
  .cert-org {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a3c6e;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .cert-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #c5a059;
    margin: 30px 0 10px;
    text-transform: uppercase;
    letter-spacing: 2px;
  }
  .cert-subtitle {
    font-size: 1rem;
    color: #555;
    margin-bottom: 30px;
  }
  .cert-recipient {
    font-size: 1.6rem;
    font-weight: 700;
    color: #1a3c6e;
    margin: 20px 0;
    border-bottom: 1px solid #c5a059;
    display: inline-block;
    padding: 0 20px 6px;
  }
  .cert-body {
    font-size: 1.05rem;
    color: #444;
    line-height: 1.8;
    margin: 25px 0;
  }
  .cert-meta {
    margin-top: 40px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
  .cert-meta-item {
    text-align: center;
    min-width: 180px;
  }
  .cert-meta-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 6px;
  }
  .cert-meta-value {
    font-size: 1rem;
    font-weight: 600;
    color: #222;
  }
  .cert-seal {
    width: 90px;
    height: 90px;
    border: 3px dashed #c5a059;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c5a059;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 auto;
  }
  .cert-badge {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-top: 10px;
  }
  .cert-badge-draft { background: #fff3cd; color: #856404; }
  .cert-badge-approved { background: #d4edda; color: #155724; }
  .cert-badge-printed { background: #d1ecf1; color: #0c5460; }
  @media print {
    .certificate-page { border: 8px double #c5a059 !important; }
  }
</style>
@endsection

@section('content')
  <div class="certificate-page">
    <div class="cert-org">{{ config('app.name') }}</div>
    <div style="font-size: 0.9rem; color: #666; margin-bottom: 8px;">{{ __('app.official_certificate') }}</div>

    <div class="cert-title">{{ $certificate->title ?? ucwords(str_replace('_', ' ', $certificate->certificate_type)) . ' ' . __('app.certificate') }}</div>
    <div class="cert-subtitle">{{ __('app.this_certifies_that') }}</div>

    <div class="cert-recipient">{{ $student->khmer_name }}</div>
    @if ($student->latin_name)
      <div style="font-size: 0.95rem; color: #666; margin-top: 4px;">{{ $student->latin_name }}</div>
    @endif

    <div class="cert-body">
      {!! nl2br(e($certificate->description ?? __('app.default_certificate_text'))) !!}
    </div>

    <div style="margin: 20px 0;">
      <span class="cert-badge cert-badge-{{ $certificate->status }}">{{ ucfirst($certificate->status) }}</span>
    </div>

    <div class="cert-meta">
      <div class="cert-meta-item">
        <div class="cert-meta-label">{{ __('app.certificate_no') }}</div>
        <div class="cert-meta-value">{{ $certificate->certificate_no }}</div>
      </div>
      <div class="cert-meta-item">
        <div class="cert-seal">{{ __('app.seal') }}</div>
      </div>
      <div class="cert-meta-item">
        <div class="cert-meta-label">{{ __('app.issue_date') }}</div>
        <div class="cert-meta-value">{{ $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date)->format('d/m/Y') : '—' }}</div>
      </div>
    </div>
  </div>
@endsection
