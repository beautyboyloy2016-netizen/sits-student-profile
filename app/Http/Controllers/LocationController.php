<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Village;
use App\Http\Requests\Location\StoreProvinceRequest;
use App\Http\Requests\Location\UpdateProvinceRequest;
use App\Http\Requests\Location\StoreDistrictRequest;
use App\Http\Requests\Location\UpdateDistrictRequest;
use App\Http\Requests\Location\StoreCommuneRequest;
use App\Http\Requests\Location\UpdateCommuneRequest;
use App\Http\Requests\Location\StoreVillageRequest;
use App\Http\Requests\Location\UpdateVillageRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $provinces = Province::with(['districts.communes.villages'])->orderBy('name_kh')->get();
        return view('admin.locations.index', compact('provinces'));
    }

    public function tree()
    {
        $provinces = Province::with(['districts.communes.villages'])->orderBy('name_kh')->get();
        $data = $provinces->map(function ($p) {
            return [
                'id'       => 'province-' . $p->id,
                'text'     => $p->name_kh . ($p->name_en ? ' (' . $p->name_en . ')' : ''),
                'icon'     => 'fas fa-map text-primary',
                'data'     => ['type' => 'province', 'id' => $p->id, 'delete_url' => route('locations.provinces.destroy', $p)],
                'state'    => ['opened' => false],
                'children' => $p->districts->map(function ($d) use ($p) {
                    return [
                        'id'       => 'district-' . $d->id,
                        'text'     => ($d->type ? $d->type . ' ' : '') . $d->name_kh . ($d->name_en ? ' (' . $d->name_en . ')' : ''),
                        'icon'     => 'fas fa-city text-success',
                        'data'     => ['type' => 'district', 'id' => $d->id, 'delete_url' => route('locations.districts.destroy', $d)],
                        'state'    => ['opened' => false],
                        'children' => $d->communes->map(function ($c) use ($d) {
                            return [
                                'id'       => 'commune-' . $c->id,
                                'text'     => ($c->type ? $c->type . ' ' : '') . $c->name_kh . ($c->name_en ? ' (' . $c->name_en . ')' : ''),
                                'icon'     => 'fas fa-home text-warning',
                                'data'     => ['type' => 'commune', 'id' => $c->id, 'delete_url' => route('locations.communes.destroy', $c)],
                                'state'    => ['opened' => false],
                                'children' => $c->villages->map(function ($v) {
                                    return [
                                        'id'       => 'village-' . $v->id,
                                        'text'     => ($v->type ? $v->type . ' ' : '') . $v->name_kh . ($v->name_en ? ' (' . $v->name_en . ')' : ''),
                                        'icon'     => 'fas fa-house-user text-secondary',
                                        'data'     => ['type' => 'village', 'id' => $v->id, 'delete_url' => route('locations.villages.destroy', $v)],
                                        'children' => false,
                                    ];
                                })->values()->all(),
                            ];
                        })->values()->all(),
                    ];
                })->values()->all(),
            ];
        })->values()->all();

        return response()->json($data);
    }

    public function storeProvince(StoreProvinceRequest $request)
    {
        Province::create($request->validated());
        flash()->success('Province created successfully.');
        return redirect()->route('locations.index');
    }

    public function updateProvince(UpdateProvinceRequest $request, Province $province)
    {
        $province->update($request->validated());
        flash()->success('Province updated successfully.');
        return redirect()->route('locations.index');
    }

    public function destroyProvince(Province $province)
    {
        $province->delete();
        flash()->success('Province deleted successfully.');
        return redirect()->route('locations.index');
    }

    public function storeDistrict(StoreDistrictRequest $request)
    {
        District::create($request->validated());
        flash()->success('District created successfully.');
        return redirect()->route('locations.index');
    }

    public function updateDistrict(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->validated());
        flash()->success('District updated successfully.');
        return redirect()->route('locations.index');
    }

    public function destroyDistrict(District $district)
    {
        $district->delete();
        flash()->success('District deleted successfully.');
        return redirect()->route('locations.index');
    }

    public function storeCommune(StoreCommuneRequest $request)
    {
        $data = $request->validated();
        $district = District::findOrFail($data['district_id']);
        $data['province_id'] = $district->province_id;
        Commune::create($data);
        flash()->success('Commune created successfully.');
        return redirect()->route('locations.index');
    }

    public function updateCommune(UpdateCommuneRequest $request, Commune $commune)
    {
        $data = $request->validated();
        $district = District::findOrFail($data['district_id']);
        $data['province_id'] = $district->province_id;
        $commune->update($data);
        flash()->success('Commune updated successfully.');
        return redirect()->route('locations.index');
    }

    public function destroyCommune(Commune $commune)
    {
        $commune->delete();
        flash()->success('Commune deleted successfully.');
        return redirect()->route('locations.index');
    }

    public function storeVillage(StoreVillageRequest $request)
    {
        $data = $request->validated();
        $commune = Commune::findOrFail($data['commune_id']);
        $data['district_id'] = $commune->district_id;
        $data['province_id'] = $commune->province_id;
        Village::create($data);
        flash()->success('Village created successfully.');
        return redirect()->route('locations.index');
    }

    public function updateVillage(UpdateVillageRequest $request, Village $village)
    {
        $data = $request->validated();
        $commune = Commune::findOrFail($data['commune_id']);
        $data['district_id'] = $commune->district_id;
        $data['province_id'] = $commune->province_id;
        $village->update($data);
        flash()->success('Village updated successfully.');
        return redirect()->route('locations.index');
    }

    public function destroyVillage(Village $village)
    {
        $village->delete();
        flash()->success('Village deleted successfully.');
        return redirect()->route('locations.index');
    }
}
