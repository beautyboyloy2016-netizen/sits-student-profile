@php
  $schoolNameKh = config('app.name_kh', 'សាលាបច្ចេកវិទ្យាព័ត៌មាន អេស អាយ ធី អេស');
  $schoolNameEn = strtoupper(config('app.name_en', config('app.name')));
  $logoExists   = file_exists(public_path('images/logo.png'));
  $logoUrl      = $logoExists ? asset('images/logo.png') : null;
  $guardian     = $student->guardians->where('pivot.is_primary', 1)->first() ?? $student->guardians->first();
  $parentPhone  = optional($guardian)->phone ?? '—';
  $studentId    = $student->student_code ?? '—';
  $studentName  = strtoupper($student->latin_name ?? $student->khmer_name ?? '—');
  $sex          = optional($student->gender)->name ?? '—';
  $dob          = $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') : '—';
  $expiry       = $card->expire_date ? \Carbon\Carbon::parse($card->expire_date)->format('d/m/Y') : '—';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Identity Card - {{ $studentName }}</title>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;700&family=Hanuman:wght@400;700&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    min-height: 100vh;
    background: #eeeeee;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 30px 10px;
    font-family: Arial, Helvetica, sans-serif;
  }

  /* Toolbar */
  .toolbar {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
  }
  .btn {
    padding: 10px 22px;
    font-size: 14px;
    font-weight: 600;
    border: 0;
    border-radius: 4px;
    cursor: pointer;
    color: #fff;
  }
  .btn-print { background: #0000ff; }
  .btn-print:hover { background: #0000cc; }
  .btn-back  { background: #6c757d; }
  .btn-back:hover  { background: #495057; }

  /* ============================================ */
  /* =========  STUDENT CARD (USER CSS)  ======== */
  /* ============================================ */
  .student-card {
    width: 994px;
    height: 610px;
    background: #ffffff;
    border: 3px solid #0070c9;
    position: relative;
    overflow: hidden;
  }

  .card-header {
    width: 100%;
    height: 137px;
    background: #0000ff;
    position: relative;
    color: #ffffff;
    text-align: center;
    z-index: 5;
  }

  .logo {
    position: absolute;
    left: 34px;
    top: 25px;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #ffffff;
    border: 4px solid #d6d6d6;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #1675c9;
    font-size: 11px;
    font-weight: bold;
    text-align: center;
    line-height: 1.1;
    overflow: hidden;
  }
  .logo::before {
    content: "";
    position: absolute;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    border: 2px solid #7caee0;
  }
  .logo span { position: relative; z-index: 2; }
  .logo img {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 50%;
  }

  .khmer-title {
    padding-top: 12px;
    font-family: "Khmer OS Muol Light", "Noto Sans Khmer", "Hanuman", Arial, sans-serif;
    font-size: 32px;
    font-weight: normal;
    letter-spacing: 1px;
    text-shadow:
      1px 0 #000000,
      -1px 0 #000000,
      0 1px #000000,
      0 -1px #000000;
  }

  .school-title {
    margin-top: 4px;
    font-size: 31px;
    font-weight: 400;
    letter-spacing: 1px;
  }

  .decor {
    position: absolute;
    left: 0;
    top: 137px;
    width: 100%;
    height: 470px;
    z-index: 1;
    pointer-events: none;
  }

  .main-title {
    position: absolute;
    top: 153px;
    left: 0;
    width: 100%;
    text-align: center;
    color: #0070d8;
    font-size: 42px;
    font-weight: 700;
    z-index: 3;
  }

  .photo-box {
    position: absolute;
    left: 48px;
    top: 220px;
    width: 263px;
    height: 334px;
    border: 3px solid #dddddd;
    background: #ffffff;
    z-index: 3;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #0070d8;
    font-size: 39px;
    font-weight: 400;
    overflow: hidden;
  }
  .photo-box img { width: 100%; height: 100%; object-fit: cover; }

  .student-info {
    position: absolute;
    left: 347px;
    top: 249px;
    z-index: 3;
    color: #0070d8;
    font-size: 35px;
    line-height: 1.4;
    font-weight: 400;
  }

  .info-row {
    display: grid;
    grid-template-columns: 235px 28px 360px;
    height: 49px;
    align-items: center;
    white-space: nowrap;
  }
  .label  { letter-spacing: -1px; }
  .colon  { font-weight: bold; text-align: center; }
  .value  { padding-left: 5px; letter-spacing: -1px; }

  /* Responsive scaling for screen */
  @media (max-width: 1050px) { .student-card { transform: scale(0.85); transform-origin: top center; } }
  @media (max-width: 850px)  { .student-card { transform: scale(0.65); transform-origin: top center; } }
  @media (max-width: 650px)  { .student-card { transform: scale(0.45); transform-origin: top center; } }

  /* Print: fit on A4 landscape */
  @page { size: A4 landscape; margin: 10mm; }
  @media print {
    body { background: #fff; padding: 0; }
    .toolbar { display: none !important; }
    .student-card {
      transform: none !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      color-adjust: exact;
    }
    .student-card * {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>
</head>
<body>

  <div class="toolbar">
    <button class="btn btn-print" onclick="window.print()">&#128424; Print</button>
    <button class="btn btn-back"  onclick="history.back()">&larr; Back</button>
  </div>

  <div class="student-card">

    <div class="card-header">
      <div class="logo">
        @if ($logoUrl)
          <img src="{{ $logoUrl }}" alt="logo">
        @else
          <span>SITS<br>LOGO</span>
        @endif
      </div>

      <div class="khmer-title">{{ $schoolNameKh }}</div>
      <div class="school-title">{{ $schoolNameEn }}</div>
    </div>

    <svg class="decor" viewBox="0 0 994 470" preserveAspectRatio="none">
      <path d="M0 0 H994 V1 H500 C250 5 135 22 0 62 Z" fill="#ff0000"/>
      <path d="M0 62 C155 30 290 14 430 11 H994 V470 H0 Z" fill="#ffffff"/>
      <path d="M350 470 C660 462 820 442 994 408 V470 Z" fill="#ff0000"/>
    </svg>

    <h1 class="main-title">Student Identity Card</h1>

    <div class="photo-box">
      @if ($student->photo_path)
        <img src="{{ Storage::url($student->photo_path) }}" alt="{{ $studentName }}">
      @else
        No Image
      @endif
    </div>

    <div class="student-info">
      <div class="info-row">
        <div class="label">Student ID</div>
        <div class="colon">:</div>
        <div class="value">{{ $studentId }}</div>
      </div>
      <div class="info-row">
        <div class="label">Name</div>
        <div class="colon">:</div>
        <div class="value">{{ $studentName }}</div>
      </div>
      <div class="info-row">
        <div class="label">Sex</div>
        <div class="colon">:</div>
        <div class="value">{{ $sex }}</div>
      </div>
      <div class="info-row">
        <div class="label">Date of birth</div>
        <div class="colon">:</div>
        <div class="value">{{ $dob }}</div>
      </div>
      <div class="info-row">
        <div class="label">Parent's phone</div>
        <div class="colon">:</div>
        <div class="value">{{ $parentPhone }}</div>
      </div>
      <div class="info-row">
        <div class="label">Expiry date</div>
        <div class="colon">:</div>
        <div class="value">{{ $expiry }}</div>
      </div>
    </div>

  </div>

</body>
</html>
