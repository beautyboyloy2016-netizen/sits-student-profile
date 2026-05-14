<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Address;
use App\Http\Requests\Guardian\StoreGuardianRequest;
use App\Http\Requests\Guardian\UpdateGuardianRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GuardianController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Guardian::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit   = '<a href="'.route('guardians.edit', $row->id).'" class="btn btn-xs btn-warning mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="'.route('guardians.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $guardians = Guardian::with(['address.province', 'address.district', 'address.commune'])
            ->latest()
            ->get();

        return view('admin.guardians.index', compact('guardians'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->orderBy('khmer_name')->get();
        $provinces = Province::orderBy('name_kh')->get();

        return view('admin.guardians.create', compact('students', 'provinces'));
    }

    public function store(StoreGuardianRequest $request)
    {
        $validated = $request->validate([
            'name_kh' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:255',
            'province_id' => 'nullable|exists:provinces,id',
            'district_id' => 'nullable|exists:districts,id',
            'commune_id' => 'nullable|exists:communes,id',
            'village_id' => 'nullable|exists:villages,id',
            'street' => 'nullable|string|max:255',
            'house_no' => 'nullable|string|max:50',
            'note' => 'nullable|string',
            'student_id' => 'nullable|exists:students,id',
            'relationship' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();

        try {
            $addressId = null;
            if ($request->filled('province_id')) {
                $address = Address::create([
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'commune_id' => $request->commune_id,
                    'village_id' => $request->village_id,
                    'street' => $request->street,
                    'house_no' => $request->house_no,
                ]);
                $addressId = $address->id;
            }

            $guardian = Guardian::create([
                'name_kh' => $validated['name_kh'],
                'name_en' => $validated['name_en'],
                'phone' => $validated['phone'],
                'occupation' => $validated['occupation'],
                'address_id' => $addressId,
                'note' => $validated['note'] ?? null,
            ]);

            if ($request->filled('student_id')) {
                $guardian->students()->attach($request->student_id, [
                    'relationship' => $request->relationship ?? 'parent',
                    'is_primary' => true,
                ]);
            }

            DB::commit();

            flash()->success('Guardian created successfully.');
            return redirect()->route('guardians.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to create guardian.');
            return back()->withInput();
        }
    }

    public function edit(Guardian $guardian)
    {
        $guardian->load(['address', 'students']);
        $provinces = Province::orderBy('name_kh')->get();
        $districts = $guardian->address ? District::where('province_id', $guardian->address->province_id)->get() : collect();
        $communes = $guardian->address ? Commune::where('district_id', $guardian->address->district_id)->get() : collect();
        $students = Student::where('status', 'active')->orderBy('khmer_name')->get();

        return view('admin.guardians.edit', compact('guardian', 'provinces', 'districts', 'communes', 'students'));
    }

    public function update(UpdateGuardianRequest $request, Guardian $guardian)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Update or create address
            $addressId = $guardian->address_id;
            if ($request->filled('province_id')) {
                $addressData = [
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'commune_id'  => $request->commune_id,
                    'village_id'  => $request->village_id,
                    'street'      => $request->street,
                    'house_no'    => $request->house_no,
                ];
                if ($guardian->address) {
                    $guardian->address->update($addressData);
                    $addressId = $guardian->address->id;
                } else {
                    $address = Address::create($addressData);
                    $addressId = $address->id;
                }
            }

            $guardian->update([
                'name_kh'    => $validated['name_kh'],
                'name_en'    => $validated['name_en'] ?? null,
                'phone'      => $validated['phone'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
                'address_id' => $addressId,
                'note'       => $validated['note'] ?? null,
            ]);

            // Sync student link (single primary)
            if ($request->filled('student_id')) {
                $guardian->students()->syncWithoutDetaching([
                    $request->student_id => [
                        'relationship' => $request->relationship ?? 'parent',
                        'is_primary'   => true,
                    ],
                ]);
            }

            DB::commit();
            flash()->success('Guardian updated successfully.');
            return redirect()->route('guardians.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to update guardian: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        flash()->success('Guardian deleted successfully.');
        return redirect()->route('guardians.index');
    }
}
