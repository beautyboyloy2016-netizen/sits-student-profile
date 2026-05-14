@extends('admin.layouts.master_layout')

@section('title', 'Add Staff')

@section('content')
<div class="row mb-3"><div class="col-sm-6">
          <h1 class="m-0">Add Staff</h1>
        </div>
</div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Staff Code</label>
                  <input type="text" name="staff_code" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Name (KH)</label>
                  <input type="text" name="name_kh" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Name (EN)</label>
                  <input type="text" name="name_en" class="form-control">
                </div>
                <div class="form-group">
                  <label>Gender</label>
                  <select name="gender_id" class="form-control">
                    <option value="">-- Select --</option>
                    @foreach($genders as $g)
                    <option value="{{ $g->id }}">{{ $g->name_kh }} ({{ $g->name_en }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                  <label>Position</label>
                  <input type="text" name="position" class="form-control">
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    @endsection
