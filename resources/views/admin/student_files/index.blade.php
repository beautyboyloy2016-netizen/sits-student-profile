@extends('admin.layouts.master_layout')

@section('title', 'Student Files')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Files: {{ $student->khmer_name }}</h1></div>
        <div class="col-sm-6">
          <a href="{{ route('students.show', $student) }}" class="btn btn-secondary float-right">Back to Student</a>
        </div>
</div>
<div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header"><h3 class="card-title">Upload File</h3></div>
            <div class="card-body">
              <form action="{{ route('students.files.store', $student) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label>File Type</label>
                  <select name="file_type" class="form-control" required>
                    <option value="photo">Photo</option>
                    <option value="birth_certificate">Birth Certificate</option>
                    <option value="id_card">ID Card</option>
                    <option value="certificate">Certificate</option>
                    <option value="diploma">Diploma</option>
                    <option value="document">Document</option>
                    <option value="other">Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>File</label>
                  <input type="file" name="file" class="form-control" required>
                </div>
                <div class="form-group">
                  <div class="form-check">
                    <input type="checkbox" name="is_primary" value="1" class="form-check-input" id="is_primary">
                    <label class="form-check-label" for="is_primary">Primary</label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr><th>Type</th><th>Name</th><th>Size</th><th>Primary</th><th>Uploaded By</th><th>Actions</th></tr>
                </thead>
                <tbody>
                  @foreach($student->files as $file)
                  <tr>
                    <td>{{ $file->file_type }}</td>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                    <td>{!! $file->is_primary ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>' !!}</td>
                    <td>{{ $file->uploader?->name }}</td>
                    <td>
                      <a href="{{ route('students.files.download', [$student, $file]) }}" class="btn btn-sm btn-info">Download</a>
                      <form action="{{ route('students.files.destroy', [$student, $file]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete file?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
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
