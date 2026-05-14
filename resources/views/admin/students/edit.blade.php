@extends('admin.layouts.master_layout')

@section('pageTitle', 'Edit Student - Student Profile Management')

@section('content')
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">ប្រវត្តិរូបសិស្ស / Edit Student: {{ $student->khmer_name }}</h3>
    </div>
    <div class="card-body" id="app">
      <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
          <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row">

          {{-- ===== LEFT COLUMN ===== --}}
          <div class="col-md-6 pr-md-4" style="border-right: 1px solid #dee2e6;">

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Student Code <span class="text-danger">*</span></label>
              <div class="col-7">
                <input type="text" name="student_code" class="form-control form-control-sm"
                  value="{{ old('student_code', $student->student_code) }}" required>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Khmer Name <span class="text-danger">*</span></label>
              <div class="col-7">
                <input type="text" name="khmer_name" class="form-control form-control-sm"
                  value="{{ old('khmer_name', $student->khmer_name) }}" required>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Latin Name</label>
              <div class="col-7">
                <input type="text" name="latin_name" class="form-control form-control-sm"
                  value="{{ old('latin_name', $student->latin_name) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Gender</label>
              <div class="col-7">
                @foreach ($genders as $gender)
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender_id" value="{{ $gender->id }}"
                      {{ old('gender_id', $student->gender_id) == $gender->id ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $gender->name_kh }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Date of Birth</label>
              <div class="col-7">
                <input type="text" name="date_of_birth" class="form-control form-control-sm flatpickr"
                  value="{{ old('date_of_birth', $student->date_of_birth) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Birth Province</label>
              <div class="col-7">
                <select name="birth_province_id" class="tom-select province-select" data-target="birth_district_id">
                  <option value="">Select Province</option>
                  @foreach ($provinces as $province)
                    <option value="{{ $province->id }}"
                      {{ (old('birth_province_id') ?: $student->birthPlace?->province_id) == $province->id ? 'selected' : '' }}>
                      {{ $province->name_kh }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Birth District</label>
              <div class="col-7">
                <select name="birth_district_id" id="birth_district_id" class="tom-select district-select"
                  data-target="birth_commune_id">
                  <option value="">Select District</option>
                  @foreach ($birthDistricts as $d)
                    <option value="{{ $d->id }}"
                      {{ (old('birth_district_id') ?: $student->birthPlace?->district_id) == $d->id ? 'selected' : '' }}>
                      {{ $d->name_kh }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Birth Commune</label>
              <div class="col-7">
                <select name="birth_commune_id" id="birth_commune_id" class="tom-select commune-select"
                  data-target="birth_village_id">
                  <option value="">Select Commune</option>
                  @foreach ($birthCommunes as $c)
                    <option value="{{ $c->id }}"
                      {{ (old('birth_commune_id') ?: $student->birthPlace?->commune_id) == $c->id ? 'selected' : '' }}>
                      {{ $c->name_kh }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Birth Village</label>
              <div class="col-7">
                <select name="birth_village_id" id="birth_village_id" class="tom-select"
                  data-selected="{{ old('birth_village_id', $student->birthPlace?->village_id) }}">
                  <option value="">Select Village</option>
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Current Province</label>
              <div class="col-7">
                <select name="current_province_id" class="tom-select province-select" data-target="current_district_id">
                  <option value="">Select Province</option>
                  @foreach ($provinces as $province)
                    <option value="{{ $province->id }}"
                      {{ (old('current_province_id') ?: $student->currentAddress?->province_id) == $province->id ? 'selected' : '' }}>
                      {{ $province->name_kh }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Current District</label>
              <div class="col-7">
                <select name="current_district_id" id="current_district_id" class="tom-select district-select"
                  data-target="current_commune_id">
                  <option value="">Select District</option>
                  @foreach ($currentDistricts as $d)
                    <option value="{{ $d->id }}"
                      {{ (old('current_district_id') ?: $student->currentAddress?->district_id) == $d->id ? 'selected' : '' }}>
                      {{ $d->name_kh }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Current Commune</label>
              <div class="col-7">
                <select name="current_commune_id" id="current_commune_id" class="tom-select commune-select"
                  data-target="current_village_id">
                  <option value="">Select Commune</option>
                  @foreach ($currentCommunes as $c)
                    <option value="{{ $c->id }}"
                      {{ (old('current_commune_id') ?: $student->currentAddress?->commune_id) == $c->id ? 'selected' : '' }}>
                      {{ $c->name_kh }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Current Village</label>
              <div class="col-7">
                <select name="current_village_id" id="current_village_id" class="tom-select"
                  data-selected="{{ old('current_village_id', $student->currentAddress?->village_id) }}">
                  <option value="">Select Village</option>
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Course</label>
              <div class="col-7">
                @php $currentEnrollment = $student->enrollments->first(); @endphp
                <select name="course_id" class="tom-select course-select" data-target="class_id">
                  <option value="">Select Course</option>
                  @foreach ($courses as $course)
                    <option value="{{ $course->id }}"
                      {{ old('course_id', $currentEnrollment?->class?->course_id) == $course->id ? 'selected' : '' }}>
                      {{ $course->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Enroll Date</label>
              <div class="col-7">
                <input type="text" name="enroll_date" class="form-control form-control-sm flatpickr"
                  value="{{ old('enroll_date', $currentEnrollment?->enroll_date) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Shift</label>
              <div class="col-7">
                <select name="shift_id" class="tom-select">
                  <option value="">Select Shift</option>
                  @foreach ($shifts as $shift)
                    <option value="{{ $shift->id }}"
                      {{ old('shift_id', $currentEnrollment?->shift_id) == $shift->id ? 'selected' : '' }}>
                      {{ $shift->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Phone</label>
              <div class="col-7">
                <input type="text" name="phone" class="form-control form-control-sm"
                  value="{{ old('phone', $student->phone) }}">
              </div>
            </div>

          </div>{{-- end left column --}}

          {{-- ===== RIGHT COLUMN ===== --}}
          <div class="col-md-6 pl-md-4">

            @php $primaryGuardian = $student->guardians->first(); @endphp

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Father / Guardian (KH)</label>
              <div class="col-7">
                <input type="text" name="guardian_name_kh" class="form-control form-control-sm"
                  value="{{ old('guardian_name_kh', $primaryGuardian?->name_kh) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Father Phone</label>
              <div class="col-7">
                <input type="text" name="guardian_phone" class="form-control form-control-sm"
                  value="{{ old('guardian_phone', $primaryGuardian?->phone) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Mother / Guardian (EN)</label>
              <div class="col-7">
                <input type="text" name="guardian_name_en" class="form-control form-control-sm"
                  value="{{ old('guardian_name_en', $primaryGuardian?->name_en) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Relationship</label>
              <div class="col-7">
                <input type="text" name="guardian_relationship" class="form-control form-control-sm"
                  value="{{ old('guardian_relationship', $student->guardians->first()?->pivot?->relationship) }}"
                  placeholder="e.g. Father, Mother">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Occupation</label>
              <div class="col-7">
                <input type="text" name="guardian_occupation" class="form-control form-control-sm"
                  value="{{ old('guardian_occupation', $primaryGuardian?->occupation) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Academic Year</label>
              <div class="col-7">
                <select name="academic_year_id" class="tom-select">
                  <option value="">Select Year</option>
                  @foreach ($academicYears as $year)
                    <option value="{{ $year->id }}"
                      {{ old('academic_year_id', $currentEnrollment?->academic_year_id) == $year->id ? 'selected' : '' }}>
                      {{ $year->name }}{{ $year->is_current ? ' (Current)' : '' }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Class</label>
              <div class="col-7">
                <select name="class_id" id="class_id" class="tom-select">
                  <option value="">Select Class</option>
                  @foreach ($classesForCourse as $cls)
                    <option value="{{ $cls->id }}"
                      {{ old('class_id', $currentEnrollment?->class_id) == $cls->id ? 'selected' : '' }}>
                      {{ $cls->class_code }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Email</label>
              <div class="col-7">
                <input type="email" name="email" class="form-control form-control-sm"
                  value="{{ old('email', $student->email) }}">
              </div>
            </div>

            <div class="form-group row align-items-center mb-2">
              <label class="col-5 col-form-label font-weight-bold">Status <span class="text-danger">*</span></label>
              <div class="col-7">
                <select name="status" class="tom-select" required>
                  <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active
                  </option>
                  <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>
                    Inactive</option>
                  <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>
                    Graduated</option>
                  <option value="suspended" {{ old('status', $student->status) == 'suspended' ? 'selected' : '' }}>
                    Suspended</option>
                  <option value="dropped" {{ old('status', $student->status) == 'dropped' ? 'selected' : '' }}>Dropped
                  </option>
                </select>
              </div>
            </div>

            {{-- Note + Photo side by side --}}
            <div class="row mb-3">
              <div class="col-7">
                <label class="font-weight-bold">Note</label>
                <textarea name="note" class="form-control form-control-sm" rows="5">{{ old('note', $student->note) }}</textarea>
              </div>
              <div class="col-5 text-center">
                <label class="font-weight-bold d-block">Photo</label>
                <div id="photo-preview-box"
                  style="width:100%;height:120px;border:1px solid #ced4da;border-radius:4px;display:flex;align-items:center;justify-content:center;overflow:hidden;background:#f8f9fa;margin-bottom:6px;">
                  @if ($student->photo_path)
                    <img id="photo-preview" src="{{ asset('storage/' . $student->photo_path) }}" alt="Photo"
                      style="max-height:120px;max-width:100%;">
                  @else
                    <img id="photo-preview" src="" alt=""
                      style="max-height:120px;max-width:100%;display:none;">
                    <span id="photo-placeholder" class="text-muted small">No Photo</span>
                  @endif
                </div>
                <label for="photo-input" class="btn btn-sm btn-outline-primary w-100" style="cursor:pointer;">
                  <i class="fas fa-upload"></i> Upload Image
                </label>
                <input type="file" id="photo-input" name="photo" accept="image/*" style="display:none;">
              </div>
            </div>

            {{-- Action Buttons --}}
            <div class="row mt-2">
              <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary btn-sm px-4">
                  <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm px-4">
                  <i class="fas fa-times"></i> Cancel
                </a>
              </div>
            </div>

          </div>{{-- end right column --}}

        </div>{{-- end main row --}}
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // ── Flatpickr ──────────────────────────────────────────────────────
      document.querySelectorAll('.flatpickr').forEach(function(el) {
        window.flatpickr(el, {
          dateFormat: 'Y-m-d',
          allowInput: true
        });
      });

      // ── TomSelect (initialize ALL selects first) ───────────────────────
      var tsOptions = {
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        }
      };
      document.querySelectorAll('select.tom-select').forEach(function(el) {
        if (!el.tomselect) {
          new window.TomSelect(el, tsOptions);
        }
      });

      // ── Cascade helpers ────────────────────────────────────────────────
      function tsInstance(el) {
        return el && el.tomselect ? el.tomselect : null;
      }

      function resetTs(el) {
        var ts = tsInstance(el);
        if (ts) {
          ts.clear();
          ts.clearOptions();
          ts.close();
        }
      }

      function loadOptions(ts, url) {
        return axios.get(url).then(function(res) {
          res.data.forEach(function(item) {
            ts.addOption({
              value: item.id,
              text: item.name_kh || item.name || ''
            });
          });
          ts.refreshOptions(false);
        });
      }

      // Province -> District -> Commune -> Village
      document.querySelectorAll('.province-select').forEach(function(sel) {
        var ts = tsInstance(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var districtEl = document.getElementById(sel.getAttribute('data-target'));
          var communeId = districtEl ? districtEl.getAttribute('data-target') : null;
          var communeEl = communeId ? document.getElementById(communeId) : null;
          var villageId = communeEl ? communeEl.getAttribute('data-target') : null;
          var villageEl = villageId ? document.getElementById(villageId) : null;
          resetTs(districtEl);
          resetTs(communeEl);
          resetTs(villageEl);
          if (!value) return;
          loadOptions(tsInstance(districtEl), '/api/districts?province_id=' + value);
        });
      });

      document.querySelectorAll('.district-select').forEach(function(sel) {
        var ts = tsInstance(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var communeEl = document.getElementById(sel.getAttribute('data-target'));
          var villageId = communeEl ? communeEl.getAttribute('data-target') : null;
          var villageEl = villageId ? document.getElementById(villageId) : null;
          resetTs(communeEl);
          resetTs(villageEl);
          if (!value) return;
          loadOptions(tsInstance(communeEl), '/api/communes?district_id=' + value);
        });
      });

      document.querySelectorAll('.commune-select').forEach(function(sel) {
        var ts = tsInstance(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var villageEl = document.getElementById(sel.getAttribute('data-target'));
          resetTs(villageEl);
          if (!value) return;
          loadOptions(tsInstance(villageEl), '/api/villages?commune_id=' + value);
        });
      });

      // Pre-populate cascading location selects on initial load
      document.querySelectorAll('.province-select').forEach(function(sel) {
        var ts = tsInstance(sel);
        var provinceValue = ts ? ts.getValue() : sel.value;
        if (!provinceValue) return;

        var districtEl = document.getElementById(sel.getAttribute('data-target'));
        var communeId = districtEl ? districtEl.getAttribute('data-target') : null;
        var communeEl = communeId ? document.getElementById(communeId) : null;
        var villageId = communeEl ? communeEl.getAttribute('data-target') : null;
        var villageEl = villageId ? document.getElementById(villageId) : null;

        var savedDistrictValue = districtEl ? districtEl.value : null;
        var savedCommuneValue = communeEl ? communeEl.value : null;
        var savedVillageValue = villageEl ? (villageEl.getAttribute('data-selected') || villageEl.value) : null;

        resetTs(districtEl);
        resetTs(communeEl);
        resetTs(villageEl);

        loadOptions(tsInstance(districtEl), '/api/districts?province_id=' + provinceValue)
          .then(function() {
            var districtTs = tsInstance(districtEl);
            if (savedDistrictValue && districtTs) districtTs.setValue(String(savedDistrictValue), true);
            if (!savedDistrictValue) return Promise.resolve();
            resetTs(communeEl);
            resetTs(villageEl);
            return loadOptions(tsInstance(communeEl), '/api/communes?district_id=' + savedDistrictValue);
          })
          .then(function() {
            var communeTs = tsInstance(communeEl);
            if (savedCommuneValue && communeTs) communeTs.setValue(String(savedCommuneValue), true);
            if (!savedCommuneValue) return Promise.resolve();
            resetTs(villageEl);
            return loadOptions(tsInstance(villageEl), '/api/villages?commune_id=' + savedCommuneValue);
          })
          .then(function() {
            var villageTs = tsInstance(villageEl);
            if (savedVillageValue && villageTs) villageTs.setValue(String(savedVillageValue), true);
          });
      });

      // Course -> Class
      function rebuildClassSelect(classEl, classes, selectedId) {
        if (classEl.tomselect) classEl.tomselect.destroy();
        classEl.innerHTML = '<option value="">Select Class</option>';
        classes.forEach(function(c) {
          var opt = document.createElement('option');
          opt.value = c.id;
          opt.textContent = c.class_code + (c.level ? ' - ' + c.level.name : '');
          if (selectedId && c.id == selectedId) opt.selected = true;
          classEl.appendChild(opt);
        });
        var newTs = new window.TomSelect(classEl, {
          create: false,
          allowEmptyOption: true
        });
        if (classes.length === 1) newTs.setValue(String(classes[0].id), true);
        return newTs;
      }

      document.querySelectorAll('.course-select').forEach(function(sel) {
        var ts = tsInstance(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var classEl = document.getElementById(sel.getAttribute('data-target'));
          if (!classEl) return;
          if (!value) {
            rebuildClassSelect(classEl, []);
            return;
          }
          $.getJSON('/api/classes', {
            course_id: value
          }, function(res) {
            rebuildClassSelect(classEl, res);
          });
        });
      });

      // ── Pre-select saved class value after TomSelect init ──────────────
      @if (isset($currentEnrollment) && $currentEnrollment?->class_id)
        var classEl = document.getElementById('class_id');
        if (classEl && classEl.tomselect) {
          classEl.tomselect.setValue('{{ $currentEnrollment->class_id }}', true);
        }
      @endif

      // ── Photo preview ──────────────────────────────────────────────────
      var photoInput = document.getElementById('photo-input');
      if (photoInput) {
        photoInput.addEventListener('change', function() {
          var file = this.files[0];
          if (!file) return;
          var reader = new FileReader();
          reader.onload = function(e) {
            var preview = document.getElementById('photo-preview');
            var placeholder = document.getElementById('photo-placeholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
          };
          reader.readAsDataURL(file);
        });
      }
    });
  </script>
@endpush
