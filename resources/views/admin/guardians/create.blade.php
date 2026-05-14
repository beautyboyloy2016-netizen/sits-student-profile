@extends('admin.layouts.master_layout')

@section('pageTitle', 'Add Guardian - Student Profile Management')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Add New Guardian</h3>
        </div>
        <div class="card-body" id="app">
          <form action="{{ route('guardians.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name (Khmer) <span class="text-danger">*</span></label>
                  <input type="text" name="name_kh" class="form-control" value="{{ old('name_kh') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name (English)</label>
                  <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Occupation</label>
                  <input type="text" name="occupation" class="form-control" value="{{ old('occupation') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Link to Student</label>
                  <select name="student_id" class="form-control tom-select">
                    <option value="">Select Student (optional)</option>
                    @foreach($students as $student)
                      <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->student_code }} - {{ $student->khmer_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Relationship</label>
                  <input type="text" name="relationship" class="form-control" value="{{ old('relationship') }}" placeholder="e.g. Father, Mother">
                </div>
              </div>
            </div>
            <h5>Address</h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Province</label>
                  <select name="province_id" class="form-control tom-select province-select" data-target="district_id">
                    <option value="">Select Province</option>
                    @foreach($provinces as $province)
                      <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name_kh }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>District</label>
                  <select name="district_id" id="district_id" class="form-control tom-select district-select" data-target="commune_id">
                    <option value="">Select District</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Commune</label>
                  <select name="commune_id" id="commune_id" class="form-control tom-select commune-select" data-target="village_id">
                    <option value="">Select Commune</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Village</label>
                  <select name="village_id" id="village_id" class="form-control tom-select">
                    <option value="">Select Village</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Street</label>
                  <input type="text" name="street" class="form-control" value="{{ old('street') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>House No</label>
                  <input type="text" name="house_no" class="form-control" value="{{ old('house_no') }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Guardian</button>
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
    new window.TomSelect(el, { create: false });
  });

  document.querySelectorAll('.province-select').forEach(function(provinceSelect) {
    var ts = provinceSelect.tomselect;
    if (ts) {
      ts.on('change', function(value) {
        var districtTarget = provinceSelect.getAttribute('data-target');
        var districtEl = document.getElementById(districtTarget);
        if (!districtEl) return;
        var dts = districtEl.tomselect;
        if (dts) { dts.clear(); dts.clearOptions(); }
        if (!value) return;
        axios.get('/api/districts?province_id=' + value).then(function(res) {
          res.data.forEach(function(d) { if (dts) dts.addOption({ value: d.id, text: d.name_kh }); });
        });
      });
    }
  });

  document.querySelectorAll('.district-select').forEach(function(districtSelect) {
    var ts = districtSelect.tomselect;
    if (ts) {
      ts.on('change', function(value) {
        var communeTarget = districtSelect.getAttribute('data-target');
        var communeEl = document.getElementById(communeTarget);
        if (!communeEl) return;
        var cts = communeEl.tomselect;
        if (cts) { cts.clear(); cts.clearOptions(); }
        if (!value) return;
        axios.get('/api/communes?district_id=' + value).then(function(res) {
          res.data.forEach(function(c) { if (cts) cts.addOption({ value: c.id, text: c.name_kh }); });
        });
      });
    }
  });

  document.querySelectorAll('.commune-select').forEach(function(communeSelect) {
    var ts = communeSelect.tomselect;
    if (ts) {
      ts.on('change', function(value) {
        var villageTarget = communeSelect.getAttribute('data-target');
        var villageEl = document.getElementById(villageTarget);
        if (!villageEl) return;
        var vts = villageEl.tomselect;
        if (vts) { vts.clear(); vts.clearOptions(); }
        if (!value) return;
        axios.get('/api/villages?commune_id=' + value).then(function(res) {
          res.data.forEach(function(v) { if (vts) vts.addOption({ value: v.id, text: v.name_kh }); });
        });
      });
    }
  });
});
</script>
@endpush
