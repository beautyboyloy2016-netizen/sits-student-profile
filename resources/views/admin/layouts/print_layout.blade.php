<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('pageTitle', __('app.app_name'))</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body { background: #f4f6f9; padding: 20px; }
    .print-container { background: #fff; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.15); padding: 30px; }
    .print-toolbar { text-align: center; margin-bottom: 20px; }
    @media print {
      body { background: #fff; padding: 0; }
      .print-toolbar { display: none !important; }
      .print-container { box-shadow: none; margin: 0; padding: 0; }
    }
  </style>
  @yield('styles')
</head>
<body>
  <div class="print-toolbar d-print-none">
    <button class="btn btn-primary btn-lg" onclick="window.print()">
      <i class="fas fa-print"></i> {{ __('app.print') }}
    </button>
    <button class="btn btn-secondary btn-lg" onclick="history.back()">
      <i class="fas fa-arrow-left"></i> {{ __('app.back') }}
    </button>
  </div>

  <div class="print-container">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
