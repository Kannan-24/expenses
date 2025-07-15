<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateField extends Model
{
    protected $fillable = [
        'report_template_id',
        'field_name',
        'field_label',
        'field_type',
        'data_type',
        'field_options',
        'is_required',
        'is_filterable',
        'is_groupable',
        'is_sortable',
        'is_visible',
        'sort_order',
        'format_rule'
    ];

    protected $casts = [
        'field_options' => 'array',
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'is_groupable' => 'boolean',
        'is_sortable' => 'boolean',
        'is_visible' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the report template that owns this field.
     */
    public function reportTemplate(): BelongsTo
    {
        return $this->belongsTo(ReportTemplate::class);
    }

    /**
     * Scope a query to only include visible fields.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query to only include filterable fields.
     */
    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    /**
     * Scope a query to only include groupable fields.
     */
    public function scopeGroupable($query)
    {
        return $query->where('is_groupable', true);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the validation rules for this field.
     */
    public function getValidationRules(): array
    {
        $rules = [];
        
        if ($this->is_required) {
            $rules[] = 'required';
        }

        switch ($this->data_type) {
            case 'integer':
                $rules[] = 'integer';
                break;
            case 'decimal':
                $rules[] = 'numeric';
                break;
            case 'date':
                $rules[] = 'date';
                break;
            case 'boolean':
                $rules[] = 'boolean';
                break;
            default:
                $rules[] = 'string';
        }

        // Add custom validation rules from field options
        if (!empty($this->field_options['validation'])) {
            $rules = array_merge($rules, $this->field_options['validation']);
        }

        return $rules;
    }

    /**
     * Get formatted value based on format rule.
     */
    public function formatValue($value): string
    {
        if (empty($this->format_rule) || $value === null) {
            return (string) $value;
        }

        switch ($this->format_rule) {
            case 'currency':
                return '$' . number_format((float) $value, 2);
            case 'percentage':
                return number_format((float) $value * 100, 2) . '%';
            case 'date':
                return date('Y-m-d', strtotime($value));
            case 'datetime':
                return date('Y-m-d H:i:s', strtotime($value));
            default:
                return (string) $value;
        }
    }
}
