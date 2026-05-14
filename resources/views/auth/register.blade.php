<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ចុះឈ្មោះ — សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700;900&family=Noto+Sans+Khmer:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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
      height: 100%;
    }

    body {
      font-family: 'Noto Sans Khmer', 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
      color: var(--text-dark);
      background:
        radial-gradient(900px 500px at 90% -10%, rgba(245, 166, 35, 0.18), transparent 60%),
        radial-gradient(900px 600px at -10% 110%, rgba(11, 61, 145, 0.18), transparent 60%),
        linear-gradient(180deg, #f7faff 0%, #eef3fb 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
    }

    .khmer-display {
      font-family: 'Battambang', 'Noto Sans Khmer', serif;
      line-height: 1.4;
    }

    .auth-card {
      width: 100%;
      max-width: 1020px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 30px 80px -30px rgba(11, 61, 145, 0.35), 0 8px 24px rgba(11, 61, 145, 0.08);
      overflow: hidden;
    }

    .brand-panel {
      position: relative;
      background:
        radial-gradient(420px 260px at 80% 10%, rgba(245, 166, 35, 0.35), transparent 60%),
        linear-gradient(160deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
      color: #fff;
      padding: 48px 40px;
      min-height: 620px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow: hidden;
    }

    .brand-panel::before,
    .brand-panel::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.06);
    }

    .brand-panel::before {
      width: 240px;
      height: 240px;
      top: -80px;
      right: -80px;
    }

    .brand-panel::after {
      width: 180px;
      height: 180px;
      bottom: -60px;
      left: -60px;
      background: rgba(245, 166, 35, 0.18);
    }

    .brand-logo-lg {
      width: 64px;
      height: 64px;
      border-radius: 18px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(6px);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
      font-weight: 800;
      font-size: 1.4rem;
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .brand-school-name {
      font-family: 'Battambang', 'Noto Sans Khmer', serif;
      font-weight: 900;
      font-size: 1.4rem;
      line-height: 1.35;
      margin-top: 22px;
    }

    .brand-tag {
      color: rgba(255, 255, 255, 0.85);
      font-size: 0.95rem;
      line-height: 1.7;
      margin-top: 14px;
      max-width: 360px;
    }

    .step-list {
      padding-left: 0;
      list-style: none;
      margin: 0;
      position: relative;
      z-index: 1;
    }

    .step-list li {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 12px 0;
      color: rgba(255, 255, 255, 0.92);
      font-size: 0.92rem;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .step-list li:first-child {
      border-top: 0;
    }

    .step-num {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: rgba(245, 166, 35, 0.2);
      color: var(--brand-accent);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      flex-shrink: 0;
      border: 1px solid rgba(245, 166, 35, 0.4);
    }

    .form-panel {
      padding: 44px 44px;
      position: relative;
    }

    .form-panel .form-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(245, 166, 35, 0.14);
      color: var(--brand-accent-dark);
      padding: 5px 12px;
      border-radius: 999px;
      font-size: 0.82rem;
      font-weight: 600;
      margin-bottom: 12px;
      line-height: 1.6;
    }

    .form-panel .form-eyebrow i {
      font-size: 0.78rem;
    }

    .form-panel h3 {
      font-weight: 800;
      color: var(--brand-primary-dark);
      margin-bottom: 6px;
      font-size: 1.55rem;
    }

    .form-panel .form-sub {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 22px;
    }

    .form-control {
      border: 1px solid #e3e9f3;
      border-radius: 10px;
      padding: 0.7rem 0.95rem 0.7rem 2.5rem;
      font-size: 0.95rem;
      background-color: #fafbfd;
      transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
    }

    .form-control:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 4px rgba(11, 61, 145, 0.12);
      background-color: #fff;
    }

    .input-group-with-icon {
      position: relative;
    }

    .input-group-with-icon>.input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #98a3b3;
      font-size: 0.95rem;
      pointer-events: none;
    }

    .input-group-with-icon>.password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #98a3b3;
      background: transparent;
      border: 0;
      padding: 4px 6px;
      cursor: pointer;
    }

    .input-group-with-icon>.password-toggle:hover {
      color: var(--brand-primary);
    }

    .form-label-custom {
      font-weight: 600;
      font-size: 0.85rem;
      color: var(--text-dark);
      margin-bottom: 6px;
      display: inline-block;
    }

    .btn-brand {
      background: var(--brand-primary);
      border-color: var(--brand-primary);
      color: #fff;
      font-weight: 600;
      padding: 0.7rem 1rem;
      border-radius: 10px;
      transition: background .15s ease, transform .12s ease, box-shadow .15s ease;
      box-shadow: 0 12px 24px -12px rgba(11, 61, 145, 0.5);
    }

    .btn-brand:hover {
      background: var(--brand-primary-dark);
      border-color: var(--brand-primary-dark);
      color: #fff;
      transform: translateY(-1px);
    }

    .btn-brand:focus {
      box-shadow: 0 0 0 4px rgba(11, 61, 145, 0.18);
    }

    .divider-or {
      display: flex;
      align-items: center;
      gap: 14px;
      color: #98a3b3;
      font-size: 0.82rem;
      font-weight: 600;
      margin: 22px 0 16px;
    }

    .divider-or::before,
    .divider-or::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e3e9f3;
    }

    .social-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
    }

    .btn-social {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 0.65rem 0.5rem;
      border-radius: 10px;
      border: 1px solid #e3e9f3;
      background: #fff;
      color: var(--text-dark);
      font-weight: 500;
      font-size: 0.88rem;
      transition: transform .12s ease, box-shadow .15s ease, border-color .15s ease, color .15s ease, background .15s ease;
      text-decoration: none;
    }

    .btn-social:hover {
      transform: translateY(-1px);
      box-shadow: 0 12px 24px -16px rgba(0, 0, 0, 0.25);
      text-decoration: none;
    }

    .btn-social i {
      font-size: 1.1rem;
    }

    .btn-social .label {
      display: none;
    }

    @media (min-width: 480px) {
      .btn-social .label {
        display: inline;
      }
    }

    .btn-social.github:hover {
      border-color: #24292f;
      color: #24292f;
      background: #f6f8fa;
    }

    .btn-social.gitlab:hover {
      border-color: #fc6d26;
      color: #fc6d26;
      background: #fff5ed;
    }

    .btn-social.google:hover {
      border-color: #ea4335;
      color: #ea4335;
      background: #fef0ee;
    }

    .btn-social.telegram:hover {
      border-color: #229ed9;
      color: #229ed9;
      background: #eaf6fc;
    }

    .btn-social.github i {
      color: #24292f;
    }

    .btn-social.gitlab i {
      color: #fc6d26;
    }

    .btn-social.google i {
      color: #ea4335;
    }

    .btn-social.telegram i {
      color: #229ed9;
    }

    .switch-auth {
      text-align: center;
      margin-top: 20px;
      color: var(--text-muted);
      font-size: 0.92rem;
    }

    .switch-auth a {
      color: var(--brand-primary);
      font-weight: 600;
      text-decoration: none;
    }

    .switch-auth a:hover {
      color: var(--brand-accent-dark);
      text-decoration: underline;
    }

    /* Password strength meter */
    .pw-meter {
      display: flex;
      gap: 4px;
      margin-top: 8px;
    }

    .pw-meter span {
      flex: 1;
      height: 4px;
      background: #e3e9f3;
      border-radius: 2px;
      transition: background .15s ease;
    }

    .pw-hint {
      font-size: 0.78rem;
      color: var(--text-muted);
      margin-top: 4px;
    }

    .alert-soft {
      border-radius: 10px;
      border: 1px solid #fde2e2;
      background: #fff5f5;
      color: #b91c1c;
      font-size: 0.88rem;
      padding: 10px 14px;
    }

    .invalid-feedback {
      font-size: 0.82rem;
    }

    .form-control.is-invalid {
      border-color: #dc3545;
      background-color: #fff5f5;
    }

    .custom-checkbox .custom-control-label {
      font-size: 0.85rem;
      color: var(--text-muted);
      cursor: pointer;
    }

    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
      background-color: var(--brand-primary);
      border-color: var(--brand-primary);
    }

    .custom-control-label a {
      color: var(--brand-primary);
      font-weight: 600;
    }

    @media (max-width: 767.98px) {
      .brand-panel {
        min-height: auto;
        padding: 36px 28px;
      }

      .form-panel {
        padding: 32px 26px;
      }

      .brand-school-name {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>

  <div class="auth-card">
    <div class="row no-gutters">
      {{-- ========= Brand panel ========= --}}
      <div class="col-md-5 d-none d-md-flex">
        <div class="brand-panel w-100">
          <div style="position: relative; z-index: 1;">
            <span class="brand-logo-lg">SIT</span>
            <h2 class="brand-school-name">សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស</h2>
            <p class="brand-tag">
              បង្កើតគណនីដើម្បីចុះឈ្មោះវគ្គសិក្សា តាមដានការសិក្សារបស់អ្នក
              និងភ្ជាប់ជាមួយក្រុមការងារសាលា។
            </p>
          </div>

          <ol class="step-list">
            <li>
              <span class="step-num">១</span>
              <span><strong>បង្កើតគណនី</strong><br><small style="opacity:0.75;">ប្រើអ៊ីមែល ឬគណនី social
                  របស់អ្នក</small></span>
            </li>
            <li>
              <span class="step-num">២</span>
              <span><strong>ជ្រើសរើសកម្មវិធីសិក្សា</strong><br><small style="opacity:0.75;">មុខវិជ្ជា Web, Mobile,
                  Networking ។ល។</small></span>
            </li>
            <li>
              <span class="step-num">៣</span>
              <span><strong>ចាប់ផ្តើមការសិក្សា</strong><br><small
                  style="opacity:0.75;">ទទួលបានវិញ្ញាបនបត្រនៅពេលបញ្ចប់</small></span>
            </li>
          </ol>
        </div>
      </div>

      {{-- ========= Form panel ========= --}}
      <div class="col-md-7">
        <div class="form-panel">
          <span class="form-eyebrow"><i class="fas fa-user-plus"></i> បង្កើតគណនីថ្មី</span>
          <h3 class="khmer-display">ចុះឈ្មោះជាមួយយើង</h3>
          <p class="form-sub">បំពេញព័ត៌មានខាងក្រោម ឬចុះឈ្មោះរហ័សដោយប្រើគណនី social។</p>

          {{-- Quick social signup at the top for visibility --}}
          <div class="social-row">
            <a href="{{ url('/auth/github') }}" class="btn-social github" aria-label="Sign up with GitHub">
              <i class="fab fa-github"></i><span class="label">GitHub</span>
            </a>
            <a href="{{ url('/auth/gitlab') }}" class="btn-social gitlab" aria-label="Sign up with GitLab">
              <i class="fab fa-gitlab"></i><span class="label">GitLab</span>
            </a>
            <a href="{{ url('/auth/google') }}" class="btn-social google" aria-label="Sign up with Google">
              <i class="fab fa-google"></i><span class="label">Google</span>
            </a>
            <a href="{{ url('/auth/telegram') }}" class="btn-social telegram" aria-label="Sign up with Telegram">
              <i class="fab fa-telegram-plane"></i><span class="label">Telegram</span>
            </a>
          </div>

          <div class="divider-or">ឬចុះឈ្មោះដោយអ៊ីមែល</div>

          @if ($errors->any())
            <div class="alert-soft mb-3">
              <i class="fas fa-exclamation-circle mr-2"></i>
              {{ __('Please fix the errors below to continue.') }}
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- Name --}}
            <div class="form-group">
              <label for="name" class="form-label-custom">{{ __('Full Name') }}</label>
              <div class="input-group-with-icon">
                <i class="fas fa-user input-icon"></i>
                <input id="name" type="text" name="name"
                  class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                  placeholder="ឧ. ឈ្មោះ ខ្ញុំ" required autofocus autocomplete="name">
              </div>
              @error('name')
                <small class="text-danger d-block mt-1"><i
                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
              @enderror
            </div>

            {{-- Email --}}
            <div class="form-group mt-3">
              <label for="email" class="form-label-custom">{{ __('Email') }}</label>
              <div class="input-group-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input id="email" type="email" name="email"
                  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                  placeholder="you@example.com" required autocomplete="username">
              </div>
              @error('email')
                <small class="text-danger d-block mt-1"><i
                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
              @enderror
            </div>

            <div class="row mt-3">
              {{-- Password --}}
              <div class="form-group col-md-6">
                <label for="password" class="form-label-custom">{{ __('Password') }}</label>
                <div class="input-group-with-icon">
                  <i class="fas fa-lock input-icon"></i>
                  <input id="password" type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="យ៉ាងតិច ៨ តួអក្សរ"
                    required autocomplete="new-password">
                  <button type="button" class="password-toggle" data-target="password" aria-label="Show password">
                    <i class="far fa-eye"></i>
                  </button>
                </div>
                <div class="pw-meter" aria-hidden="true">
                  <span></span><span></span><span></span><span></span>
                </div>
                <div class="pw-hint">ត្រូវមានយ៉ាងតិច ៨ តួអក្សរ រួមបញ្ចូលលេខ និងអក្សរធំ។</div>
                @error('password')
                  <small class="text-danger d-block mt-1"><i
                      class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
                @enderror
              </div>

              {{-- Confirm Password --}}
              <div class="form-group col-md-6">
                <label for="password_confirmation" class="form-label-custom">{{ __('Confirm Password') }}</label>
                <div class="input-group-with-icon">
                  <i class="fas fa-lock input-icon"></i>
                  <input id="password_confirmation" type="password" name="password_confirmation"
                    class="form-control" placeholder="បញ្ជាក់ពាក្យសម្ងាត់" required autocomplete="new-password">
                  <button type="button" class="password-toggle" data-target="password_confirmation"
                    aria-label="Show password">
                    <i class="far fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>

            {{-- Terms --}}
            <div class="custom-control custom-checkbox mt-3">
              <input type="checkbox" class="custom-control-input" id="terms" name="terms" required>
              <label class="custom-control-label" for="terms">
                ខ្ញុំយល់ព្រមជាមួយ <a href="#">លក្ខខណ្ឌប្រើប្រាស់</a> និង <a href="#">គោលការណ៍ឯកជនភាព</a>
              </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-brand btn-block mt-4">
              <i class="fas fa-user-plus mr-2"></i> {{ __('Register') }}
            </button>
          </form>

          {{-- Switch to login --}}
          <p class="switch-auth">
            មានគណនីរួចហើយ? <a href="{{ route('login') }}">{{ __('Log in') }}</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

  <script>
    // Password show/hide toggles
    document.querySelectorAll('.password-toggle').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var input = document.getElementById(btn.getAttribute('data-target'));
        if (!input) return;
        var icon = btn.querySelector('i');
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    });

    // Lightweight password strength meter
    (function() {
      var pw = document.getElementById('password');
      var meter = document.querySelector('.pw-meter');
      if (!pw || !meter) return;
      var bars = meter.querySelectorAll('span');
      var colors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e'];
      pw.addEventListener('input', function() {
        var v = pw.value;
        var score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        bars.forEach(function(b, i) {
          b.style.background = i < score ? colors[score - 1] : '#e3e9f3';
        });
      });
    })();
  </script>
</body>

</html>
