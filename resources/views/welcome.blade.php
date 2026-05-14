<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស — School of Information Technology">

  <title>សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស</title>

  {{-- Google Fonts: Khmer + Latin --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700;900&family=Noto+Sans+Khmer:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  {{-- Bootstrap 4 CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    :root {
      --brand-primary: #0b3d91;
      --brand-primary-dark: #08306e;
      --brand-accent: #f5a623;
      --brand-accent-dark: #d98e10;
      --brand-soft: #eef3fb;
      --text-dark: #1f2937;
      --text-muted: #5b6573;
    }

    html,
    body {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Noto Sans Khmer', 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
      color: var(--text-dark);
      background-color: #ffffff;
    }

    .khmer-display {
      font-family: 'Battambang', 'Noto Sans Khmer', serif;
      line-height: 1.45;
    }

    /* ========== Top bar ========== */
    .topbar {
      background: var(--brand-primary-dark);
      color: #cfd9ee;
      font-size: 0.85rem;
    }

    .topbar a {
      color: #cfd9ee;
      text-decoration: none;
    }

    .topbar a:hover {
      color: #fff;
    }

    /* ========== Navbar ========== */
    .navbar-brand-school {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .brand-logo {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.1rem;
      box-shadow: 0 6px 16px rgba(11, 61, 145, 0.25);
      font-family: 'Poppins', sans-serif;
    }

    .brand-text-en {
      font-size: 0.72rem;
      color: var(--text-muted);
      letter-spacing: 0.6px;
      text-transform: uppercase;
      font-family: 'Poppins', sans-serif;
    }

    .brand-text-kh {
      font-family: 'Battambang', 'Noto Sans Khmer', serif;
      font-weight: 700;
      color: var(--brand-primary);
      font-size: 1.05rem;
      line-height: 1.2;
    }

    .navbar-school .nav-link {
      color: var(--text-dark) !important;
      font-weight: 500;
      padding: 0.6rem 0.95rem !important;
      position: relative;
    }

    .navbar-school .nav-link::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: 0.35rem;
      width: 0;
      height: 2px;
      background: var(--brand-accent);
      transition: width .25s ease, left .25s ease;
    }

    .navbar-school .nav-link:hover::after,
    .navbar-school .nav-link.active::after {
      width: 60%;
      left: 20%;
    }

    .navbar-school .nav-link:hover {
      color: var(--brand-primary) !important;
    }

    .btn-brand {
      background: var(--brand-primary);
      border-color: var(--brand-primary);
      color: #fff;
      font-weight: 500;
    }

    .btn-brand:hover {
      background: var(--brand-primary-dark);
      border-color: var(--brand-primary-dark);
      color: #fff;
    }

    .btn-outline-brand {
      color: var(--brand-primary);
      border: 1px solid var(--brand-primary);
      background: transparent;
      font-weight: 500;
    }

    .btn-outline-brand:hover {
      background: var(--brand-primary);
      color: #fff;
    }

    .btn-accent {
      background: var(--brand-accent);
      border-color: var(--brand-accent);
      color: #1b1b18;
      font-weight: 600;
    }

    .btn-accent:hover {
      background: var(--brand-accent-dark);
      border-color: var(--brand-accent-dark);
      color: #1b1b18;
    }

    /* ========== Hero ========== */
    .hero {
      position: relative;
      background:
        radial-gradient(1200px 500px at 90% -10%, rgba(245, 166, 35, 0.18), transparent 60%),
        radial-gradient(900px 600px at -10% 110%, rgba(11, 61, 145, 0.18), transparent 60%),
        linear-gradient(180deg, #f7faff 0%, #eef3fb 100%);
      padding: 90px 0 110px;
      overflow: hidden;
    }

    .hero-eyebrow {
      display: inline-block;
      background: rgba(11, 61, 145, 0.08);
      color: var(--brand-primary);
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.4px;
      margin-bottom: 1rem;
    }

    .hero-title {
      font-size: clamp(1.9rem, 3.2vw, 3rem);
      font-weight: 900;
      color: var(--brand-primary-dark);
      margin-bottom: 1rem;
    }

    .hero-sub {
      color: var(--text-muted);
      font-size: 1.05rem;
      line-height: 1.7;
      max-width: 560px;
    }

    .hero-illustration {
      position: relative;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 30px 60px -20px rgba(11, 61, 145, 0.35);
      background: linear-gradient(135deg, #0b3d91, #1e63d8);
      min-height: 360px;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .hero-illustration::before,
    .hero-illustration::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.08);
    }

    .hero-illustration::before {
      width: 220px;
      height: 220px;
      top: -60px;
      right: -60px;
    }

    .hero-illustration::after {
      width: 160px;
      height: 160px;
      bottom: -50px;
      left: -50px;
      background: rgba(245, 166, 35, 0.25);
    }

    .hero-illustration .stack-icon {
      font-size: 5.5rem;
      opacity: 0.95;
      text-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    .hero-stat-card {
      position: absolute;
      background: #fff;
      color: var(--text-dark);
      padding: 14px 18px;
      border-radius: 12px;
      box-shadow: 0 12px 30px rgba(11, 61, 145, 0.18);
      display: flex;
      align-items: center;
      gap: 12px;
      font-family: 'Poppins', sans-serif;
    }

    .hero-stat-card .icon-wrap {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: var(--brand-soft);
      color: var(--brand-primary);
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .hero-stat-card .num {
      font-weight: 700;
      font-size: 1.1rem;
      line-height: 1;
    }

    .hero-stat-card .lbl {
      font-size: 0.78rem;
      color: var(--text-muted);
    }

    .hero-stat-tl {
      top: 24px;
      left: -16px;
    }

    .hero-stat-br {
      bottom: 24px;
      right: -16px;
    }

    /* ========== Section helpers ========== */
    section {
      padding: 80px 0;
    }

    .section-eyebrow {
      color: var(--brand-accent-dark);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      font-size: 0.78rem;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      margin-bottom: 0.5rem;
    }

    .section-title {
      font-weight: 800;
      color: var(--brand-primary-dark);
      margin-bottom: 0.6rem;
    }

    .section-lead {
      color: var(--text-muted);
      max-width: 720px;
      margin: 0 auto;
    }

    /* ========== Feature cards ========== */
    .feature-card {
      background: #fff;
      border: 1px solid #eaeef5;
      border-radius: 14px;
      padding: 28px 24px;
      height: 100%;
      transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 40px -18px rgba(11, 61, 145, 0.35);
      border-color: #d6e0f3;
    }

    .feature-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      background: var(--brand-soft);
      color: var(--brand-primary);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      margin-bottom: 1rem;
    }

    .feature-card h5 {
      font-weight: 700;
      color: var(--brand-primary-dark);
    }

    .feature-card p {
      color: var(--text-muted);
      margin-bottom: 0;
      font-size: 0.95rem;
    }

    /* ========== Programs ========== */
    .programs {
      background: #f7faff;
    }

    .program-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid #eaeef5;
      height: 100%;
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .program-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 40px -18px rgba(11, 61, 145, 0.35);
    }

    .program-banner {
      height: 120px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 2.6rem;
      position: relative;
      overflow: hidden;
    }

    .pb-1 {
      background: linear-gradient(135deg, #0b3d91, #1e63d8);
    }

    .pb-2 {
      background: linear-gradient(135deg, #d98e10, #f5a623);
    }

    .pb-3 {
      background: linear-gradient(135deg, #0e9f6e, #34d399);
    }

    .pb-4 {
      background: linear-gradient(135deg, #b91c1c, #ef4444);
    }

    .pb-5 {
      background: linear-gradient(135deg, #6d28d9, #a78bfa);
    }

    .pb-6 {
      background: linear-gradient(135deg, #0e7490, #06b6d4);
    }

    .program-body {
      padding: 22px 22px 24px;
    }

    .program-body h5 {
      font-weight: 700;
      color: var(--brand-primary-dark);
      margin-bottom: 0.5rem;
    }

    .program-body p {
      color: var(--text-muted);
      font-size: 0.92rem;
      margin-bottom: 1rem;
    }

    .program-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.82rem;
      color: var(--text-muted);
      border-top: 1px dashed #e3e9f3;
      padding-top: 12px;
    }

    .program-meta .badge-soft {
      background: var(--brand-soft);
      color: var(--brand-primary);
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 999px;
    }

    /* ========== Stats / CTA ========== */
    .stats-band {
      background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-dark));
      color: #fff;
      border-radius: 18px;
      padding: 40px 24px;
    }

    .stat-num {
      font-family: 'Poppins', sans-serif;
      font-weight: 800;
      font-size: 2.2rem;
      line-height: 1;
    }

    .stat-lbl {
      color: #cfd9ee;
      font-size: 0.9rem;
      margin-top: 6px;
    }

    /* ========== News ========== */
    .news-card {
      background: #fff;
      border: 1px solid #eaeef5;
      border-radius: 14px;
      overflow: hidden;
      height: 100%;
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .news-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 40px -18px rgba(11, 61, 145, 0.35);
    }

    .news-thumb {
      height: 180px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 2.4rem;
      background: linear-gradient(135deg, #0b3d91, #f5a623);
    }

    .news-body {
      padding: 20px 22px 24px;
    }

    .news-date {
      font-size: 0.78rem;
      color: var(--brand-accent-dark);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.6px;
    }

    .news-body h6 {
      font-weight: 700;
      color: var(--brand-primary-dark);
      margin: 6px 0 8px;
    }

    .news-body p {
      color: var(--text-muted);
      font-size: 0.92rem;
      margin-bottom: 12px;
    }

    .news-body a.read-more {
      color: var(--brand-primary);
      font-weight: 600;
      text-decoration: none;
    }

    .news-body a.read-more:hover {
      color: var(--brand-accent-dark);
    }

    /* ========== CTA strip ========== */
    .cta-strip {
      background:
        linear-gradient(120deg, rgba(11, 61, 145, 0.92), rgba(8, 48, 110, 0.92)),
        radial-gradient(600px 400px at 80% 30%, rgba(245, 166, 35, 0.4), transparent 60%);
      color: #fff;
      border-radius: 18px;
      padding: 44px 32px;
    }

    /* ========== Footer ========== */
    footer.site-footer {
      background: #0a1224;
      color: #b9c2d4;
      padding: 60px 0 0;
    }

    footer.site-footer h6 {
      color: #fff;
      font-weight: 700;
      margin-bottom: 16px;
    }

    footer.site-footer a {
      color: #b9c2d4;
      text-decoration: none;
    }

    footer.site-footer a:hover {
      color: #fff;
    }

    footer .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      margin-top: 48px;
      padding: 18px 0;
      font-size: 0.85rem;
      color: #8590a6;
    }

    .social-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.06);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 8px;
      transition: background .2s ease, transform .2s ease;
    }

    .social-icon:hover {
      background: var(--brand-accent);
      color: #1b1b18;
      transform: translateY(-2px);
    }

    /* ========== Responsive tweaks ========== */
    @media (max-width: 991.98px) {
      .hero {
        padding: 60px 0 80px;
      }

      .hero-stat-tl,
      .hero-stat-br {
        display: none;
      }

      .navbar-school .nav-link::after {
        display: none;
      }
    }

    @media (max-width: 575.98px) {
      section {
        padding: 60px 0;
      }

      .stats-band {
        padding: 28px 18px;
      }

      .cta-strip {
        padding: 32px 22px;
      }
    }
  </style>
</head>

<body>

  {{-- ========== Top bar ========== --}}
  <div class="topbar py-2 d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
      <div>
        <span class="mr-3"><i class="fas fa-phone-alt mr-1"></i> +855 12 345 678</span>
        <span><i class="fas fa-envelope mr-1"></i> info@sit-school.edu.kh</span>
      </div>
      <div>
        <a href="#" class="mr-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="mr-2"><i class="fab fa-youtube"></i></a>
        <a href="#" class="mr-2"><i class="fab fa-telegram-plane"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
  </div>

  {{-- ========== Navbar ========== --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white navbar-school shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand navbar-brand-school" href="#">
        <span class="brand-logo">SIT</span>
        <span class="d-flex flex-column">
          <span class="brand-text-en">School of IT</span>
          <span class="brand-text-kh">សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស</span>
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#schoolNav"
        aria-controls="schoolNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="schoolNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link active" href="#home">ទំព័រដើម</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">អំពីយើង</a></li>
          <li class="nav-item"><a class="nav-link" href="#programs">កម្មវិធីសិក្សា</a></li>
          <li class="nav-item"><a class="nav-link" href="#news">ព័ត៌មាន</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">ទំនាក់ទំនង</a></li>
        </ul>

        @if (Route::has('login'))
          <div class="d-flex align-items-center">
            @auth
              <a href="{{ url('/dashboard') }}" class="btn btn-brand btn-sm px-3">
                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
              </a>
            @else
              <a href="{{ route('login') }}" class="btn btn-outline-brand btn-sm px-3 mr-2">ចូលប្រើ</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-brand btn-sm px-3">ចុះឈ្មោះ</a>
              @endif
            @endauth
          </div>
        @endif
      </div>
    </div>
  </nav>

  {{-- ========== Hero ========== --}}
  <section class="hero" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <span class="hero-eyebrow"><i class="fas fa-graduation-cap mr-1"></i> ស្វាគមន៍មកកាន់សាលារបស់យើង</span>
          <h1 class="khmer-display hero-title">
            សាលាជំនាញព័តមានវិទ្យា<br>
            <span style="color: var(--brand-accent-dark);">អេស​ អាយ ធី អេស</span>
          </h1>
          <p class="hero-sub mb-4">
            ផ្តល់ការអប់រំជំនាញព័ត៌មានវិទ្យាប្រកបដោយគុណភាព ដើម្បីបណ្តុះបណ្តាលជំនាន់ក្រោយ
            ឱ្យក្លាយជាអ្នកជំនាញបច្ចេកវិទ្យាដែលមានសមត្ថភាពលើទីផ្សារការងារក្នុងស្រុក និងអន្តរជាតិ។
          </p>
          <div class="d-flex flex-wrap" style="gap: 12px;">
            <a href="#programs" class="btn btn-brand btn-lg px-4">
              <i class="fas fa-book-open mr-2"></i> មើលកម្មវិធីសិក្សា
            </a>
            <a href="#contact" class="btn btn-outline-brand btn-lg px-4">
              <i class="fas fa-paper-plane mr-2"></i> ទំនាក់ទំនងយើង
            </a>
          </div>

          <div class="d-flex align-items-center mt-4" style="gap: 18px;">
            <div class="d-flex" aria-hidden="true">
              <span class="rounded-circle bg-primary"
                style="width:34px;height:34px;border:2px solid #fff;background:#0b3d91 !important;"></span>
              <span class="rounded-circle"
                style="width:34px;height:34px;border:2px solid #fff;background:#f5a623;margin-left:-10px;"></span>
              <span class="rounded-circle"
                style="width:34px;height:34px;border:2px solid #fff;background:#0e9f6e;margin-left:-10px;"></span>
              <span class="rounded-circle"
                style="width:34px;height:34px;border:2px solid #fff;background:#6d28d9;margin-left:-10px;"></span>
            </div>
            <div style="font-size:0.9rem;color:var(--text-muted);">
              <strong style="color: var(--brand-primary-dark);">សិស្ស ១,២០០+ នាក់</strong> កំពុងសិក្សាជាមួយយើងឥឡូវនេះ
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="hero-illustration">
            <i class="fas fa-laptop-code stack-icon"></i>

            <div class="hero-stat-card hero-stat-tl">
              <span class="icon-wrap"><i class="fas fa-user-graduate"></i></span>
              <span>
                <span class="num">៩៥%</span><br>
                <span class="lbl">អត្រាបញ្ចប់ការសិក្សា</span>
              </span>
            </div>

            <div class="hero-stat-card hero-stat-br">
              <span class="icon-wrap" style="background:#fff5e0;color:var(--brand-accent-dark);">
                <i class="fas fa-award"></i>
              </span>
              <span>
                <span class="num">១៥+</span><br>
                <span class="lbl">ឆ្នាំនៃបទពិសោធន៍</span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ========== About / Features ========== --}}
  <section id="about">
    <div class="container">
      <div class="text-center mb-5">
        <div class="section-eyebrow">អំពីសាលា</div>
        <h2 class="khmer-display section-title">ហេតុអ្វីត្រូវជ្រើសរើសសាលារបស់យើង?</h2>
        <p class="section-lead">
          យើងផ្តោតលើការបង្រៀនជាក់ស្តែង បរិក្ខារទំនើប និងគ្រូបង្រៀនដែលមានបទពិសោធន៍
          ដើម្បីឱ្យសិស្សអាចបន្តការងារ ឬបន្តការសិក្សាបានយ៉ាងជោគជ័យ។
        </p>
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="feature-card">
            <span class="feature-icon"><i class="fas fa-chalkboard-teacher"></i></span>
            <h5>គ្រូឯកទេសប្រកបដោយបទពិសោធន៍</h5>
            <p>គ្រូបង្រៀនទាំងអស់សុទ្ធតែមានបទពិសោធន៍ការងារពិត និងបានឆ្លងកាត់ការបណ្តុះបណ្តាលជាបន្តបន្ទាប់។</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="feature-card">
            <span class="feature-icon" style="background:#fff5e0;color:var(--brand-accent-dark);"><i
                class="fas fa-microchip"></i></span>
            <h5>បរិក្ខារ និងបច្ចេកវិទ្យាទំនើប</h5>
            <p>បន្ទប់ពិសោធន៍កុំព្យូទ័រ បណ្តាញអ៊ីនធឺណិតលឿន និងកម្មវិធីដែលប្រើនៅឧស្សាហកម្មពិត។</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="feature-card">
            <span class="feature-icon" style="background:#e6f7ef;color:#0e9f6e;"><i
                class="fas fa-certificate"></i></span>
            <h5>វិញ្ញាបនបត្រដែលត្រូវបានទទួលស្គាល់</h5>
            <p>វិញ្ញាបនបត្រដែលផ្តល់ដោយសាលា ត្រូវបានទទួលស្គាល់ដោយក្រសួងពាក់ព័ន្ធ និងក្រុមហ៊ុនដៃគូ។</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="feature-card">
            <span class="feature-icon" style="background:#f3eaff;color:#6d28d9;"><i
                class="fas fa-handshake"></i></span>
            <h5>ភ្ជាប់ការងារជាមួយក្រុមហ៊ុន</h5>
            <p>យើងមានដៃគូក្រុមហ៊ុនបច្ចេកវិទ្យាជាច្រើន ដែលផ្តល់ឱកាសកម្មសិក្សា និងការងារដល់សិស្ស។</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="feature-card">
            <span class="feature-icon" style="background:#e0f4fa;color:#0e7490;"><i class="fas fa-clock"></i></span>
            <h5>ម៉ោងសិក្សាដែលអាចបត់បែន</h5>
            <p>មានវេនព្រឹក ល្ងាច និងចុងសប្តាហ៍ ដើម្បីសម្របទៅនឹងសិស្សដែលធ្វើការ ឬកំពុងសិក្សារួចហើយ។</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="feature-card">
            <span class="feature-icon" style="background:#fde9ed;color:#b91c1c;"><i
                class="fas fa-hand-holding-usd"></i></span>
            <h5>អាហារូបករណ៍ និងការផ្តល់ជំនួយ</h5>
            <p>មានកម្មវិធីអាហារូបករណ៍ផ្សេងៗ សម្រាប់សិស្សពូកែ និងសិស្សដែលមានជីវភាពខ្វះខាត។</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ========== Programs ========== --}}
  <section class="programs" id="programs">
    <div class="container">
      <div class="text-center mb-5">
        <div class="section-eyebrow">កម្មវិធីសិក្សា</div>
        <h2 class="khmer-display section-title">មុខវិជ្ជាជំនាញដែលយើងផ្តល់ជូន</h2>
        <p class="section-lead">
          កម្មវិធីសិក្សារបស់យើងត្រូវបានរៀបចំឡើងដោយផ្អែកលើតម្រូវការទីផ្សារការងារពិត
          និងតាមនិន្នាការបច្ចេកវិទ្យាថ្មីៗ។
        </p>
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="program-card">
            <div class="program-banner pb-1"><i class="fas fa-code"></i></div>
            <div class="program-body">
              <h5>ការអភិវឌ្ឍន៍គេហទំព័រ (Web Development)</h5>
              <p>រៀន HTML, CSS, JavaScript, PHP, Laravel និងបង្កើតគេហទំព័រពេញលេញចាប់ពីដំបូងរហូតដល់ deploy។</p>
              <div class="program-meta">
                <span><i class="far fa-clock mr-1"></i> ៦ ខែ</span>
                <span class="badge-soft">កម្រិតមូលដ្ឋាន</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="program-card">
            <div class="program-banner pb-2"><i class="fas fa-mobile-alt"></i></div>
            <div class="program-body">
              <h5>ការអភិវឌ្ឍន៍កម្មវិធីទូរស័ព្ទ (Mobile App)</h5>
              <p>រៀន Flutter និង React Native ដើម្បីបង្កើតកម្មវិធីទូរស័ព្ទសម្រាប់ Android និង iOS ពេញលេញ។</p>
              <div class="program-meta">
                <span><i class="far fa-clock mr-1"></i> ៦ ខែ</span>
                <span class="badge-soft">កម្រិតមធ្យម</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="program-card">
            <div class="program-banner pb-3"><i class="fas fa-network-wired"></i></div>
            <div class="program-body">
              <h5>បណ្តាញកុំព្យូទ័រ (Networking)</h5>
              <p>រៀន CCNA, ការតម្លើងបណ្តាញការិយាល័យ, ការគ្រប់គ្រង Server និង Cybersecurity មូលដ្ឋាន។</p>
              <div class="program-meta">
                <span><i class="far fa-clock mr-1"></i> ៥ ខែ</span>
                <span class="badge-soft">កម្រិតមូលដ្ឋាន</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="program-card">
            <div class="program-banner pb-4"><i class="fas fa-paint-brush"></i></div>
            <div class="program-body">
              <h5>រចនាក្រាហ្វិក (Graphic Design)</h5>
              <p>រៀន Adobe Photoshop, Illustrator, InDesign និងគោលការណ៍រចនា UI/UX សម្រាប់ការងារពិត។</p>
              <div class="program-meta">
                <span><i class="far fa-clock mr-1"></i> ៤ ខែ</span>
                <span class="badge-soft">កម្រិតមូលដ្ឋាន</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="program-card">
            <div class="program-banner pb-5"><i class="fas fa-database"></i></div>
            <div class="program-body">
              <h5>មូលដ្ឋានទិន្នន័យ និងវិភាគទិន្នន័យ</h5>
              <p>រៀន SQL, MySQL, MongoDB, Power BI និងគោលការណ៍វិភាគទិន្នន័យសម្រាប់អាជីវកម្ម។</p>
              <div class="program-meta">
                <span><i class="far fa-clock mr-1"></i> ៥ ខែ</span>
                <span class="badge-soft">កម្រិតមធ្យម</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="program-card">
            <div class="program-banner pb-6"><i class="fas fa-shield-alt"></i></div>
            <div class="program-body">
              <h5>សន្តិសុខព័ត៌មាន (Cybersecurity)</h5>
              <p>រៀនពីការការពារប្រព័ន្ធ ការវិភាគការវាយប្រហារ និងគោលការណ៍ Ethical Hacking ជាមូលដ្ឋាន។</p>
              <div class="program-meta">
                <span><i class="far fa-clock mr-1"></i> ៦ ខែ</span>
                <span class="badge-soft">កម្រិតខ្ពស់</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ========== Stats band ========== --}}
  <section style="padding: 0 0 80px;">
    <div class="container">
      <div class="stats-band">
        <div class="row text-center">
          <div class="col-6 col-md-3 mb-3 mb-md-0">
            <div class="stat-num">១,២០០+</div>
            <div class="stat-lbl">សិស្សកំពុងសិក្សា</div>
          </div>
          <div class="col-6 col-md-3 mb-3 mb-md-0">
            <div class="stat-num">៥០+</div>
            <div class="stat-lbl">គ្រូបង្រៀនជំនាញ</div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-num">៣០+</div>
            <div class="stat-lbl">ដៃគូសហការ</div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-num">១៥+</div>
            <div class="stat-lbl">ឆ្នាំនៃបទពិសោធន៍</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ========== News ========== --}}
  <section id="news" style="padding-top:0;">
    <div class="container">
      <div class="text-center mb-5">
        <div class="section-eyebrow">ព័ត៌មាន និងសេចក្តីប្រកាស</div>
        <h2 class="khmer-display section-title">ព័ត៌មានថ្មីៗពីសាលា</h2>
        <p class="section-lead">តាមដានព្រឹត្តិការណ៍ សកម្មភាពអប់រំ និងការប្រកាសសំខាន់ៗរបស់សាលា។</p>
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
          <article class="news-card">
            <div class="news-thumb"><i class="fas fa-bullhorn"></i></div>
            <div class="news-body">
              <span class="news-date">១០ មករា ២០២៦</span>
              <h6>បើកការចុះឈ្មោះវគ្គថ្មីសម្រាប់ឆ្នាំសិក្សា ២០២៦</h6>
              <p>សាលាបើកទទួលពាក្យចុះឈ្មោះសម្រាប់វគ្គសិក្សាថ្មី រួមមានកម្មវិធី Web, Mobile និង Networking។</p>
              <a href="#" class="read-more">អានបន្ថែម <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
          </article>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <article class="news-card">
            <div class="news-thumb" style="background:linear-gradient(135deg,#0e9f6e,#34d399);"><i
                class="fas fa-trophy"></i></div>
            <div class="news-body">
              <span class="news-date">២៥ ធ្នូ ២០២៥</span>
              <h6>សិស្សយើងឈ្នះការប្រកួត Hackathon ថ្នាក់ជាតិ</h6>
              <p>ក្រុមសិស្សពីសាលាយើងបានឈ្នះរង្វាន់លេខ ១ ក្នុងការប្រកួតបង្កើតកម្មវិធីថ្នាក់ជាតិឆ្នាំនេះ។</p>
              <a href="#" class="read-more">អានបន្ថែម <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
          </article>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
          <article class="news-card">
            <div class="news-thumb" style="background:linear-gradient(135deg,#6d28d9,#a78bfa);"><i
                class="fas fa-handshake"></i></div>
            <div class="news-body">
              <span class="news-date">១៥ ធ្នូ ២០២៥</span>
              <h6>ចុះកិច្ចព្រមព្រៀងសហការជាមួយក្រុមហ៊ុនបច្ចេកវិទ្យា</h6>
              <p>សាលាបានចុះ MOU ជាមួយក្រុមហ៊ុនបច្ចេកវិទ្យាធំៗ ដើម្បីផ្តល់ឱកាសកម្មសិក្សា និងការងារដល់សិស្ស។</p>
              <a href="#" class="read-more">អានបន្ថែម <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  {{-- ========== CTA strip ========== --}}
  <section style="padding-top: 0;">
    <div class="container">
      <div class="cta-strip">
        <div class="row align-items-center">
          <div class="col-lg-8 mb-4 mb-lg-0">
            <h3 class="khmer-display mb-2" style="font-weight:800;">ត្រៀមខ្លួនចាប់ផ្តើមការសិក្សារបស់អ្នក?</h3>
            <p class="mb-0" style="opacity:0.9;">
              ចុះឈ្មោះថ្ងៃនេះ និងទទួលបានការប្រឹក្សាដោយឥតគិតថ្លៃពីក្រុមការងាររបស់យើង។
            </p>
          </div>
          <div class="col-lg-4 text-lg-right">
            @if (Route::has('register'))
              <a href="{{ Route::has('register') ? route('register') : '#' }}" class="btn btn-accent btn-lg px-4">
                <i class="fas fa-user-plus mr-2"></i> ចុះឈ្មោះឥឡូវនេះ
              </a>
            @else
              <a href="#contact" class="btn btn-accent btn-lg px-4">
                <i class="fas fa-user-plus mr-2"></i> ចុះឈ្មោះឥឡូវនេះ
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ========== Footer ========== --}}
  <footer class="site-footer" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="d-flex align-items-center mb-3">
            <span class="brand-logo mr-2">SIT</span>
            <span style="color:#fff;font-weight:700;line-height:1.2;">
              សាលាជំនាញព័តមានវិទ្យា<br>
              <small style="color:#cfd9ee;font-weight:500;">អេស​ អាយ ធី អេស</small>
            </span>
          </div>
          <p style="font-size:0.92rem;line-height:1.7;">
            សាលាជំនាញព័ត៌មានវិទ្យាដែលផ្តោតលើគុណភាពអប់រំ និងការអភិវឌ្ឍជំនាញពិតប្រាកដ
            ដើម្បីត្រៀមសិស្សសម្រាប់ទីផ្សារការងារសម័យទំនើប។
          </p>
          <div class="mt-3">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-telegram-plane"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6 col-6 mb-4">
          <h6>តំណភ្ជាប់</h6>
          <ul class="list-unstyled" style="line-height:2;">
            <li><a href="#home">ទំព័រដើម</a></li>
            <li><a href="#about">អំពីយើង</a></li>
            <li><a href="#programs">កម្មវិធីសិក្សា</a></li>
            <li><a href="#news">ព័ត៌មាន</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 col-6 mb-4">
          <h6>មុខវិជ្ជាពេញនិយម</h6>
          <ul class="list-unstyled" style="line-height:2;">
            <li><a href="#programs">Web Development</a></li>
            <li><a href="#programs">Mobile App Development</a></li>
            <li><a href="#programs">Networking (CCNA)</a></li>
            <li><a href="#programs">Graphic Design</a></li>
            <li><a href="#programs">Cybersecurity</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <h6>ទំនាក់ទំនងយើង</h6>
          <ul class="list-unstyled" style="line-height:1.9;">
            <li class="mb-2"><i class="fas fa-map-marker-alt mr-2" style="color:var(--brand-accent);"></i> ភ្នំពេញ
              ប្រទេសកម្ពុជា</li>
            <li class="mb-2"><i class="fas fa-phone-alt mr-2" style="color:var(--brand-accent);"></i> +855 12 345
              678</li>
            <li class="mb-2"><i class="fas fa-envelope mr-2" style="color:var(--brand-accent);"></i>
              info@sit-school.edu.kh</li>
            <li><i class="fas fa-clock mr-2" style="color:var(--brand-accent);"></i> ច័ន្ទ - សៅរ៍, ៧:៣០ - ១៧:៣០</li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom text-center text-md-left">
        <div class="row align-items-center">
          <div class="col-md-6 mb-2 mb-md-0">
            &copy; {{ date('Y') }} សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស. រក្សាសិទ្ធិគ្រប់យ៉ាង។
          </div>
          <div class="col-md-6 text-md-right">
            <a href="#" class="mr-3">លក្ខខណ្ឌប្រើប្រាស់</a>
            <a href="#">គោលការណ៍ឯកជនភាព</a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  {{-- Bootstrap 4 JS dependencies --}}
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
