@extends('admin.layouts.master_layout')

@section('pageTitle', 'ការចូលរៀន - ' . __('app.app_name'))
@section('pageHeading', 'ការចូលរៀន')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
  <li class="breadcrumb-item active">ការចូលរៀន</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h3 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>ការចូលរៀន</h3>
          <div class="d-flex align-items-center gap-2">
            {{-- Type Toggle --}}
            <div class="btn-group btn-group-sm" role="group">
              <button type="button"
                class="btn btn-outline-primary btn-type {{ $attendType === 'student' ? 'active' : '' }}"
                data-type="student">
                <i class="fas fa-user-graduate mr-1"></i>សិស្ស
              </button>
              <button type="button"
                class="btn btn-outline-secondary btn-type {{ $attendType === 'staff' ? 'active' : '' }}"
                data-type="staff">
                <i class="fas fa-chalkboard-teacher mr-1"></i>បុគ្គលិក
              </button>
            </div>
            <button class="btn btn-success btn-sm" id="btnBulkAttendance">
              <i class="fas fa-list-check mr-1"></i>ចុះវត្តមានជាក្រុម
            </button>
          </div>
        </div>

        {{-- Filters --}}
        <div class="card-body pb-0">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ថ្ងៃ</label>
                <input type="text" id="filterDate" class="form-control form-control-sm flatpickr-date"
                  value="{{ today()->toDateString() }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>ថ្នាក់</label>
                <select id="filterClass" class="form-control form-control-sm select2">
                  <option value="">-- ថ្នាក់ទាំងអស់ --</option>
                  @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_code }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <table id="attendanceTable" class="table table-bordered table-hover table-sm w-100">
            <thead class="thead-light">
              <tr>
                <th width="40">#</th>
                <th>ឈ្មោះ</th>
                <th width="90">ថ្ងៃ</th>
                <th width="90">ស្ថានភាព</th>
                <th width="80">ចូল</th>
                <th width="80">ចេញ</th>
                <th>ចំណាំ</th>
                <th width="90" class="text-center">ការងារ</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Bulk Attendance Modal --}}
  <div class="modal fade" id="bulkAttendanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title"><i class="fas fa-list-check mr-1"></i>ចុះវត្តមានជាក្រុម</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label>ថ្នាក់ <span class="text-danger">*</span></label>
              <select id="bulkClassId" class="form-control select2">
                <option value="">-- ជ្រើសថ្នាក់ --</option>
                @foreach ($classes as $class)
                  <option value="{{ $class->id }}">{{ $class->class_code }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label>ថ្ងៃ <span class="text-danger">*</span></label>
              <input type="text" id="bulkDate" class="form-control flatpickr-date" value="{{ today()->toDateString() }}">
            </div>
          </div>
          <div id="bulkStudentList" class="d-none">
            <table class="table table-sm table-bordered" id="bulkTable">
              <thead class="thead-light">
                <tr>
                  <th>ឈ្មោះ</th>
                  <th width="110">ស្ថានភាព</th>
                  <th width="80">ចូល</th>
                  <th width="80">ចេញ</th>
                  <th>ចំណាំ</th>
                </tr>
              </thead>
              <tbody id="bulkTableBody"></tbody>
            </table>
          </div>
          <p id="bulkEmpty" class="text-muted text-center d-none">គ្មានសិស្ស</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
          <button type="button" class="btn btn-success" id="btnSaveBulk">
            <i class="fas fa-save mr-1"></i>{{ __('app.save') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Edit Attendance Modal --}}
  <div class="modal fade" id="editAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="editAttendanceForm">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">កែប្រែវត្តមាន</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>ស្ថានភាព <span class="text-danger">*</span></label>
              <select name="status" class="form-control" required>
                <option value="present">វត្តមាន</option>
                <option value="absent">អវត្តមាន</option>
                <option value="late">យឺត</option>
                <option value="excused">មានដំណឹង</option>
              </select>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>ម៉ោងចូល</label>
                  <input type="text" name="check_in_time" class="form-control flatpickr-time">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>ម៉ោងចេញ</label>
                  <input type="text" name="check_out_time" class="form-control flatpickr-time">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>ចំណាំ</label>
              <textarea name="note" class="form-control" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-warning">{{ __('app.save') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    let currentType = 'student';
    let dt;

    function buildTable() {
      if (dt) {
        dt.destroy();
      }

      dt = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route('attendances.index') }}',
          data: function(d) {
            d.attendable_type = currentType;
            d.date = $('#filterDate').val();
            d.class_id = $('#filterClass').val();
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'attendable_name',
            name: 'attendable_id'
          },
          {
            data: 'date',
            name: 'date'
          },
          {
            data: 'status_badge',
            name: 'status',
            orderable: false
          },
          {
            data: 'check_in_time',
            name: 'check_in_time'
          },
          {
            data: 'check_out_time',
            name: 'check_out_time'
          },
          {
            data: 'note',
            name: 'note'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
        ],
        order: [
          [2, 'desc']
        ],
        pageLength: 25,
      });
    }

    $(document).ready(function() {
      buildTable();

      // Type toggle
      $('.btn-type').on('click', function() {
        currentType = $(this).data('type');
        $('.btn-type').removeClass('active');
        $(this).addClass('active');
        buildTable();
      });

      // Filter reload
      $('#filterDate, #filterClass').on('change', function() {
        dt.ajax.reload();
      });

      // Edit attendance
      $(document).on('click', '.btn-edit-attendance', function() {
        const id = $(this).data('id');
        $('#editAttendanceForm').attr('action', '/admin/attendances/' + id);
        $('#editAttendanceModal').modal('show');
      });

      $('#editAttendanceForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          method: 'POST',
          data: $(this).serialize() + '&_method=PUT',
          success: function() {
            $('#editAttendanceModal').modal('hide');
            dt.ajax.reload();
          }
        });
      });

      // Bulk modal — load students by class
      $('#bulkClassId').on('change', function() {
        loadBulkStudents();
      });

      function loadBulkStudents() {
        const classId = $('#bulkClassId').val();
        if (!classId) return;
        $.getJSON('/api/classes/' + classId + '/students', function(data) {
          const tbody = $('#bulkTableBody').empty();
          if (!data.length) {
            $('#bulkEmpty').removeClass('d-none');
            $('#bulkStudentList').addClass('d-none');
            return;
          }
          $('#bulkEmpty').addClass('d-none');
          $('#bulkStudentList').removeClass('d-none');
          data.forEach(function(s) {
            tbody.append(`
            <tr>
              <td>${s.khmer_name}</td>
              <td>
                <input type="hidden" name="attendances[${s.id}][student_id]" value="${s.id}">
                <select name="attendances[${s.id}][status]" class="form-control form-control-sm">
                  <option value="present">វត្តមាន</option>
                  <option value="absent">អវត្តមាន</option>
                  <option value="late">យឺត</option>
                  <option value="excused">មានដំណឹង</option>
                </select>
              </td>
              <td><input type="text" name="attendances[${s.id}][check_in_time]" class="form-control form-control-sm flatpickr-time"></td>
              <td><input type="text" name="attendances[${s.id}][check_out_time]" class="form-control form-control-sm flatpickr-time"></td>
              <td><input type="text" name="attendances[${s.id}][note]" class="form-control form-control-sm"></td>
            </tr>
          `);
          });
          // Initialize flatpickr on dynamically added time inputs
          document.querySelectorAll('.flatpickr-time:not(._flatpickr)').forEach(function(el) {
            window.flatpickr(el, {
              enableTime: true,
              noCalendar: true,
              dateFormat: 'H:i',
              allowInput: true
            });
          });
        });
      }

      $('#btnBulkAttendance').on('click', function() {
        $('#bulkAttendanceModal').modal('show');
      });

      $('#btnSaveBulk').on('click', function() {
        const classId = $('#bulkClassId').val();
        const date = $('#bulkDate').val();
        if (!classId || !date) {
          alert('ជ្រើសសាខា ហើយថ្ងៃ');
          return;
        }

        const rows = [];
        $('#bulkTableBody tr').each(function() {
          const sid = $(this).find('input[type=hidden]').val();
          const status = $(this).find('select').val();
          const ci = $(this).find('input[type=time]:first').val();
          const co = $(this).find('input[type=time]:last').val();
          const note = $(this).find('input[type=text]').val();
          rows.push({
            student_id: sid,
            status,
            check_in_time: ci,
            check_out_time: co,
            note
          });
        });

        $.ajax({
          url: '{{ route('attendances.bulk-store') }}',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            class_id: classId,
            date,
            attendances: rows,
          },
          success: function() {
            $('#bulkAttendanceModal').modal('hide');
            dt.ajax.reload();
            toastr.success('ចុះវត្តមានបានជោគជ័យ');
          },
          error: function(xhr) {
            toastr.error('មានបញ្ហា: ' + (xhr.responseJSON?.message ?? ''));
          }
        });
      });

      // SweetAlert delete
      $(document).on('click', '.btn-swal-delete', function() {
        const form = $(this).closest('form');
        Swal.fire({
          title: 'លុបកំណត់ត្រាវត្តមាន?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          confirmButtonText: 'លុប',
          cancelButtonText: 'បោះបង់',
        }).then((r) => {
          if (r.isConfirmed) form.submit();
        });
      });
    });
  </script>
@endpush
