@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.branch_settings') . ' - ' . __('app.app_name'))
@section('pageHeading', __('app.branch_settings'))

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
  <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('app.branches') }}</a></li>
  <li class="breadcrumb-item active">{{ $branch->name_kh }} — {{ __('app.settings') }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header d-flex align-items-center">
          <h3 class="card-title">
            <i class="fas fa-cog mr-2"></i>
            {{ __('app.branch_settings') }}: <strong>{{ $branch->name_kh }} ({{ $branch->code }})</strong>
          </h3>
        </div>

        <form action="{{ route('branch-settings.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="card-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            {{-- School Names --}}
            <h5 class="border-bottom pb-2 mb-3 text-primary"><i class="fas fa-school mr-1"></i> ព័ត៌មានសាលា</h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>ឈ្មោះសាលា (ខ្មែរ)</label>
                  <input type="text" name="school_name_kh"
                    class="form-control @error('school_name_kh') is-invalid @enderror"
                    value="{{ old('school_name_kh', $setting->school_name_kh) }}">
                  @error('school_name_kh')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>School Name (English)</label>
                  <input type="text" name="school_name_en"
                    class="form-control @error('school_name_en') is-invalid @enderror"
                    value="{{ old('school_name_en', $setting->school_name_en) }}">
                  @error('school_name_en')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>

            {{-- Ministry & Contact --}}
            <h5 class="border-bottom pb-2 mb-3 text-primary"><i class="fas fa-id-card mr-1"></i> ការចុះបញ្ជី & ទំនាក់ទំនង
            </h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>លេខចុះបញ្ជីក្រសួង</label>
                  <input type="text" name="ministry_registration_no" class="form-control"
                    value="{{ old('ministry_registration_no', $setting->ministry_registration_no) }}"
                    placeholder="MoEYS-XXXX-XXXX">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>អាសយដ្ឋាន</label>
                  <input type="text" name="address" class="form-control"
                    value="{{ old('address', $setting->address) }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ទូរស័ព្ទ</label>
                  <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone) }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>អ៊ីម៉ែល</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>គេហទំព័រ</label>
                  <input type="url" name="website" class="form-control"
                    value="{{ old('website', $setting->website) }}" placeholder="https://">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Facebook Page</label>
                  <input type="text" name="facebook_page" class="form-control"
                    value="{{ old('facebook_page', $setting->facebook_page) }}">
                </div>
              </div>
            </div>

            {{-- Documents & Images --}}
            <h5 class="border-bottom pb-2 mb-3 text-primary"><i class="fas fa-image mr-1"></i> រូបភាព / ត្រា / ហត្ថលេខា
            </h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Logo</label>
                  @if ($setting->school_logo_path)
                    <div class="mb-1">
                      <img src="{{ asset('storage/' . $setting->school_logo_path) }}" alt="Logo" height="60"
                        class="border rounded">
                    </div>
                  @endif
                  <input type="file" name="school_logo_path"
                    class="form-control-file @error('school_logo_path') is-invalid @enderror" accept="image/*">
                  @error('school_logo_path')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ត្រាសាលា</label>
                  @if ($setting->school_stamp_path)
                    <div class="mb-1">
                      <img src="{{ asset('storage/' . $setting->school_stamp_path) }}" alt="Stamp" height="60"
                        class="border rounded">
                    </div>
                  @endif
                  <input type="file" name="school_stamp_path"
                    class="form-control-file @error('school_stamp_path') is-invalid @enderror" accept="image/*">
                  @error('school_stamp_path')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>ហត្ថលេខា</label>
                  @if ($setting->school_signature_path)
                    <div class="mb-1">
                      <img src="{{ asset('storage/' . $setting->school_signature_path) }}" alt="Signature"
                        height="60" class="border rounded">
                    </div>
                  @endif
                  <input type="file" name="school_signature_path"
                    class="form-control-file @error('school_signature_path') is-invalid @enderror" accept="image/*">
                  @error('school_signature_path')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer text-right">
            <a href="{{ route('branches.index') }}" class="btn btn-secondary mr-2">
              <i class="fas fa-times mr-1"></i>{{ __('app.cancel') }}
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-1"></i>{{ __('app.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
