@extends('admin.layouts.master_layout')

@section('pageTitle', __('app.buildings_rooms') . ' - ' . __('app.app_name'))
@section('content')
  <!-- Buildings & Rooms Card -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-building mr-2"></i>{{ __('app.buildings_rooms') }}</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addBuildingModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }} {{ __('app.building') }}
        </button>
        <button class="btn btn-success btn-sm ml-1" data-toggle="modal" data-target="#addRoomModal">
          <i class="fas fa-plus mr-1"></i>{{ __('app.add') }} {{ __('app.room') }}
        </button>
      </div>
    </div>
    <div class="card-body">
      <ul class="nav nav-tabs" id="roomTabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-rooms">{{ __('app.rooms') }}</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-buildings">{{ __('app.buildings') }}</a></li>
      </ul>
      <div class="tab-content pt-3">
        <div class="tab-pane active" id="tab-rooms">
          <table id="rooms-table" class="table table-bordered table-striped table-hover w-100">
            <thead>
              <tr>
                <th width="50">#</th>
                <th>{{ __('app.building') }}</th>
                <th>{{ __('app.room_no') }}</th>
                <th>{{ __('app.room_type') }}</th>
                <th>{{ __('app.capacity') }}</th>
                <th>{{ __('app.monthly_price') }}</th>
                <th width="90">{{ __('app.status') }}</th>
                <th width="80">{{ __('app.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="tab-pane" id="tab-buildings">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('app.name') }}</th>
                <th>{{ __('app.rooms_count') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($buildings as $i => $b)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ $b->name }}</td>
                  <td>{{ $b->rooms->count() }}</td>
                  <td><span class="badge badge-{{ $b->status === 'active' ? 'success' : 'secondary' }}">{{ __('app.'.$b->status) }}</span></td>
                  <td>
                    <form action="{{ route('rooms.buildings.destroy', $b) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
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

  <!-- Add Building Modal -->
  <div class="modal fade" id="addBuildingModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('rooms.buildings.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.building') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group"><label>{{ __('app.name') }} <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group"><label>{{ __('app.status') }}</label>
              <select name="status" class="form-control tom-select">
                <option value="active">{{ __('app.active') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Add Room Modal -->
  <div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h5 class="modal-title text-white">{{ __('app.add') }} {{ __('app.room') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group"><label>{{ __('app.building') }} <span class="text-danger">*</span></label>
              <select name="building_id" class="form-control tom-select" required>
                <option value="">-- {{ __('app.select') }} --</option>
                @foreach ($buildings as $b)
                  <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.room_no') }} <span class="text-danger">*</span></label>
                  <input type="text" name="room_no" class="form-control" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.room_type') }}</label>
                  <select name="room_type" class="form-control tom-select">
                    <option value="classroom">{{ __('app.classroom') }}</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="shared">Shared</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.capacity') }}</label>
                  <input type="number" name="capacity" class="form-control" value="0" min="0">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group"><label>{{ __('app.monthly_price') }} ($)</label>
                  <input type="number" name="monthly_price" class="form-control" value="0" step="0.01" min="0">
                </div>
              </div>
            </div>
            <div class="form-group"><label>{{ __('app.status') }}</label>
              <select name="status" class="form-control tom-select">
                <option value="available">{{ __('app.available') }}</option>
                <option value="full">{{ __('app.full') }}</option>
                <option value="maintenance">{{ __('app.maintenance') }}</option>
                <option value="inactive">{{ __('app.inactive') }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.cancel') }}</button>
            <button type="submit" class="btn btn-success">{{ __('app.save') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#rooms-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("rooms.index") }}?list=rooms',
        columns: [
          { data: 'DT_RowIndex', orderable: false, searchable: false },
          { data: 'building_name', name: 'building_id', searchable: false },
          { data: 'room_no', name: 'room_no' },
          { data: 'room_type', name: 'room_type' },
          { data: 'capacity', name: 'capacity', className: 'text-center' },
          { data: 'monthly_price', name: 'monthly_price' },
          { data: 'status_badge', name: 'status', searchable: false },
          { data: 'action', orderable: false, searchable: false, className: 'text-center' },
        ],
        language: { url: '/vendor/datatables/i18n/' + (window.APP_LOCALE === 'km' ? 'km' : 'en-GB') + '.json' },
        responsive: true,
        pageLength: 15,
      });
    });
  </script>
@endpush
