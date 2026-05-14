@extends('admin.layouts.master_layout')

@section('title', 'Edit User')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Edit User</h1></div>
</div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Password <small>(leave blank to keep current)</small></label>
                  <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>Blocked</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Roles</label>
                  <select name="role_ids[]" class="form-control" multiple>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    @endsection
