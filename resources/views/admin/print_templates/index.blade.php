@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.print_templates') . ' - ' . __('app.app_name'))

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-print mr-2"></i>{{ __('app.print_templates') }}</h3>
      <div class="card-tools">
        <a href="{{ route('print-templates.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add_template') }}
        </a>
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('app.name') }}</th>
            <th>{{ __('app.type') }}</th>
            <th>{{ __('app.paper_size') }}</th>
            <th>{{ __('app.orientation') }}</th>
            <th>{{ __('app.status') }}</th>
            <th>{{ __('app.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($templates as $i => $template)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $template->name }}</td>
              <td>{{ $template->template_type }}</td>
              <td>{{ $template->paper_size }}</td>
              <td>{{ $template->orientation }}</td>
              <td><span
                  class="badge badge-{{ $template->status === 'active' ? 'success' : 'secondary' }}">{{ __('app.' . $template->status) }}</span>
              </td>
              <td>
                <a href="{{ route('print-templates.edit', $template) }}"
                  class="btn btn-sm btn-warning">{{ __('app.edit') }}</a>
                <form action="{{ route('print-templates.destroy', $template) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-sm btn-danger btn-swal-delete">{{ __('app.delete') }}</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
