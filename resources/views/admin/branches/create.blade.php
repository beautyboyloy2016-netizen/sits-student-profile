@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.add_branch') . ' - ' . __('app.app_name'))
@section('pageHeading', __('app.add_branch'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
  <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('app.branches') }}</a></li>
  <li class="breadcrumb-item active">{{ __('app.add_branch') }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-9 col-lg-8">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>{{ __('app.add_branch') }}</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('branches.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>{{ __('app.branch_code') }} <span class="text-danger">*</span></label>
                  <input type="text" name="code" class="form-control text-uppercase" value="{{ old('code') }}"
                    required maxlength="20" placeholder="e.g. MAIN, PP, SR">
                  @error('code')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ឈ្មោះ (ខ្មែរ) <span class="text-danger">*</span></label>
                  <input type="text" name="name_kh" class="form-control" value="{{ old('name_kh') }}" required>
                  @error('name_kh')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ឈ្មោះ (English) <span class="text-danger">*</span></label>
                  <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                  @error('name_en')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>អាសយដ្ឋាន</label>
                  <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>ទូរស័ព្ទ</label>
                  <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>អ៊ីមែល</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>លំដាប់</label>
                  <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}"
                    min="0">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>{{ __('app.status') }} <span class="text-danger">*</span></label>
                  <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                      {{ __('app.active') }}</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                      {{ __('app.inactive') }}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3 d-flex align-items-center">
                <div class="form-group mt-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_main" name="is_main" value="1"
                      {{ old('is_main') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_main">{{ __('app.main_branch') }}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> {{ __('app.save') }}
              </button>
              <a href="{{ route('branches.index') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> {{ __('app.cancel') }}
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
