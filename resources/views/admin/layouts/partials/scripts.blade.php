<!-- jQuery -->
<script src="{{ assetUrl('') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ assetUrl('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ assetUrl('') }}/dist/js/adminlte.min.js"></script>

<!-- DataTables JS (Bootstrap 4) -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Tom Select -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!-- Vite / Vue3 -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- JS Translations + Global Init -->
<script>
  window.APP_LOCALE = '{{ app()->getLocale() }}';
  window.APP_URL = '{{ url('/') }}';
  window.CSRF_TOKEN = '{{ csrf_token() }}';
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': window.CSRF_TOKEN
    }
  });

  window.TRANS = {!! json_encode([
      'en' => [
          'confirm_delete' => 'Are you sure?',
          'confirm_delete_text' => 'This action cannot be undone!',
          'btn_yes_delete' => 'Yes, delete it!',
          'btn_cancel' => 'Cancel',
          'deleted' => 'Deleted!',
          'record_deleted' => 'Record has been deleted.',
          'error' => 'Error!',
          'delete_failed' => 'Failed to delete record.',
          'switch_lang' => 'Switch Language',
      ],
      'km' => [
          'confirm_delete' => 'តើអ្នកប្រាកដទេ?',
          'confirm_delete_text' => 'សកម្មភាពនេះមិនអាចត្រឡប់ក្រោយបានទេ!',
          'btn_yes_delete' => 'បាទ/ចាស លុបចោល!',
          'btn_cancel' => 'បោះបង់',
          'deleted' => 'លុបហើយ!',
          'record_deleted' => 'កំណត់ត្រាត្រូវបានលុបរួចហើយ។',
          'error' => 'កំហុស!',
          'delete_failed' => 'បរាជ័យក្នុងការលុបកំណត់ត្រា។',
          'switch_lang' => 'ប្តូរភាសា',
      ],
  ]) !!};

  function t(key) {
    var locale = window.APP_LOCALE;
    return (window.TRANS[locale] && window.TRANS[locale][key]) ? window.TRANS[locale][key] : key;
  }

  /* ======================================================
     Global Language Switcher (no page refresh)
     ====================================================== */
  function switchLocale(locale) {
    $.post('/lang/' + locale + '/ajax', {}, function(res) {
      if (res.success) {
        window.APP_LOCALE = locale;
        document.documentElement.lang = locale;
        document.body.classList.toggle('lang-km', locale === 'km');
        // Reload page to reflect server-side translations
        // For data-i18n elements that have been pre-loaded, swap them
        $('[data-i18n]').each(function() {
          var key = $(this).data('i18n');
          if (window.ALL_TRANS && window.ALL_TRANS[locale] && window.ALL_TRANS[locale][key]) {
            $(this).text(window.ALL_TRANS[locale][key]);
          }
        });
        // Update active flag in dropdown
        $('.lang-switcher-item').removeClass('active');
        $('.lang-switcher-item[data-locale="' + locale + '"]').addClass('active');
        $('.lang-current-label').text(locale === 'km' ? 'ខ្មែរ' : 'EN');
        // Reload all DataTables to get translated content
        if ($.fn.DataTable) {
          $.fn.dataTable.tables({
            api: true
          }).ajax.reload();
        }
        // Reload page for full server-side translation
        window.location.reload();
      }
    });
  }

  /* ======================================================
     Global SweetAlert2 Delete Confirmation
     ====================================================== */
  $(document).on('click', '.btn-swal-delete', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var url = form.attr('action') || $(this).data('url');
    var method = form.find('input[name="_method"]').val() || 'DELETE';

    Swal.fire({
      title: t('confirm_delete'),
      text: t('confirm_delete_text'),
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: t('btn_yes_delete'),
      cancelButtonText: t('btn_cancel'),
    }).then(function(result) {
      if (result.isConfirmed) {
        if (form.length) {
          form.submit();
        } else {
          $.ajax({
            url: url,
            type: 'POST',
            data: {
              _method: method,
              _token: window.CSRF_TOKEN
            },
            success: function() {
              Swal.fire(t('deleted'), t('record_deleted'), 'success').then(function() {
                if ($.fn.DataTable) {
                  $.fn.dataTable.tables({
                    api: true
                  }).ajax.reload();
                }
              });
            },
            error: function() {
              Swal.fire(t('error'), t('delete_failed'), 'error');
            }
          });
        }
      }
    });
  });

  /* ======================================================
     Global DataTables Defaults — use local i18n files
     ====================================================== */
  $(function() {
    var locale = window.APP_LOCALE === 'km' ? 'km' : 'en-GB';
    $.extend(true, $.fn.dataTable.defaults, {
      language: {
        url: '/vendor/datatables/i18n/' + locale + '.json'
      }
    });
  });

  /* ======================================================
     Global Flatpickr Init
     ====================================================== */
  $(function() {
    // Date only fields
    flatpickr('.flatpickr-date:not(._flatpickr), input[type="date"]:not(._flatpickr)', {
      dateFormat: 'Y-m-d',
      allowInput: true
    });
    // Generic .flatpickr class (defaults to date)
    flatpickr('.flatpickr:not(._flatpickr)', {
      dateFormat: 'Y-m-d',
      allowInput: true
    });
    // DateTime fields
    flatpickr('.flatpickr-datetime:not(._flatpickr), input[type="datetime-local"]:not(._flatpickr)', {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
      allowInput: true
    });
    // Time only fields
    flatpickr('.flatpickr-time:not(._flatpickr), input[type="time"]:not(._flatpickr)', {
      enableTime: true,
      noCalendar: true,
      dateFormat: 'H:i',
      allowInput: true
    });
  });

  /* ======================================================
     Global Tom Select Init
     ====================================================== */
  $(function() {
    document.querySelectorAll('select.tom-select').forEach(function(el) {
      if (!el.tomselect) {
        new TomSelect(el, {
          allowEmptyOption: true
        });
      }
    });
    document.querySelectorAll('select.tom-select-tags').forEach(function(el) {
      if (!el.tomselect) {
        new TomSelect(el, {
          create: true,
          allowEmptyOption: true
        });
      }
    });
  });
</script>

@stack('scripts')

<!-- PhpFlasher Configuration: Position to Bottom Right (CSS handles this in head.blade.php) -->
