@extends('admin.layouts.master_layout')

@section('title', 'Add User')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Add User</h1></div>
</div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="blocked">Blocked</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Roles</label>
                  <select name="role_ids[]" class="form-control" multiple>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    @endsection
