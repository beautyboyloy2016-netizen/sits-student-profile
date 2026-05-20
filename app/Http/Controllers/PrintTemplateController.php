<?php

namespace App\Http\Controllers;

use App\Models\PrintTemplate;
use App\Http\Requests\PrintTemplate\StorePrintTemplateRequest;
use App\Http\Requests\PrintTemplate\UpdatePrintTemplateRequest;
use Illuminate\Http\Request;

class PrintTemplateController extends Controller
{
    public function index()
    {
        $query = PrintTemplate::query();
        $branchId = current_branch_id();
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->orWhereNull('branch_id');
            });
        }
        $templates = $query->latest()->get();
        return view('admin.print_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.print_templates.create');
    }

    public function store(StorePrintTemplateRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_type' => 'required|in:student_card,certificate,diploma',
            'paper_size' => 'nullable|string|max:50',
            'orientation' => 'required|in:portrait,landscape',
            'html_template' => 'nullable|string',
            'css_template' => 'nullable|string',
            'is_default' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $branchId = current_branch_id();
        $isDefault = $request->boolean('is_default', false);

        // If marked as default, unset other defaults for this branch + type
        if ($isDefault) {
            PrintTemplate::where('template_type', $validated['template_type'])
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->update(['is_default' => false]);
        }

        $settings = $request->input('settings');
        if (is_string($settings)) {
            $decoded = json_decode($settings, true);
            $settings = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
        }

        $validated['branch_id'] = $branchId;
        $validated['is_default'] = $isDefault;
        $validated['settings'] = $settings ?: [];
        $validated['created_by'] = auth()->id();

        PrintTemplate::create($validated);
        flash()->success('Template created successfully.');
        return redirect()->route('print-templates.index');
    }

    public function show(PrintTemplate $printTemplate)
    {
        return view('admin.print_templates.show', compact('printTemplate'));
    }

    public function edit(PrintTemplate $printTemplate)
    {
        return view('admin.print_templates.edit', compact('printTemplate'));
    }

    public function update(UpdatePrintTemplateRequest $request, PrintTemplate $printTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_type' => 'required|in:student_card,certificate,diploma',
            'paper_size' => 'nullable|string|max:50',
            'orientation' => 'required|in:portrait,landscape',
            'html_template' => 'nullable|string',
            'css_template' => 'nullable|string',
            'is_default' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $branchId = $printTemplate->branch_id ?? current_branch_id();
        $isDefault = $request->boolean('is_default', false);

        if ($isDefault) {
            PrintTemplate::where('template_type', $validated['template_type'])
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->where('id', '!=', $printTemplate->id)
                ->update(['is_default' => false]);
        }

        $settings = $request->input('settings');
        if (is_string($settings)) {
            $decoded = json_decode($settings, true);
            $settings = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
        }

        $validated['is_default'] = $isDefault;
        $validated['settings'] = $settings ?: [];
        $validated['updated_by'] = auth()->id();

        $printTemplate->update($validated);
        flash()->success('Template updated successfully.');
        return redirect()->route('print-templates.index');
    }

    public function destroy(PrintTemplate $printTemplate)
    {
        $printTemplate->delete();
        flash()->success('Template deleted successfully.');
        return redirect()->route('print-templates.index');
    }
}
