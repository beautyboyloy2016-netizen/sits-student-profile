<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Http\Requests\Gender\StoreGenderRequest;
use App\Http\Requests\Gender\UpdateGenderRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gender::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-xs btn-info btn-edit-gender mr-1"
                        data-id="'.$row->id.'"
                        data-name_kh="'.e($row->name_kh).'"
                        data-name_en="'.e($row->name_en).'"
                        data-sort_order="'.$row->sort_order.'"
                        ><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="'.route('genders.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.genders.index');
    }

    public function store(StoreGenderRequest $request)
    {
        $validated = $request->validate([
            'name_kh' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Gender::create($validated);
        flash()->success('Gender created successfully.');
        return redirect()->route('genders.index');
    }

    public function update(UpdateGenderRequest $request, Gender $gender)
    {
        $validated = $request->validate([
            'name_kh' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $gender->update($validated);
        flash()->success('Gender updated successfully.');
        return redirect()->route('genders.index');
    }

    public function destroy(Gender $gender)
    {
        $gender->delete();
        flash()->success('Gender deleted successfully.');
        return redirect()->route('genders.index');
    }
}
