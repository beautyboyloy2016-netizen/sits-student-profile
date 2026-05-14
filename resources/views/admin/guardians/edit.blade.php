@extends('admin.layouts.master_layout')

@section('pageTitle', 'Edit Guardian - Student Profile Management')

@section('content')
  @php
    $addr = $guardian->address;
    $linkedStudent = $guardian->students->first();
    $linkedStudentId = $linkedStudent?->id;
    $linkedRelationship = $linkedStudent?->pivot?->relationship;
  @endphp
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Guardian</h3>
        </div>
        <div class="card-body" id="app">
          <form action="{{ route('guardians.update', $guardian->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name (Khmer) <span class="text-danger">*</span></label>
                  <input type="text" name="name_kh" class="form-control"
                    value="{{ old('name_kh', $guardian->name_kh) }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name (English)</label>
                  <input type="text" name="name_en" class="form-control"
                    value="{{ old('name_en', $guardian->name_en) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control" value="{{ old('phone', $guardian->phone) }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Occupation</label>
                  <input type="text" name="occupation" class="form-control"
                    value="{{ old('occupation', $guardian->occupation) }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Link to Student</label>
                  <select name="student_id" class="form-control tom-select">
                    <option value="">Select Student (optional)</option>
                    @foreach ($students as $student)
                      <option value="{{ $student->id }}"
                        {{ old('student_id', $linkedStudentId) == $student->id ? 'selected' : '' }}>
                        {{ $student->student_code }} - {{ $student->khmer_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Relationship</label>
                  <input type="text" name="relationship" class="form-control"
                    value="{{ old('relationship', $linkedRelationship) }}" placeholder="e.g. Father, Mother">
                </div>
              </div>
            </div>
            <h5>Address</h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Province</label>
                  <select name="province_id" class="form-control tom-select province-select" data-target="district_id"
                    data-selected="{{ old('province_id', $addr?->province_id) }}">
                    <option value="">Select Province</option>
                    @foreach ($provinces as $province)
                      <option value="{{ $province->id }}"
                        {{ old('province_id', $addr?->province_id) == $province->id ? 'selected' : '' }}>
                        {{ $province->name_kh }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>District</label>
                  <select name="district_id" id="district_id" class="form-control tom-select district-select"
                    data-target="commune_id" data-selected="{{ old('district_id', $addr?->district_id) }}">
                    <option value="">Select District</option>
                    @foreach ($districts as $d)
                      <option value="{{ $d->id }}"
                        {{ old('district_id', $addr?->district_id) == $d->id ? 'selected' : '' }}>
                        {{ $d->name_kh }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Commune</label>
                  <select name="commune_id" id="commune_id" class="form-control tom-select commune-select"
                    data-target="village_id" data-selected="{{ old('commune_id', $addr?->commune_id) }}">
                    <option value="">Select Commune</option>
                    @foreach ($communes as $c)
                      <option value="{{ $c->id }}"
                        {{ old('commune_id', $addr?->commune_id) == $c->id ? 'selected' : '' }}>
                        {{ $c->name_kh }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Village</label>
                  <select name="village_id" id="village_id" class="form-control tom-select"
                    data-selected="{{ old('village_id', $addr?->village_id) }}">
                    <option value="">Select Village</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Street</label>
                  <input type="text" name="street" class="form-control"
                    value="{{ old('street', $addr?->street) }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>House No</label>
                  <input type="text" name="house_no" class="form-control"
                    value="{{ old('house_no', $addr?->house_no) }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea name="note" class="form-control" rows="2">{{ old('note', $guardian->note) }}</textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Guardian</button>
              <a href="{{ route('guardians.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.tom-select').forEach(function(el) {
        if (!el.tomselect) new window.TomSelect(el, { create: false });
      });

      function tsOf(el) { return el && el.tomselect ? el.tomselect : null; }

      function resetTs(el) {
        var ts = tsOf(el);
        if (ts) { ts.clear(); ts.clearOptions(); ts.close(); }
      }

      function loadOptions(ts, url) {
        return axios.get(url).then(function(res) {
          res.data.forEach(function(item) {
            ts.addOption({ value: item.id, text: item.name_kh || item.name || '' });
          });
          ts.refreshOptions(false);
        });
      }

      // Interactive cascade: when user changes Province/District/Commune
      document.querySelectorAll('.province-select').forEach(function(sel) {
        var ts = tsOf(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var districtEl = document.getElementById(sel.getAttribute('data-target'));
          var communeEl  = districtEl ? document.getElementById(districtEl.getAttribute('data-target')) : null;
          var villageEl  = communeEl  ? document.getElementById(communeEl.getAttribute('data-target')) : null;
          resetTs(districtEl); resetTs(communeEl); resetTs(villageEl);
          if (!value) return;
          loadOptions(tsOf(districtEl), '/api/districts?province_id=' + value);
        });
      });

      document.querySelectorAll('.district-select').forEach(function(sel) {
        var ts = tsOf(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var communeEl = document.getElementById(sel.getAttribute('data-target'));
          var villageEl = communeEl ? document.getElementById(communeEl.getAttribute('data-target')) : null;
          resetTs(communeEl); resetTs(villageEl);
          if (!value) return;
          loadOptions(tsOf(communeEl), '/api/communes?district_id=' + value);
        });
      });

      document.querySelectorAll('.commune-select').forEach(function(sel) {
        var ts = tsOf(sel);
        if (!ts) return;
        ts.on('change', function(value) {
          var villageEl = document.getElementById(sel.getAttribute('data-target'));
          resetTs(villageEl);
          if (!value) return;
          loadOptions(tsOf(villageEl), '/api/villages?commune_id=' + value);
        });
      });

      // Explicit init-cascade: walk the saved chain and pre-load villages
      document.querySelectorAll('.province-select').forEach(function(sel) {
        var provinceValue = sel.getAttribute('data-selected') || (tsOf(sel) ? tsOf(sel).getValue() : sel.value);
        if (!provinceValue) return;

        var districtEl = document.getElementById(sel.getAttribute('data-target'));
        var communeEl  = districtEl ? document.getElementById(districtEl.getAttribute('data-target')) : null;
        var villageEl  = communeEl  ? document.getElementById(communeEl.getAttribute('data-target')) : null;

        var savedDistrict = districtEl ? (districtEl.getAttribute('data-selected') || districtEl.value) : null;
        var savedCommune  = communeEl  ? (communeEl.getAttribute('data-selected')  || communeEl.value)  : null;
        var savedVillage  = villageEl  ? (villageEl.getAttribute('data-selected')  || villageEl.value)  : null;

        resetTs(districtEl); resetTs(communeEl); resetTs(villageEl);

        loadOptions(tsOf(districtEl), '/api/districts?province_id=' + provinceValue)
          .then(function() {
            var dts = tsOf(districtEl);
            if (savedDistrict && dts) dts.setValue(String(savedDistrict), true);
            if (!savedDistrict) return Promise.resolve();
            resetTs(communeEl); resetTs(villageEl);
            return loadOptions(tsOf(communeEl), '/api/communes?district_id=' + savedDistrict);
          })
          .then(function() {
            var cts = tsOf(communeEl);
            if (savedCommune && cts) cts.setValue(String(savedCommune), true);
            if (!savedCommune) return Promise.resolve();
            resetTs(villageEl);
            return loadOptions(tsOf(villageEl), '/api/villages?commune_id=' + savedCommune);
          })
          .then(function() {
            var vts = tsOf(villageEl);
            if (savedVillage && vts) vts.setValue(String(savedVillage), true);
          });
      });
    });
  </script>
@endpush
