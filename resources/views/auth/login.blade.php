<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ចូលប្រើ — សាលាជំនាញព័តមានវិទ្យា អេស​ អាយ ធី អេស</title>

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700;900&family=Noto+Sans+Khmer:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  {{-- Bootstrap 4 + Font Awesome --}}
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
      max-width: 980px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 30px 80px -30px rgba(11, 61, 145, 0.35), 0 8px 24px rgba(11, 61, 145, 0.08);
      overflow: hidden;
    }

    /* ========== Brand panel (left) ========== */
    .brand-panel {
      position: relative;
      background:
        radial-gradient(420px 260px at 80% 10%, rgba(245, 166, 35, 0.35), transparent 60%),
        linear-gradient(160deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
      color: #fff;
      padding: 48px 40px;
      min-height: 540px;
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

    .brand-feature {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      color: rgba(255, 255, 255, 0.92);
      font-size: 0.92rem;
      margin-bottom: 12px;
    }

    .brand-feature i {
      width: 32px;
      height: 32px;
      border-radius: 9px;
      background: rgba(255, 255, 255, 0.12);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--brand-accent);
      flex-shrink: 0;
    }

    /* ========== Form panel (right) ========== */
    .form-panel {
      padding: 48px 44px;
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
      margin-bottom: 28px;
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

    .form-helper-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 8px;
      font-size: 0.85rem;
    }

    .form-helper-row a {
      color: var(--brand-primary);
      text-decoration: none;
      font-weight: 500;
    }

    .form-helper-row a:hover {
      color: var(--brand-accent-dark);
      text-decoration: underline;
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
      margin: 24px 0 18px;
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
      margin-top: 22px;
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

    .alert-soft {
      border-radius: 10px;
      border: 1px solid #fde2e2;
      background: #fff5f5;
      color: #b91c1c;
      font-size: 0.88rem;
      padding: 10px 14px;
    }

    .alert-soft.success {
      border-color: #c8ecd6;
      background: #f0faf3;
      color: #0e7c46;
    }

    .invalid-feedback {
      font-size: 0.82rem;
    }

    .form-control.is-invalid {
      border-color: #dc3545;
      background-color: #fff5f5;
    }

    /* ===== Select Branch ===== */
    .select-wrapper {
      position: relative;
    }

    .select-wrapper .select-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #98a3b3;
      font-size: 0.95rem;
      pointer-events: none;
      z-index: 2;
    }

    select.form-control {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      padding-left: 2.5rem;
      padding-right: 2.75rem;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2398a3b3' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 16px;
      cursor: pointer;
      height: calc(1.5em + 1.4rem + 2px);
      line-height: 1.5;
      color: #98a3b3;
    }

    select.form-control.has-value {
      color: var(--text-dark);
    }

    select.form-control:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 4px rgba(11, 61, 145, 0.12);
      background-color: #fff;
      outline: none;
    }

    select.form-control option {
      color: var(--text-dark);
      background: #fff;
    }

    select.form-control option[value=""] {
      color: #98a3b3;
    }

    .custom-checkbox .custom-control-label {
      font-size: 0.88rem;
      color: var(--text-muted);
      cursor: pointer;
    }

    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
      background-color: var(--brand-primary);
      border-color: var(--brand-primary);
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
              ស្វាគមន៍ត្រឡប់មកវិញ! ចូលគណនីរបស់អ្នកដើម្បីបន្តការសិក្សា
              និងតាមដានវឌ្ឍនភាពនៃកម្មវិធីសិក្សារបស់អ្នក។
            </p>
          </div>

          <div style="position: relative; z-index: 1;">
            <div class="brand-feature">
              <i class="fas fa-graduation-cap"></i>
              <span>មុខវិជ្ជាជំនាញព័ត៌មានវិទ្យាជាង ១០ មុខ</span>
            </div>
            <div class="brand-feature">
              <i class="fas fa-chalkboard-teacher"></i>
              <span>គ្រូបង្រៀនជំនាញដែលមានបទពិសោធន៍</span>
            </div>
            <div class="brand-feature">
              <i class="fas fa-certificate"></i>
              <span>វិញ្ញាបនបត្រដែលត្រូវបានទទួលស្គាល់</span>
            </div>
          </div>
        </div>
      </div>

      {{-- ========= Form panel ========= --}}
      <div class="col-md-7">
        <div class="form-panel">
          <span class="form-eyebrow"><i class="fas fa-hand-sparkles"></i> សូមស្វាគមន៍ត្រឡប់មកវិញ</span>
          <h3 class="khmer-display">ចូលទៅគណនីរបស់អ្នក</h3>
          <p class="form-sub">បំពេញព័ត៌មានខាងក្រោមដើម្បីបន្តចូលប្រើ ឬចូលដោយប្រើគណនី social ខាងក្រោម។</p>

          {{-- Session status (e.g., password reset link sent) --}}
          @if (session('status'))
            <div class="alert-soft success mb-3">
              <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
            </div>
          @endif

          {{-- Generic error summary --}}
          @if ($errors->any())
            <div class="alert-soft mb-3">
              <i class="fas fa-exclamation-circle mr-2"></i>
              {{ __('Whoops! Something went wrong with your input.') }}
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            {{-- Branch --}}
            <div class="form-group">
              <label for="branch_id" class="form-label-custom">សាខា <span class="text-danger">*</span></label>
              <div class="select-wrapper">
                <i class="fas fa-code-branch select-icon"></i>
                <select id="branch_id" name="branch_id"
                  class="form-control @error('branch_id') is-invalid @enderror {{ old('branch_id') ? 'has-value' : '' }}"
                  required>
                  <option value="">-- ជ្រើសរើសសាខា --</option>
                  @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                      {{ $branch->name_kh }}{{ $branch->is_main ? ' ★' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('branch_id')
                <small class="text-danger d-block mt-1"><i
                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
              @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
              <label for="email" class="form-label-custom">{{ __('Email') }}</label>
              <div class="input-group-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input id="email" type="email" name="email"
                  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                  placeholder="you@example.com" required autofocus autocomplete="username">
              </div>
              @error('email')
                <small class="text-danger d-block mt-1"><i
                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
              @enderror
            </div>

            {{-- Password --}}
            <div class="form-group mt-3">
              <label for="password" class="form-label-custom">{{ __('Password') }}</label>
              <div class="input-group-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input id="password" type="password" name="password"
                  class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required
                  autocomplete="current-password">
                <button type="button" class="password-toggle" data-target="password" aria-label="Show password">
                  <i class="far fa-eye"></i>
                </button>
              </div>
              @error('password')
                <small class="text-danger d-block mt-1"><i
                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
              @enderror
            </div>

            {{-- Remember + forgot --}}
            <div class="form-helper-row">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                <label class="custom-control-label" for="remember_me">{{ __('Remember me') }}</label>
              </div>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
              @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-brand btn-block mt-4">
              <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Log in') }}
            </button>
          </form>

          {{-- Divider --}}
          <div class="divider-or">ឬចូលដោយប្រើ</div>

          {{-- Social login --}}
          <div class="social-row">
            <a href="{{ url('/auth/github') }}" class="btn-social github" aria-label="Continue with GitHub">
              <i class="fab fa-github"></i><span class="label">GitHub</span>
            </a>
            <a href="{{ url('/auth/gitlab') }}" class="btn-social gitlab" aria-label="Continue with GitLab">
              <i class="fab fa-gitlab"></i><span class="label">GitLab</span>
            </a>
            <a href="{{ url('/auth/google') }}" class="btn-social google" aria-label="Continue with Google">
              <i class="fab fa-google"></i><span class="label">Google</span>
            </a>
            <a href="{{ url('/auth/telegram') }}" class="btn-social telegram" aria-label="Continue with Telegram">
              <i class="fab fa-telegram-plane"></i><span class="label">Telegram</span>
            </a>
          </div>

          {{-- Switch to register --}}
          @if (Route::has('register'))
            <p class="switch-auth">
              មិនទាន់មានគណនី? <a href="{{ route('register') }}">{{ __('Create an account') }}</a>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- jQuery + Bootstrap 4 JS --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

  <script>
    // Branch select: toggle placeholder color
    var branchSelect = document.getElementById('branch_id');
    if (branchSelect) {
      function updateBranchColor() {
        if (branchSelect.value) {
          branchSelect.classList.add('has-value');
        } else {
          branchSelect.classList.remove('has-value');
        }
      }
      branchSelect.addEventListener('change', updateBranchColor);
      updateBranchColor();
    }

    // Password show/hide toggle
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
  </script>
</body>

</html>
