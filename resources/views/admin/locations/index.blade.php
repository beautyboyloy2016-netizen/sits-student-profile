@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.locations') . ' - ' . __('app.app_name'))

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.17/themes/default/style.min.css" />
<style>
  #location-tree { min-height: 400px; }
  #location-tree .jstree-node { padding: 2px 0; }
  .tree-search-wrap { margin-bottom: 10px; }
  .node-detail-panel { border-left: 3px solid #007bff; padding: 10px 15px; background: #f8f9fa; border-radius: 4px; min-height: 60px; }
</style>
@endpush

@section('content')
<div class="row">
  {{-- Left: jsTree --}}
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-map-marked-alt mr-2"></i>{{ __('app.locations') }}</h3>
        <div class="card-tools">
          <button id="btn-expand-all" class="btn btn-xs btn-default" title="{{ __('app.expand_all') ?? 'Expand All' }}">
            <i class="fas fa-expand-alt"></i>
          </button>
          <button id="btn-collapse-all" class="btn btn-xs btn-default ml-1" title="{{ __('app.collapse_all') ?? 'Collapse All' }}">
            <i class="fas fa-compress-alt"></i>
          </button>
          <button id="btn-reload-tree" class="btn btn-xs btn-info ml-1" title="Reload">
            <i class="fas fa-sync-alt"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="tree-search-wrap">
          <input type="text" id="tree-search" class="form-control form-control-sm" placeholder="{{ __('app.search') }}...">
        </div>
        <div id="location-tree"></div>
        <div id="node-detail" class="node-detail-panel mt-3 d-none">
          <span id="node-detail-text" class="font-weight-bold"></span>
          <form id="node-delete-form" method="POST" class="d-inline ml-3">
            @csrf @method('DELETE')
            <button type="button" id="btn-node-delete" class="btn btn-xs btn-danger">
              <i class="fas fa-trash mr-1"></i>{{ __('app.delete') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Right: Add forms --}}
  <div class="col-md-5">
    {{-- Province --}}
    <div class="card card-primary card-outline">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>{{ __('app.add') }} {{ __('app.province') }}</h3></div>
      <div class="card-body p-2">
        <form action="{{ route('locations.provinces.store') }}" method="POST">
          @csrf
          <div class="form-row">
            <div class="col-4"><input type="text" name="code" class="form-control form-control-sm" placeholder="{{ __('app.code') }}"></div>
            <div class="col"><input type="text" name="name_kh" class="form-control form-control-sm" placeholder="{{ __('app.name_kh') }} *" required></div>
            <div class="col"><input type="text" name="name_en" class="form-control form-control-sm" placeholder="{{ __('app.name_en') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i></button></div>
          </div>
        </form>
      </div>
    </div>

    {{-- District --}}
    <div class="card card-success card-outline">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>{{ __('app.add') }} {{ __('app.district') }}</h3></div>
      <div class="card-body p-2">
        <form action="{{ route('locations.districts.store') }}" method="POST">
          @csrf
          <div class="form-group mb-1">
            <select name="province_id" class="form-control form-control-sm tom-select" required>
              <option value="">-- {{ __('app.province') }} --</option>
              @foreach($provinces as $p)
              <option value="{{ $p->id }}">{{ $p->name_kh }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-row">
            <div class="col-3"><input type="text" name="type" class="form-control form-control-sm" placeholder="{{ __('app.type') }}"></div>
            <div class="col-2"><input type="text" name="code" class="form-control form-control-sm" placeholder="{{ __('app.code') }}"></div>
            <div class="col"><input type="text" name="name_kh" class="form-control form-control-sm" placeholder="{{ __('app.name_kh') }} *" required></div>
            <div class="col"><input type="text" name="name_en" class="form-control form-control-sm" placeholder="{{ __('app.name_en') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i></button></div>
          </div>
        </form>
      </div>
    </div>

    {{-- Commune --}}
    <div class="card card-warning card-outline">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>{{ __('app.add') }} {{ __('app.commune') }}</h3></div>
      <div class="card-body p-2">
        <form action="{{ route('locations.communes.store') }}" method="POST">
          @csrf
          <div class="form-group mb-1">
            <select name="district_id" class="form-control form-control-sm tom-select" required>
              <option value="">-- {{ __('app.district') }} --</option>
              @foreach($provinces as $p)
                @foreach($p->districts as $d)
                <option value="{{ $d->id }}">{{ $p->name_kh }} › {{ $d->name_kh }}</option>
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="form-row">
            <div class="col-3"><input type="text" name="type" class="form-control form-control-sm" placeholder="{{ __('app.type') }}"></div>
            <div class="col-2"><input type="text" name="code" class="form-control form-control-sm" placeholder="{{ __('app.code') }}"></div>
            <div class="col"><input type="text" name="name_kh" class="form-control form-control-sm" placeholder="{{ __('app.name_kh') }} *" required></div>
            <div class="col"><input type="text" name="name_en" class="form-control form-control-sm" placeholder="{{ __('app.name_en') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save"></i></button></div>
          </div>
        </form>
      </div>
    </div>

    {{-- Village --}}
    <div class="card card-secondary card-outline">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>{{ __('app.add') }} {{ __('app.village') }}</h3></div>
      <div class="card-body p-2">
        <form action="{{ route('locations.villages.store') }}" method="POST">
          @csrf
          <div class="form-group mb-1">
            <select name="commune_id" class="form-control form-control-sm tom-select" required>
              <option value="">-- {{ __('app.commune') }} --</option>
              @foreach($provinces as $p)
                @foreach($p->districts as $d)
                  @foreach($d->communes as $c)
                  <option value="{{ $c->id }}">{{ $p->name_kh }} › {{ $d->name_kh }} › {{ $c->name_kh }}</option>
                  @endforeach
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="form-row">
            <div class="col-3"><input type="text" name="type" class="form-control form-control-sm" placeholder="{{ __('app.type') }}"></div>
            <div class="col-2"><input type="text" name="code" class="form-control form-control-sm" placeholder="{{ __('app.code') }}"></div>
            <div class="col"><input type="text" name="name_kh" class="form-control form-control-sm" placeholder="{{ __('app.name_kh') }} *" required></div>
            <div class="col"><input type="text" name="name_en" class="form-control form-control-sm" placeholder="{{ __('app.name_en') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i></button></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.17/jstree.min.js"></script>
<script>
$(function () {
    var treeUrl = '{{ route("locations.tree") }}';

    $('#location-tree').jstree({
        core: {
            data: {
                url: treeUrl,
                dataType: 'json'
            },
            themes: { responsive: true },
            check_callback: false,
        },
        plugins: ['search', 'wholerow', 'types'],
        search: {
            show_only_matches: true,
            show_only_matches_children: true,
        },
        types: {
            default: { icon: 'fas fa-folder text-warning' }
        }
    });

    // Search
    var searchTimeout;
    $('#tree-search').on('keyup', function () {
        clearTimeout(searchTimeout);
        var q = $(this).val();
        searchTimeout = setTimeout(function () {
            $('#location-tree').jstree('search', q);
        }, 300);
    });

    // Expand / collapse all
    $('#btn-expand-all').on('click', function () { $('#location-tree').jstree('open_all'); });
    $('#btn-collapse-all').on('click', function () { $('#location-tree').jstree('close_all'); });
    $('#btn-reload-tree').on('click', function () {
        $('#location-tree').jstree(true).refresh();
        $('#node-detail').addClass('d-none');
    });

    // Node selected → show detail + delete button
    $('#location-tree').on('select_node.jstree', function (e, data) {
        var node = data.node;
        var nodeData = node.data;
        if (!nodeData || !nodeData.delete_url) return;

        $('#node-detail-text').text(node.text);
        $('#node-delete-form').attr('action', nodeData.delete_url);
        $('#node-detail').removeClass('d-none');
    });

    // Delete button
    $('#btn-node-delete').on('click', function () {
        if (!confirm('{{ __("app.confirm_delete") ?? "Are you sure you want to delete this item and all its children?" }}')) return;
        $('#node-delete-form').submit();
    });
});
</script>
@endpush
