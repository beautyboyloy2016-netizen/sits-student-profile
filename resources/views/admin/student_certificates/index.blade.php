@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.student_certificates') . ' - ' . __('app.app_name'))

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">{{ __('app.student_certificates') }}: {{ $student->khmer_name }}</h1>
    </div>
    <div class="col-sm-6">
      <a href="{{ route('students.show', $student) }}"
        class="btn btn-secondary float-right">{{ __('app.back_to_student') }}</a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ __('app.create_certificate') }}</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('students.certificates.store', $student) }}" method="POST">
            @csrf
            <div class="form-group">
              <label>{{ __('app.type') }}</label>
              <select name="certificate_type" class="form-control" required>
                <option value="appreciation">{{ __('app.appreciation') }}</option>
                <option value="achievement">{{ __('app.achievement') }}</option>
                <option value="participation">{{ __('app.participation') }}</option>
                <option value="completion">{{ __('app.completion') }}</option>
                <option value="excellent_student">{{ __('app.excellent_student') }}</option>
                <option value="other">{{ __('app.other') }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ __('app.template') }}</label>
              <select name="template_id" class="form-control">
                <option value="">-- {{ __('app.select') }} --</option>
                @foreach ($templates as $t)
                  <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>{{ __('app.title') }}</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
              <label>{{ __('app.description') }}</label>
              <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label>{{ __('app.issue_date') }}</label>
              <input type="text" name="issue_date" class="form-control flatpickr-date">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>{{ __('app.certificate_no') }}</th>
                <th>{{ __('app.type') }}</th>
                <th>{{ __('app.title') }}</th>
                <th>{{ __('app.issue_date') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($student->certificates as $cert)
                <tr>
                  <td>{{ $cert->certificate_no }}</td>
                  <td>{{ __('app.' . $cert->certificate_type) }}</td>
                  <td>{{ $cert->title }}</td>
                  <td>{{ $cert->issue_date }}</td>
                  <td><span
                      class="badge badge-{{ $cert->status === 'approved' ? 'success' : ($cert->status === 'printed' ? 'info' : ($cert->status === 'cancelled' ? 'danger' : 'warning')) }}">{{ __('app.' . $cert->status) }}</span>
                  </td>
                  <td>
                    <a href="{{ route('students.certificates.print', [$student, $cert]) }}" target="_blank"
                      class="btn btn-sm btn-info">
                      <i class="fas fa-print"></i> {{ __('app.print') }}
                    </a>
                    @if ($cert->status === 'draft')
                      <form action="{{ route('students.certificates.approve', [$student, $cert]) }}" method="POST"
                        class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">{{ __('app.approve') }}</button>
                      </form>
                    @endif
                    <form action="{{ route('students.certificates.destroy', [$student, $cert]) }}" method="POST"
                      class="d-inline">
                      @csrf @method('DELETE')
                      <button type="button"
                        class="btn btn-sm btn-danger btn-swal-delete">{{ __('app.delete') }}</button>
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
