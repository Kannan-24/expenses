<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportHistory extends Model
{
    protected $fillable = [
        'user_id',
        'report_type',
        'report_format',
        'date_range',
        'start_date',
        'end_date',
        'filters',
    ];

    protected $casts = [
        'filters' => 'array', // Cast filters to array for easier handling
    ];

    /**
     * Get the user that owns the report history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get display name for the report
     */
    public function getDisplayName(): string
    {
        $parts = [];

        // Report type
        $parts[] = ucfirst($this->report_type) . ' Report';

        // Date range
        if ($this->date_range !== 'all') {
            $parts[] = ucfirst(str_replace('_', ' ', $this->date_range));
        }

        // Transaction type filter
        if (isset($this->filters['transaction_type']) && $this->filters['transaction_type'] !== 'all') {
            $parts[] = ucfirst($this->filters['transaction_type']);
        }

        // Status filter for tickets
        if (isset($this->filters['status']) && $this->filters['status'] !== 'all') {
            $parts[] = ucfirst(str_replace('_', ' ', $this->filters['status']));
        }

        return implode(' - ', $parts);
    }

    /**
     * Get active filters count
     */
    public function getActiveFiltersCount(): int
    {
        return count(array_filter($this->filters, function ($value) {
            return $value && $value !== 'all' && $value !== '';
        }));
    }
}
