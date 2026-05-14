@extends('admin.layouts.master_layout')

@section('title', 'Edit Staff')

@section('content')
<div class="row mb-3"><div class="col-sm-6">
          <h1 class="m-0">Edit Staff</h1>
        </div>
</div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('staff.update', $staff) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Staff Code</label>
                  <input type="text" name="staff_code" class="form-control" value="{{ $staff->staff_code }}" required>
                </div>
                <div class="form-group">
                  <label>Name (KH)</label>
                  <input type="text" name="name_kh" class="form-control" value="{{ $staff->name_kh }}" required>
                </div>
                <div class="form-group">
                  <label>Name (EN)</label>
                  <input type="text" name="name_en" class="form-control" value="{{ $staff->name_en }}">
                </div>
                <div class="form-group">
                  <label>Gender</label>
                  <select name="gender_id" class="form-control">
                    <option value="">-- Select --</option>
                    @foreach($genders as $g)
                    <option value="{{ $g->id }}" {{ $staff->gender_id == $g->id ? 'selected' : '' }}>{{ $g->name_kh }} ({{ $g->name_en }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control" value="{{ $staff->phone }}">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="{{ $staff->email }}">
                </div>
                <div class="form-group">
                  <label>Position</label>
                  <input type="text" name="position" class="form-control" value="{{ $staff->position }}">
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="active" {{ $staff->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $staff->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    @endsection
