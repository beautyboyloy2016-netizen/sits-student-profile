<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('pageTitle', __('app.app_name'))</title>

  <!-- Google Font: Source Sans Pro + Noto Sans Khmer -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@300;400;700&display=swap">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ assetUrl('') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ assetUrl('') }}/dist/css/adminlte.min.css">

  <!-- DataTables CSS (Bootstrap 4) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- Tom Select CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap4.min.css">
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    body {
      font-family: 'Source Sans Pro', 'Noto Sans Khmer', sans-serif;
    }

    body.lang-km {
      font-family: 'Noto Sans Khmer', 'Source Sans Pro', sans-serif;
    }

    .ts-wrapper.form-control {
      padding: 0;
      height: auto;
    }

    /* PhpFlasher - Force notifications to bottom-right */
    .flasher-container,
    .flasher-notifications-container,
    .flasher-container[data-position="top-right"],
    .flasher-container[data-position="bottom-right"] {
      position: fixed !important;
      top: auto !important;
      bottom: 20px !important;
      right: 20px !important;
      left: auto !important;
      z-index: 9999 !important;
    }
  </style>

  @stack('styles')

</head>
