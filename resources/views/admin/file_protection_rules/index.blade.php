@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.file_protection_rules') . ' - ' . __('app.app_name'))

@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>{{ __('app.add') }}
            {{ __('app.file_protection_rules') }}</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('file-protection-rules.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>{{ __('app.module') }}</label>
              <input type="text" name="module" class="form-control" placeholder="e.g. students, certificates">
            </div>
            <div class="form-group">
              <label>{{ __('app.role') }} ({{ __('app.optional') ?? 'optional' }})</label>
              <select name="role_id" class="form-control">
                <option value="">-- {{ __('app.all_users') }} --</option>
                @foreach ($roles as $r)
                  <option value="{{ $r->id }}">{{ $r->display_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <div class="form-check">
                <input type="checkbox" name="allow_download" value="1" class="form-check-input" id="allow_download">
                <label class="form-check-label" for="allow_download">{{ __('app.allow_download') }}</label>
              </div>
              <div class="form-check">
                <input type="checkbox" name="allow_print" value="1" class="form-check-input" id="allow_print">
                <label class="form-check-label" for="allow_print">{{ __('app.allow_print') }}</label>
              </div>
              <div class="form-check">
                <input type="checkbox" name="allow_export" value="1" class="form-check-input" id="allow_export">
                <label class="form-check-label" for="allow_export">{{ __('app.allow_export') }}</label>
              </div>
              <div class="form-check">
                <input type="checkbox" name="watermark_enabled" value="1" class="form-check-input"
                  id="watermark_enabled" checked>
                <label class="form-check-label" for="watermark_enabled">{{ __('app.watermark_enabled') }}</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-list mr-2"></i>{{ __('app.file_protection_rules') }}</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{{ __('app.name') }}</th>
                <th>{{ __('app.module') }}</th>
                <th>{{ __('app.role') }}</th>
                <th>{{ __('app.download') }}</th>
                <th>{{ __('app.print') }}</th>
                <th>{{ __('app.export') }}</th>
                <th>{{ __('app.watermark') }}</th>
                <th>{{ __('app.actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($rules as $rule)
                <tr>
                  <td>{{ $rule->name }}</td>
                  <td>{{ $rule->module ?? '-' }}</td>
                  <td>{{ $rule->role?->display_name ?? __('app.all_users') }}</td>
                  <td>{!! $rule->allow_download
                      ? '<span class="badge badge-success">' . __('app.yes') . '</span>'
                      : '<span class="badge badge-secondary">' . __('app.no') . '</span>' !!}</td>
                  <td>{!! $rule->allow_print
                      ? '<span class="badge badge-success">' . __('app.yes') . '</span>'
                      : '<span class="badge badge-secondary">' . __('app.no') . '</span>' !!}</td>
                  <td>{!! $rule->allow_export
                      ? '<span class="badge badge-success">' . __('app.yes') . '</span>'
                      : '<span class="badge badge-secondary">' . __('app.no') . '</span>' !!}</td>
                  <td>{!! $rule->watermark_enabled
                      ? '<span class="badge badge-info">' . __('app.on') . '</span>'
                      : '<span class="badge badge-secondary">' . __('app.off') . '</span>' !!}</td>
                  <td>
                    <form action="{{ route('file-protection-rules.destroy', $rule) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger btn-swal-delete"><i
                          class="fas fa-trash"></i></button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center">{{ __('app.no_rules_defined') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
