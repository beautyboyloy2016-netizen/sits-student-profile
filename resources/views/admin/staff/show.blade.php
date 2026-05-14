@extends('admin.layouts.master_layout')

@section('title', 'Staff Details')

@section('content')
<div class="row mb-3"><div class="col-sm-6">
          <h1 class="m-0">Staff Details</h1>
        </div>
</div>
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered">
            <tr><th>Staff Code</th><td>{{ $staff->staff_code }}</td></tr>
            <tr><th>Name (KH)</th><td>{{ $staff->name_kh }}</td></tr>
            <tr><th>Name (EN)</th><td>{{ $staff->name_en }}</td></tr>
            <tr><th>Gender</th><td>{{ $staff->gender?->name_en }}</td></tr>
            <tr><th>Position</th><td>{{ $staff->position }}</td></tr>
            <tr><th>Phone</th><td>{{ $staff->phone }}</td></tr>
            <tr><th>Email</th><td>{{ $staff->email }}</td></tr>
            <tr><th>Status</th><td>{{ $staff->status }}</td></tr>
          </table>
          <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
          <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">Edit</a>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header"><h3 class="card-title">Classes Teaching</h3></div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr><th>Class Code</th><th>Course</th><th>Level</th><th>Academic Year</th><th>Status</th></tr>
            </thead>
            <tbody>
              @forelse($staff->classes as $class)
              <tr>
                <td>{{ $class->class_code }}</td>
                <td>{{ $class->course?->name }}</td>
                <td>{{ $class->level?->name }}</td>
                <td>{{ $class->academicYear?->name }}</td>
                <td>{{ $class->status }}</td>
              </tr>
              @empty
              <tr><td colspan="5" class="text-center">No classes assigned.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    @endsection
