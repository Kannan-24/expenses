<?php

namespace App\Services;

use App\Models\ReportTemplate;
use App\Models\TemplateCategory;
use App\Models\TemplateField;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportTemplateService
{
    /**
     * Get all template categories with active templates count.
     */
    public function getTemplateCategories(): Collection
    {
        return TemplateCategory::active()
            ->withCount(['activeReportTemplates'])
            ->ordered()
            ->get();
    }

    /**
     * Get templates accessible by the current user.
     */
    public function getAccessibleTemplates($categoryId = null): Collection
    {
        $query = ReportTemplate::with(['templateCategory', 'user'])
            ->accessibleByUser(Auth::id())
            ->active();

        if ($categoryId) {
            $query->where('template_category_id', $categoryId);
        }

        return $query->orderBy('usage_count', 'desc')
            ->orderBy('name')
            ->get();
    }

    /**
     * Create a new report template.
     */
    public function createTemplate(array $data): ReportTemplate
    {
        DB::beginTransaction();
        
        try {
            $template = ReportTemplate::create([
                'user_id' => Auth::id(),
                'template_category_id' => $data['template_category_id'] ?? null,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'report_type' => $data['report_type'],
                'group_by_config' => $data['group_by_config'] ?? [],
                'summary_by_config' => $data['summary_by_config'] ?? [],
                'filters_config' => $data['filters_config'] ?? [],
                'chart_config' => $data['chart_config'] ?? [],
                'formatting_config' => $data['formatting_config'] ?? [],
                'is_public' => $data['is_public'] ?? false,
                'version' => '1.0'
            ]);

            // Create template fields if provided
            if (!empty($data['fields'])) {
                $this->createTemplateFields($template, $data['fields']);
            }

            DB::commit();
            return $template->load(['templateFields', 'templateCategory']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing template.
     */
    public function updateTemplate(ReportTemplate $template, array $data): ReportTemplate
    {
        if (!$template->canBeEditedBy(Auth::user())) {
            throw new \Exception('You do not have permission to edit this template.');
        }

        DB::beginTransaction();
        
        try {
            $template->update([
                'template_category_id' => $data['template_category_id'] ?? $template->template_category_id,
                'name' => $data['name'] ?? $template->name,
                'description' => $data['description'] ?? $template->description,
                'group_by_config' => $data['group_by_config'] ?? $template->group_by_config,
                'summary_by_config' => $data['summary_by_config'] ?? $template->summary_by_config,
                'filters_config' => $data['filters_config'] ?? $template->filters_config,
                'chart_config' => $data['chart_config'] ?? $template->chart_config,
                'formatting_config' => $data['formatting_config'] ?? $template->formatting_config,
                'is_public' => $data['is_public'] ?? $template->is_public,
            ]);

            // Update template fields if provided
            if (isset($data['fields'])) {
                $template->templateFields()->delete();
                $this->createTemplateFields($template, $data['fields']);
            }

            DB::commit();
            return $template->fresh(['templateFields', 'templateCategory']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Clone an existing template.
     */
    public function cloneTemplate(ReportTemplate $sourceTemplate, string $newName): ReportTemplate
    {
        DB::beginTransaction();
        
        try {
            $clonedTemplate = ReportTemplate::create([
                'user_id' => Auth::id(),
                'template_category_id' => $sourceTemplate->template_category_id,
                'name' => $newName,
                'description' => "Cloned from: " . $sourceTemplate->name,
                'report_type' => $sourceTemplate->report_type,
                'group_by_config' => $sourceTemplate->group_by_config,
                'summary_by_config' => $sourceTemplate->summary_by_config,
                'filters_config' => $sourceTemplate->filters_config,
                'chart_config' => $sourceTemplate->chart_config,
                'formatting_config' => $sourceTemplate->formatting_config,
                'is_public' => false,
                'version' => '1.0'
            ]);

            // Clone template fields
            foreach ($sourceTemplate->templateFields as $field) {
                TemplateField::create([
                    'report_template_id' => $clonedTemplate->id,
                    'field_name' => $field->field_name,
                    'field_label' => $field->field_label,
                    'field_type' => $field->field_type,
                    'data_type' => $field->data_type,
                    'field_options' => $field->field_options,
                    'is_required' => $field->is_required,
                    'is_filterable' => $field->is_filterable,
                    'is_groupable' => $field->is_groupable,
                    'is_sortable' => $field->is_sortable,
                    'is_visible' => $field->is_visible,
                    'sort_order' => $field->sort_order,
                    'format_rule' => $field->format_rule,
                ]);
            }

            DB::commit();
            return $clonedTemplate->load(['templateFields', 'templateCategory']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a template.
     */
    public function deleteTemplate(ReportTemplate $template): bool
    {
        if (!$template->canBeEditedBy(Auth::user())) {
            throw new \Exception('You do not have permission to delete this template.');
        }

        return $template->delete();
    }

    /**
     * Get predefined field configurations for different report types.
     */
    public function getPredefinedFields(string $reportType): array
    {
        switch ($reportType) {
            case 'transactions':
                return [
                    [
                        'field_name' => 'created_at',
                        'field_label' => 'Date',
                        'field_type' => 'date',
                        'data_type' => 'date',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true,
                        'format_rule' => 'date'
                    ],
                    [
                        'field_name' => 'amount',
                        'field_label' => 'Amount',
                        'field_type' => 'number',
                        'data_type' => 'decimal',
                        'is_groupable' => false,
                        'is_filterable' => true,
                        'is_sortable' => true,
                        'format_rule' => 'currency'
                    ],
                    [
                        'field_name' => 'category.name',
                        'field_label' => 'Category',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ],
                    [
                        'field_name' => 'wallet.name',
                        'field_label' => 'Wallet',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ],
                    [
                        'field_name' => 'expense_person.name',
                        'field_label' => 'Person',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ],
                    [
                        'field_name' => 'type',
                        'field_label' => 'Type',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'field_options' => ['options' => ['income', 'expense']],
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ]
                ];

            case 'budgets':
                return [
                    [
                        'field_name' => 'created_at',
                        'field_label' => 'Date',
                        'field_type' => 'date',
                        'data_type' => 'date',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true,
                        'format_rule' => 'date'
                    ],
                    [
                        'field_name' => 'budget_amount',
                        'field_label' => 'Budget Amount',
                        'field_type' => 'number',
                        'data_type' => 'decimal',
                        'is_groupable' => false,
                        'is_filterable' => true,
                        'is_sortable' => true,
                        'format_rule' => 'currency'
                    ],
                    [
                        'field_name' => 'category.name',
                        'field_label' => 'Category',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ]
                ];

            case 'tickets':
                return [
                    [
                        'field_name' => 'created_at',
                        'field_label' => 'Created Date',
                        'field_type' => 'date',
                        'data_type' => 'date',
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true,
                        'format_rule' => 'date'
                    ],
                    [
                        'field_name' => 'status',
                        'field_label' => 'Status',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'field_options' => ['options' => ['opened', 'closed', 'admin_replied', 'customer_replied']],
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ],
                    [
                        'field_name' => 'priority',
                        'field_label' => 'Priority',
                        'field_type' => 'select',
                        'data_type' => 'string',
                        'field_options' => ['options' => ['low', 'medium', 'high', 'urgent']],
                        'is_groupable' => true,
                        'is_filterable' => true,
                        'is_sortable' => true
                    ]
                ];

            default:
                return [];
        }
    }

    /**
     * Create template fields for a template.
     */
    private function createTemplateFields(ReportTemplate $template, array $fields): void
    {
        foreach ($fields as $index => $fieldData) {
            TemplateField::create([
                'report_template_id' => $template->id,
                'field_name' => $fieldData['field_name'],
                'field_label' => $fieldData['field_label'],
                'field_type' => $fieldData['field_type'],
                'data_type' => $fieldData['data_type'] ?? 'string',
                'field_options' => $fieldData['field_options'] ?? null,
                'is_required' => $fieldData['is_required'] ?? false,
                'is_filterable' => $fieldData['is_filterable'] ?? true,
                'is_groupable' => $fieldData['is_groupable'] ?? true,
                'is_sortable' => $fieldData['is_sortable'] ?? true,
                'is_visible' => $fieldData['is_visible'] ?? true,
                'sort_order' => $fieldData['sort_order'] ?? $index,
                'format_rule' => $fieldData['format_rule'] ?? null,
            ]);
        }
    }
}