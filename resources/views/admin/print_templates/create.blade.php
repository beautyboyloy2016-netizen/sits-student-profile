@extends('admin.layouts.master_layout')

@section('title', 'Add Print Template')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Add Print Template</h1></div>
</div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('print-templates.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Template Type</label>
                  <select name="template_type" class="form-control" required>
                    <option value="student_card">Student Card</option>
                    <option value="certificate">Certificate</option>
                    <option value="diploma">Diploma</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Paper Size</label>
                  <input type="text" name="paper_size" class="form-control" value="A4">
                </div>
                <div class="form-group">
                  <label>Orientation</label>
                  <select name="orientation" class="form-control">
                    <option value="portrait">Portrait</option>
                    <option value="landscape">Landscape</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>HTML Template</label>
                  <textarea name="html_template" class="form-control" rows="8"></textarea>
                </div>
                <div class="form-group">
                  <label>CSS Template</label>
                  <textarea name="css_template" class="form-control" rows="5"></textarea>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('print-templates.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    @endsection
