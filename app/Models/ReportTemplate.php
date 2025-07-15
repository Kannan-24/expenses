<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportTemplate extends Model
{
    protected $fillable = [
        'user_id',
        'template_category_id',
        'name',
        'description',
        'report_type',
        'group_by_config',
        'summary_by_config',
        'filters_config',
        'chart_config',
        'formatting_config',
        'is_public',
        'is_active',
        'version',
        'usage_count',
        'last_used_at'
    ];

    protected $casts = [
        'group_by_config' => 'array',
        'summary_by_config' => 'array',
        'filters_config' => 'array',
        'chart_config' => 'array',
        'formatting_config' => 'array',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
        'last_used_at' => 'datetime'
    ];

    /**
     * Get the user that owns the template.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that this template belongs to.
     */
    public function templateCategory(): BelongsTo
    {
        return $this->belongsTo(TemplateCategory::class);
    }

    /**
     * Get the template fields for this template.
     */
    public function templateFields(): HasMany
    {
        return $this->hasMany(TemplateField::class)->orderBy('sort_order');
    }

    /**
     * Get only visible template fields.
     */
    public function visibleFields(): HasMany
    {
        return $this->hasMany(TemplateField::class)
            ->where('is_visible', true)
            ->orderBy('sort_order');
    }

    /**
     * Get filterable fields.
     */
    public function filterableFields(): HasMany
    {
        return $this->hasMany(TemplateField::class)
            ->where('is_filterable', true)
            ->orderBy('sort_order');
    }

    /**
     * Get groupable fields.
     */
    public function groupableFields(): HasMany
    {
        return $this->hasMany(TemplateField::class)
            ->where('is_groupable', true)
            ->orderBy('sort_order');
    }

    /**
     * Scope a query to only include active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include public templates.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query for templates accessible by a user (owned or public).
     */
    public function scopeAccessibleByUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('is_public', true);
        });
    }

    /**
     * Increment usage count and update last used timestamp.
     */
    public function recordUsage()
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Get display name with category.
     */
    public function getFullDisplayName(): string
    {
        $category = $this->templateCategory?->name ?? 'Uncategorized';
        return "{$category} - {$this->name}";
    }

    /**
     * Check if template can be edited by user.
     */
    public function canBeEditedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}
