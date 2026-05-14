@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.student_cards') . ' - ' . __('app.app_name'))

@section('content')
  <div class="row mb-3">
    <div class="col-sm-6">
      <h1 class="m-0">{{ __('app.student_cards') }}: {{ $student->khmer_name }}</h1>
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
          <h3 class="card-title">{{ __('app.create_card') }}</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('students.cards.store', $student) }}" method="POST">
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
              <label>{{ __('app.issue_date') }}</label>
              <input type="text" name="issue_date" class="form-control flatpickr-date">
            </div>
            <div class="form-group">
              <label>{{ __('app.expire_date') }}</label>
              <input type="text" name="expire_date" class="form-control flatpickr-date">
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
                <th>{{ __('app.card_no') }}</th>
                <th>{{ __('app.template') }}</th>
                <th>{{ __('app.issue_date') }}</th>
                <th>{{ __('app.expire_date') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($student->cards as $card)
                <tr>
                  <td>{{ $card->card_no }}</td>
                  <td>{{ $card->template?->name ?? __('app.default') }}</td>
                  <td>{{ $card->issue_date }}</td>
                  <td>{{ $card->expire_date }}</td>
                  <td><span
                      class="badge badge-{{ $card->status === 'active' ? 'success' : 'secondary' }}">{{ __('app.' . $card->status) }}</span>
                  </td>
                  <td>
                    <a href="{{ route('students.cards.print', [$student, $card]) }}" target="_blank"
                      class="btn btn-sm btn-info">
                      <i class="fas fa-print"></i> {{ __('app.print') }}
                    </a>
                    <form action="{{ route('students.cards.destroy', [$student, $card]) }}" method="POST"
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
