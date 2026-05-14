@extends('admin.layouts.master_layout')

@section('title', 'Edit Print Template')

@section('content')
<div class="row mb-3"><div class="col-sm-6"><h1 class="m-0">Edit Print Template</h1></div>
</div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('print-templates.update', $printTemplate) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" value="{{ $printTemplate->name }}" required>
                </div>
                <div class="form-group">
                  <label>Template Type</label>
                  <select name="template_type" class="form-control" required>
                    <option value="student_card" {{ $printTemplate->template_type === 'student_card' ? 'selected' : '' }}>Student Card</option>
                    <option value="certificate" {{ $printTemplate->template_type === 'certificate' ? 'selected' : '' }}>Certificate</option>
                    <option value="diploma" {{ $printTemplate->template_type === 'diploma' ? 'selected' : '' }}>Diploma</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Paper Size</label>
                  <input type="text" name="paper_size" class="form-control" value="{{ $printTemplate->paper_size }}">
                </div>
                <div class="form-group">
                  <label>Orientation</label>
                  <select name="orientation" class="form-control">
                    <option value="portrait" {{ $printTemplate->orientation === 'portrait' ? 'selected' : '' }}>Portrait</option>
                    <option value="landscape" {{ $printTemplate->orientation === 'landscape' ? 'selected' : '' }}>Landscape</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="active" {{ $printTemplate->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $printTemplate->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>HTML Template</label>
                  <textarea name="html_template" class="form-control" rows="8">{{ $printTemplate->html_template }}</textarea>
                </div>
                <div class="form-group">
                  <label>CSS Template</label>
                  <textarea name="css_template" class="form-control" rows="5">{{ $printTemplate->css_template }}</textarea>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('print-templates.index') }}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    @endsection
