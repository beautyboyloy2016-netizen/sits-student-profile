@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.student_diplomas') . ' - ' . __('app.app_name'))

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">{{ __('app.student_diplomas') }}: {{ $student->khmer_name }}</h1>
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
          <h3 class="card-title">{{ __('app.create_diploma') }}</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('students.diplomas.store', $student) }}" method="POST">
            @csrf
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
              <label>{{ __('app.graduation_date') }}</label>
              <input type="text" name="graduation_date" class="form-control flatpickr-date">
            </div>
            <div class="form-group">
              <label>{{ __('app.issue_date') }}</label>
              <input type="text" name="issue_date" class="form-control flatpickr-date">
            </div>
            <div class="form-group">
              <label>{{ __('app.grade') }}</label>
              <input type="text" name="grade" class="form-control">
            </div>
            <div class="form-group">
              <label>{{ __('app.gpa') }}</label>
              <input type="number" step="0.01" min="0" max="4" name="gpa" class="form-control">
            </div>
            <div class="form-group">
              <label>{{ __('app.description') }}</label>
              <textarea name="description" class="form-control" rows="3"></textarea>
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
                <th>{{ __('app.diploma_no') }}</th>
                <th>{{ __('app.graduation_date') }}</th>
                <th>{{ __('app.issue_date') }}</th>
                <th>{{ __('app.grade') }}</th>
                <th>{{ __('app.gpa') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($student->diplomas as $dip)
                <tr>
                  <td>{{ $dip->diploma_no }}</td>
                  <td>{{ $dip->graduation_date }}</td>
                  <td>{{ $dip->issue_date }}</td>
                  <td>{{ $dip->grade }}</td>
                  <td>{{ $dip->gpa }}</td>
                  <td><span
                      class="badge badge-{{ $dip->status === 'approved' ? 'success' : ($dip->status === 'printed' ? 'info' : ($dip->status === 'cancelled' ? 'danger' : 'warning')) }}">{{ __('app.' . $dip->status) }}</span>
                  </td>
                  <td>
                    <a href="{{ route('students.diplomas.print', [$student, $dip]) }}" target="_blank"
                      class="btn btn-sm btn-info">
                      <i class="fas fa-print"></i> {{ __('app.print') }}
                    </a>
                    @if ($dip->status === 'draft')
                      <form action="{{ route('students.diplomas.approve', [$student, $dip]) }}" method="POST"
                        class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">{{ __('app.approve') }}</button>
                      </form>
                    @endif
                    <form action="{{ route('students.diplomas.destroy', [$student, $dip]) }}" method="POST"
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
