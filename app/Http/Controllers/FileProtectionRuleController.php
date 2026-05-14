<?php

namespace App\Http\Controllers;

use App\Models\FileProtectionRule;
use App\Models\Role;
use App\Http\Requests\FileProtectionRule\StoreFileProtectionRuleRequest;
use App\Http\Requests\FileProtectionRule\UpdateFileProtectionRuleRequest;
use Illuminate\Http\Request;

class FileProtectionRuleController extends Controller
{
    public function index()
    {
        $rules = FileProtectionRule::with('role')->latest()->get();
        $roles = Role::all();
        return view('admin.file_protection_rules.index', compact('rules', 'roles'));
    }

    public function store(StoreFileProtectionRuleRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'nullable|string|max:255',
            'role_id' => 'nullable|exists:roles,id',
            'allow_download' => 'boolean',
            'allow_print' => 'boolean',
            'allow_export' => 'boolean',
            'watermark_enabled' => 'boolean',
        ]);

        $validated['allow_download'] = $request->boolean('allow_download');
        $validated['allow_print'] = $request->boolean('allow_print');
        $validated['allow_export'] = $request->boolean('allow_export');
        $validated['watermark_enabled'] = $request->boolean('watermark_enabled', true);

        FileProtectionRule::create($validated);
        flash()->success('Rule created successfully.');
        return redirect()->route('file-protection-rules.index');
    }

    public function update(UpdateFileProtectionRuleRequest $request, FileProtectionRule $rule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'nullable|string|max:255',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $validated['allow_download'] = $request->boolean('allow_download');
        $validated['allow_print'] = $request->boolean('allow_print');
        $validated['allow_export'] = $request->boolean('allow_export');
        $validated['watermark_enabled'] = $request->boolean('watermark_enabled');

        $rule->update($validated);
        flash()->success('Rule updated successfully.');
        return redirect()->route('file-protection-rules.index');
    }

    public function destroy(FileProtectionRule $rule)
    {
        $rule->delete();
        flash()->success('Rule deleted successfully.');
        return redirect()->route('file-protection-rules.index');
    }
}
