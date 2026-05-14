@extends('admin.layouts.master_layout')

@section('title', 'Update Requests')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Update Requests: {{ $student->khmer_name }}</h1></div>
        <div class="col-sm-6">
          <a href="{{ route('students.show', $student) }}" class="btn btn-secondary float-right">Back to Student</a>
        </div>
</div>
<div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header"><h3 class="card-title">New Request</h3></div>
            <div class="card-body">
              <form action="{{ route('students.update-requests.store', $student) }}" method="POST">
                @csrf
                <div class="form-group">
                  <label>Field Name</label>
                  <input type="text" name="field_name" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Old Value</label>
                  <textarea name="old_value" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-group">
                  <label>New Value</label>
                  <textarea name="new_value" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-group">
                  <label>Reason</label>
                  <textarea name="reason" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr><th>Field</th><th>Old Value</th><th>New Value</th><th>Reason</th><th>Requested By</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                  @foreach($student->updateRequests as $req)
                  <tr>
                    <td>{{ $req->field_name }}</td>
                    <td>{{ Str::limit($req->old_value, 30) }}</td>
                    <td>{{ Str::limit($req->new_value, 30) }}</td>
                    <td>{{ Str::limit($req->reason, 30) }}</td>
                    <td>{{ $req->requester?->name }}</td>
                    <td><span class="badge badge-{{ $req->status === 'approved' ? 'success' : ($req->status === 'rejected' ? 'danger' : 'warning') }}">{{ $req->status }}</span></td>
                    <td>
                      @if($req->status === 'pending')
                      <form action="{{ route('students.update-requests.approve', [$student, $req]) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Approve</button>
                      </form>
                      <form action="{{ route('students.update-requests.reject', [$student, $req]) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-danger">Reject</button>
                      </form>
                      @endif
                      <form action="{{ route('students.update-requests.destroy', [$student, $req]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-secondary">Delete</button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endsection
