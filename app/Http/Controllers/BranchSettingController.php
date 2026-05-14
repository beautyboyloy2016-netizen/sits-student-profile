<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchSetting;
use Illuminate\Http\Request;

class BranchSettingController extends Controller
{
    /**
     * Show the settings form for a given branch.
     */
    public function edit(Branch $branch)
    {
        $setting = BranchSetting::firstOrNew(['branch_id' => $branch->id]);
        return view('admin.branch_settings.edit', compact('branch', 'setting'));
    }

    /**
     * Save (create or update) branch settings.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'school_name_kh'          => 'nullable|string|max:255',
            'school_name_en'          => 'nullable|string|max:255',
            'school_logo_path'        => 'nullable|image|max:2048',
            'school_stamp_path'       => 'nullable|image|max:2048',
            'school_signature_path'   => 'nullable|image|max:2048',
            'address'                 => 'nullable|string|max:500',
            'phone'                   => 'nullable|string|max:30',
            'email'                   => 'nullable|email|max:255',
            'website'                 => 'nullable|url|max:255',
            'ministry_registration_no'=> 'nullable|string|max:100',
            'facebook_page'           => 'nullable|string|max:255',
        ]);

        $setting = BranchSetting::firstOrNew(['branch_id' => $branch->id]);
        $setting->branch_id = $branch->id;

        // Handle file uploads
        foreach (['school_logo_path', 'school_stamp_path', 'school_signature_path'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store("branch/{$branch->id}", 'public');
                $setting->{$fileField} = $path;
            }
        }

        // Fill non-file fields
        $setting->fill(collect($validated)->except(['school_logo_path', 'school_stamp_path', 'school_signature_path'])->toArray());
        $setting->save();

        flash()->success(__('app.saved_successfully'));
        return redirect()->route('branch-settings.edit', $branch->id);
    }
}
