<?php

namespace App\Http\Controllers;

use App\Models\ReportTemplate;
use App\Models\TemplateCategory;
use App\Services\ReportTemplateService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReportTemplateController extends Controller
{
    protected ReportTemplateService $templateService;

    public function __construct(ReportTemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    /**
     * Display a listing of the templates.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->get('category');
        $categories = $this->templateService->getTemplateCategories();
        $templates = $this->templateService->getAccessibleTemplates($categoryId);

        return view('reports.templates.index', compact('categories', 'templates', 'categoryId'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create(Request $request): View
    {
        $categories = $this->templateService->getTemplateCategories();
        $reportType = $request->get('type', 'transactions');
        $predefinedFields = $this->templateService->getPredefinedFields($reportType);

        return view('reports.templates.create', compact('categories', 'reportType', 'predefinedFields'));
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'template_category_id' => 'nullable|exists:template_categories,id',
            'report_type' => 'required|in:transactions,budgets,tickets,custom',
            'group_by_config' => 'nullable|array',
            'summary_by_config' => 'nullable|array',
            'filters_config' => 'nullable|array',
            'chart_config' => 'nullable|array',
            'formatting_config' => 'nullable|array',
            'is_public' => 'boolean',
            'fields' => 'nullable|array',
            'fields.*.field_name' => 'required|string',
            'fields.*.field_label' => 'required|string',
            'fields.*.field_type' => 'required|string',
            'fields.*.data_type' => 'required|string',
        ]);

        try {
            $template = $this->templateService->createTemplate($request->all());
            
            return redirect()
                ->route('report-templates.show', $template)
                ->with('success', 'Template created successfully.');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create template: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified template.
     */
    public function show(ReportTemplate $reportTemplate): View
    {
        $reportTemplate->load(['templateFields', 'templateCategory', 'user']);
        
        return view('reports.templates.show', compact('reportTemplate'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(ReportTemplate $reportTemplate): View
    {
        if (!$reportTemplate->canBeEditedBy(Auth::user())) {
            abort(403, 'You do not have permission to edit this template.');
        }

        $categories = $this->templateService->getTemplateCategories();
        $reportTemplate->load(['templateFields', 'templateCategory']);

        return view('reports.templates.edit', compact('reportTemplate', 'categories'));
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, ReportTemplate $reportTemplate): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'template_category_id' => 'nullable|exists:template_categories,id',
            'group_by_config' => 'nullable|array',
            'summary_by_config' => 'nullable|array',
            'filters_config' => 'nullable|array',
            'chart_config' => 'nullable|array',
            'formatting_config' => 'nullable|array',
            'is_public' => 'boolean',
            'fields' => 'nullable|array',
            'fields.*.field_name' => 'required|string',
            'fields.*.field_label' => 'required|string',
            'fields.*.field_type' => 'required|string',
            'fields.*.data_type' => 'required|string',
        ]);

        try {
            $template = $this->templateService->updateTemplate($reportTemplate, $request->all());
            
            return redirect()
                ->route('report-templates.show', $template)
                ->with('success', 'Template updated successfully.');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update template: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(ReportTemplate $reportTemplate): RedirectResponse
    {
        try {
            $this->templateService->deleteTemplate($reportTemplate);
            
            return redirect()
                ->route('report-templates.index')
                ->with('success', 'Template deleted successfully.');
                
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to delete template: ' . $e->getMessage()]);
        }
    }

    /**
     * Clone an existing template.
     */
    public function clone(Request $request, ReportTemplate $reportTemplate): RedirectResponse
    {
        $request->validate([
            'new_name' => 'required|string|max:255'
        ]);

        try {
            $clonedTemplate = $this->templateService->cloneTemplate(
                $reportTemplate, 
                $request->new_name
            );
            
            return redirect()
                ->route('report-templates.edit', $clonedTemplate)
                ->with('success', 'Template cloned successfully. You can now customize it.');
                
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to clone template: ' . $e->getMessage()]);
        }
    }

    /**
     * Get predefined fields for a report type (AJAX endpoint).
     */
    public function getPredefinedFields(Request $request)
    {
        $reportType = $request->get('report_type');
        
        if (!$reportType) {
            return response()->json(['error' => 'Report type is required'], 400);
        }

        $fields = $this->templateService->getPredefinedFields($reportType);
        
        return response()->json(['fields' => $fields]);
    }

    /**
     * Preview template with sample data.
     */
    public function preview(Request $request, ReportTemplate $reportTemplate): View
    {
        $reportTemplate->load(['templateFields', 'templateCategory']);
        
        // This would generate sample data based on the template configuration
        // For now, we'll just show the template structure
        
        return view('reports.templates.preview', compact('reportTemplate'));
    }
}
