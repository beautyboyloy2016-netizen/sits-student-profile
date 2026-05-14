{{-- Reusable role-permissions matrix.
     Required vars:
       $permissions  : Collection<Permission>
       $prefix       : unique prefix for ids (e.g. 'add' or 'edit') --}}
<div class="form-group">
  <label class="font-weight-bold">{{ __('app.permissions') }} <span class="text-danger">*</span></label>
  <div class="table-responsive" style="max-height: 480px; overflow-y: auto; border:1px solid #dee2e6; border-radius: 4px;">
    <table class="table table-bordered table-sm mb-0 perm-matrix" data-prefix="{{ $prefix }}">
      <thead class="thead-light" style="position: sticky; top: 0; z-index: 2;">
        <tr>
          <th style="width: 30%;">{{ __('app.module') ?? 'Group' }}</th>
          <th style="width: 50px; text-align:center;">
            <input type="checkbox" class="perm-check-all" id="{{ $prefix }}_perm_all" title="Select all">
          </th>
          <th>{{ __('app.access') ?? 'Access' }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($permissions->groupBy('module') as $module => $modulePerms)
          <tr>
            <td class="font-weight-bold align-middle text-capitalize">
              {{ str_replace('_', ' ', $module) }}
            </td>
            <td class="text-center align-middle">
              <input type="checkbox" class="perm-check-group" data-module="{{ $module }}"
                id="{{ $prefix }}_grp_{{ $module }}">
            </td>
            <td>
              @foreach ($modulePerms as $perm)
                <div class="form-check form-check-inline mb-1">
                  <input type="checkbox" name="permission_ids[]" value="{{ $perm->id }}"
                    class="form-check-input perm-check-item" data-module="{{ $module }}"
                    id="{{ $prefix }}_p_{{ $perm->id }}">
                  <label class="form-check-label" for="{{ $prefix }}_p_{{ $perm->id }}">
                    {{ $perm->name }}
                  </label>
                </div>
              @endforeach
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
