<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Http\Requests\Room\StoreBuildingRequest;
use App\Http\Requests\Room\UpdateBuildingRequest;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() && $request->input('list') === 'rooms') {
            $data = Room::with('building')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('building_name', fn($r) => $r->building?->name ?? '-')
                ->addColumn('status_badge', fn($r) => '<span class="badge badge-'.($r->status==='available'?'success':($r->status==='full'?'warning':'secondary')).'">'.__('app.'.$r->status).'</span>')
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-room mr-1"
                        data-id="'.$row->id.'" data-name="'.e($row->name).'"
                        data-building_id="'.$row->building_id.'" data-capacity="'.$row->capacity.'"
                        data-status="'.$row->status.'"
                        ><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="'.route('rooms.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $buildings = Building::with(['rooms', 'address'])->latest()->get();
        $rooms = Room::with('building')->latest()->get();

        return view('admin.rooms.index', compact('buildings', 'rooms'));
    }

    public function storeBuilding(StoreBuildingRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_id' => 'nullable|exists:addresses,id',
            'status' => 'required|in:active,inactive',
        ]);

        $building = Building::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Building created successfully.', 'building' => $building]);
        }

        flash()->success('Building created successfully.');
        return redirect()->route('rooms.index');
    }

    public function updateBuilding(UpdateBuildingRequest $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_id' => 'nullable|exists:addresses,id',
            'status' => 'required|in:active,inactive',
        ]);

        $building->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Building updated successfully.', 'building' => $building]);
        }

        flash()->success('Building updated successfully.');
        return redirect()->route('rooms.index');
    }

    public function destroyBuilding(Building $building)
    {
        try {
            $building->delete();
            flash()->success('Building deleted successfully.');
        } catch (\Exception $e) {
            flash()->error('Cannot delete building with existing rooms.');
        }

        return redirect()->route('rooms.index');
    }

    public function storeRoom(StoreRoomRequest $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_no' => 'required|string|max:50',
            'room_type' => 'required|in:single,double,shared,classroom',
            'capacity' => 'required|integer|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,full,maintenance,inactive',
        ]);

        $room = Room::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Room created successfully.', 'room' => $room]);
        }

        flash()->success('Room created successfully.');
        return redirect()->route('rooms.index');
    }

    public function updateRoom(UpdateRoomRequest $request, Room $room)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_no' => 'required|string|max:50',
            'room_type' => 'required|in:single,double,shared,classroom',
            'capacity' => 'required|integer|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,full,maintenance,inactive',
        ]);

        $room->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Room updated successfully.', 'room' => $room]);
        }

        flash()->success('Room updated successfully.');
        return redirect()->route('rooms.index');
    }

    public function destroyRoom(Room $room)
    {
        try {
            $room->delete();
            flash()->success('Room deleted successfully.');
        } catch (\Exception $e) {
            flash()->error('Cannot delete room with existing assignments.');
        }

        return redirect()->route('rooms.index');
    }
}
