<?php

namespace App\Services;

use App\Models\ReportTemplate;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DynamicQueryBuilder
{
    /**
     * Build query based on template configuration.
     */
    public function buildQuery(ReportTemplate $template, array $filters = []): Builder
    {
        $baseQuery = $this->getBaseQuery($template->report_type);
        
        // Apply template-specific field filters
        $query = $this->applyTemplateFields($baseQuery, $template);
        
        // Apply user-provided filters
        $query = $this->applyUserFilters($query, $template, $filters);
        
        // Apply grouping configuration
        $query = $this->applyGroupByConfig($query, $template);
        
        // Apply sorting
        $query = $this->applySorting($query, $template, $filters);
        
        return $query;
    }

    /**
     * Get base query for report type.
     */
    private function getBaseQuery(string $reportType): Builder
    {
        switch ($reportType) {
            case 'transactions':
                return Transaction::with(['category', 'wallet', 'expensePerson'])
                    ->where('user_id', Auth::id());
                    
            case 'budgets':
                return Budget::with(['category'])
                    ->where('user_id', Auth::id());
                    
            case 'tickets':
                return SupportTicket::with(['user'])
                    ->where('user_id', Auth::id());
                    
            default:
                throw new \InvalidArgumentException("Unsupported report type: {$reportType}");
        }
    }

    /**
     * Apply template field selection.
     */
    private function applyTemplateFields(Builder $query, ReportTemplate $template): Builder
    {
        $visibleFields = $template->visibleFields;
        
        if ($visibleFields->isNotEmpty()) {
            $selectFields = ['id']; // Always include ID
            
            foreach ($visibleFields as $field) {
                $fieldName = $this->mapFieldName($field->field_name, $template->report_type);
                if ($fieldName && !in_array($fieldName, $selectFields)) {
                    $selectFields[] = $fieldName;
                }
            }
            
            $query->select($selectFields);
        }
        
        return $query;
    }

    /**
     * Apply user-provided filters.
     */
    private function applyUserFilters(Builder $query, ReportTemplate $template, array $filters): Builder
    {
        $filterableFields = $template->filterableFields;
        
        foreach ($filters as $filterKey => $filterValue) {
            if (empty($filterValue)) continue;
            
            $field = $filterableFields->firstWhere('field_name', $filterKey);
            if (!$field) continue;
            
            $query = $this->applyFieldFilter($query, $field, $filterValue, $template->report_type);
        }
        
        // Apply date range filters
        if (!empty($filters['date_range']) && $filters['date_range'] !== 'all') {
            $query = $this->applyDateRangeFilter($query, $filters);
        }
        
        return $query;
    }

    /**
     * Apply individual field filter.
     */
    private function applyFieldFilter(Builder $query, $field, $value, string $reportType): Builder
    {
        $dbField = $this->mapFieldName($field->field_name, $reportType);
        
        switch ($field->field_type) {
            case 'select':
                if (is_array($value)) {
                    $query->whereIn($dbField, $value);
                } else {
                    $query->where($dbField, $value);
                }
                break;
                
            case 'number':
                if (isset($value['operator']) && isset($value['amount'])) {
                    switch ($value['operator']) {
                        case '>':
                            $query->where($dbField, '>', $value['amount']);
                            break;
                        case '<':
                            $query->where($dbField, '<', $value['amount']);
                            break;
                        case '=':
                            $query->where($dbField, '=', $value['amount']);
                            break;
                        case '>=':
                            $query->where($dbField, '>=', $value['amount']);
                            break;
                        case '<=':
                            $query->where($dbField, '<=', $value['amount']);
                            break;
                    }
                } else {
                    $query->where($dbField, $value);
                }
                break;
                
            case 'date':
                if (isset($value['start']) && isset($value['end'])) {
                    $query->whereBetween($dbField, [$value['start'], $value['end']]);
                } else {
                    $query->whereDate($dbField, $value);
                }
                break;
                
            case 'text':
                $query->where($dbField, 'LIKE', "%{$value}%");
                break;
                
            default:
                $query->where($dbField, $value);
        }
        
        return $query;
    }

    /**
     * Apply group by configuration.
     */
    private function applyGroupByConfig(Builder $query, ReportTemplate $template): Builder
    {
        $groupByConfig = $template->group_by_config;
        
        if (empty($groupByConfig) || !isset($groupByConfig['fields'])) {
            return $query;
        }
        
        foreach ($groupByConfig['fields'] as $groupField) {
            $dbField = $this->mapFieldName($groupField, $template->report_type);
            if ($dbField) {
                $query->groupBy($dbField);
            }
        }
        
        return $query;
    }

    /**
     * Apply sorting configuration.
     */
    private function applySorting(Builder $query, ReportTemplate $template, array $filters): Builder
    {
        // User-provided sorting takes precedence
        if (!empty($filters['sort_by']) && !empty($filters['sort_direction'])) {
            $sortField = $this->mapFieldName($filters['sort_by'], $template->report_type);
            if ($sortField) {
                $query->orderBy($sortField, $filters['sort_direction']);
                return $query;
            }
        }
        
        // Default sorting based on report type
        switch ($template->report_type) {
            case 'transactions':
                $query->orderBy('created_at', 'desc');
                break;
            case 'budgets':
                $query->orderBy('created_at', 'desc');
                break;
            case 'tickets':
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        return $query;
    }

    /**
     * Apply date range filter.
     */
    private function applyDateRangeFilter(Builder $query, array $filters): Builder
    {
        $dateField = 'created_at'; // Default date field
        
        switch ($filters['date_range']) {
            case 'today':
                $query->whereDate($dateField, today());
                break;
            case 'yesterday':
                $query->whereDate($dateField, yesterday());
                break;
            case 'this_week':
                $query->whereBetween($dateField, [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween($dateField, [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween($dateField, [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween($dateField, [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                break;
            case 'this_quarter':
                $query->whereBetween($dateField, [now()->startOfQuarter(), now()->endOfQuarter()]);
                break;
            case 'last_quarter':
                $query->whereBetween($dateField, [now()->subQuarter()->startOfQuarter(), now()->subQuarter()->endOfQuarter()]);
                break;
            case 'this_year':
                $query->whereBetween($dateField, [now()->startOfYear(), now()->endOfYear()]);
                break;
            case 'last_year':
                $query->whereBetween($dateField, [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()]);
                break;
            case 'custom':
                if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
                    $query->whereBetween($dateField, [$filters['start_date'], $filters['end_date']]);
                }
                break;
        }
        
        return $query;
    }

    /**
     * Map template field names to database field names.
     */
    private function mapFieldName(string $fieldName, string $reportType): ?string
    {
        $fieldMappings = [
            'transactions' => [
                'created_at' => 'created_at',
                'amount' => 'amount',
                'type' => 'type',
                'description' => 'description',
                'category.name' => 'category_id', // Will need special handling for joins
                'wallet.name' => 'wallet_id',
                'expense_person.name' => 'expense_person_id',
            ],
            'budgets' => [
                'created_at' => 'created_at',
                'budget_amount' => 'budget_amount',
                'category.name' => 'category_id',
                'period' => 'period',
            ],
            'tickets' => [
                'created_at' => 'created_at',
                'status' => 'status',
                'priority' => 'priority',
                'subject' => 'subject',
                'category' => 'category',
            ]
        ];
        
        return $fieldMappings[$reportType][$fieldName] ?? null;
    }

    /**
     * Get aggregated data based on template configuration.
     */
    public function getAggregatedData(ReportTemplate $template, array $filters = []): array
    {
        $query = $this->buildQuery($template, $filters);
        $summaryConfig = $template->summary_by_config;
        
        if (empty($summaryConfig)) {
            return ['data' => $query->get()->toArray()];
        }
        
        $aggregations = [];
        
        foreach ($summaryConfig as $field => $operations) {
            $dbField = $this->mapFieldName($field, $template->report_type);
            
            if (!$dbField) continue;
            
            foreach ($operations as $operation) {
                switch ($operation) {
                    case 'sum':
                        $aggregations[$field . '_sum'] = DB::raw("SUM({$dbField})");
                        break;
                    case 'avg':
                        $aggregations[$field . '_avg'] = DB::raw("AVG({$dbField})");
                        break;
                    case 'count':
                        $aggregations[$field . '_count'] = DB::raw("COUNT({$dbField})");
                        break;
                    case 'min':
                        $aggregations[$field . '_min'] = DB::raw("MIN({$dbField})");
                        break;
                    case 'max':
                        $aggregations[$field . '_max'] = DB::raw("MAX({$dbField})");
                        break;
                }
            }
        }
        
        if (!empty($aggregations)) {
            $query->select($aggregations);
            return ['aggregations' => $query->first(), 'data' => []];
        }
        
        return ['data' => $query->get()->toArray()];
    }

    /**
     * Get grouped data for visualization.
     */
    public function getGroupedData(ReportTemplate $template, array $filters = []): array
    {
        $query = $this->buildQuery($template, $filters);
        $groupByConfig = $template->group_by_config;
        
        if (empty($groupByConfig)) {
            return $query->get()->toArray();
        }
        
        // Add count aggregation for grouped data
        $query->selectRaw('COUNT(*) as count');
        
        // Add group by fields to select
        foreach ($groupByConfig['fields'] as $field) {
            $dbField = $this->mapFieldName($field, $template->report_type);
            if ($dbField) {
                $query->addSelect($dbField);
            }
        }
        
        return $query->get()->toArray();
    }
}