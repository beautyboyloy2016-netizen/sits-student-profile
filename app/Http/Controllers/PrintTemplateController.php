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
        $templates = PrintTemplate::latest()->get();
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
            'status' => 'required|in:active,inactive',
        ]);

        $validated['settings'] = $request->input('settings', '[]');
        $validated['created_by'] = auth()->id();

        PrintTemplate::create($validated);
        flash()->success('Template created successfully.');
        return redirect()->route('print-templates.index');
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
            'status' => 'required|in:active,inactive',
        ]);

        $validated['settings'] = $request->input('settings', '[]');
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
