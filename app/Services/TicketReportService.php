<?php

namespace App\Services;

use App\Models\SupportTicket;
use App\Exports\TicketReportExport;
use App\Exports\TicketReportCsvExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class TicketReportService
{
    private const CACHE_TTL = 1; // 5 minutes
    
    private array $dateRanges = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'this_week' => 'This Week',
        'last_week' => 'Last Week',
        'this_month' => 'This Month',
        'last_month' => 'Last Month',
        'this_quarter' => 'This Quarter',
        'last_quarter' => 'Last Quarter',
        'this_year' => 'This Year',
        'last_year' => 'Last Year',
    ];

    private array $statusOptions = [
        'all' => 'All Statuses',
        'opened' => 'Open',
        'closed' => 'Closed',
        'admin_replied' => 'Admin Replied',
        'customer_replied' => 'Customer Replied',
    ];

    /**
     * Generate comprehensive ticket report
     */
    public function generateTicketReport(Request $request)
    {
        $userId = Auth::id();
        $validatedData = $this->validateTicketReportRequest($request);
        
        $reportData = $this->getProcessedTicketData($validatedData);
        
        return $this->generateReport($validatedData['report_format'], $reportData, $validatedData);
    }

    /**
     * Get processed ticket data with optimized queries
     */
    private function getProcessedTicketData(array $validatedData): array
    {
        $dateRange = $this->getDateRange(
            $validatedData['date_range'], 
            $validatedData['start_date'] ?? null, 
            $validatedData['end_date'] ?? null
        );

        // Build optimized query
        $query = SupportTicket::select([
            'support_tickets.id',
            'support_tickets.user_id',
            'support_tickets.subject',
            'support_tickets.status',
            'support_tickets.created_at',
            'support_tickets.updated_at',
            'support_tickets.closed_at',
            'support_tickets.deleted_at',
            // Count messages for each ticket
            DB::raw('(SELECT COUNT(*) FROM support_messages WHERE support_messages.support_ticket_id = support_tickets.id) as message_count'),
            // Get last message timestamp
            DB::raw('(SELECT MAX(created_at) FROM support_messages WHERE support_messages.support_ticket_id = support_tickets.id) as last_message_at'),
            // Calculate response time (time between ticket creation and first admin reply)
            DB::raw('(
                SELECT TIMESTAMPDIFF(HOUR, support_tickets.created_at, MIN(support_messages.created_at))
                FROM support_messages 
                WHERE support_messages.support_ticket_id = support_tickets.id 
                AND support_messages.is_admin = 1
            ) as first_response_time_hours'),
            // Calculate resolution time
            DB::raw('CASE 
                WHEN support_tickets.closed_at IS NOT NULL 
                THEN ROUND(TIMESTAMPDIFF(HOUR, support_tickets.created_at, support_tickets.closed_at), 2)
                ELSE NULL 
            END as resolution_time_hours'),
        ])
        ->with([
            'messages' => function ($query) {
                $query->select(['id', 'support_ticket_id', 'user_id', 'is_admin', 'message', 'created_at'])
                      ->orderBy('created_at', 'asc');
            },
            'user:id,name,email',
            'user:id,name,email'
        ]);

        // Apply date range filter
        if ($dateRange[0] && $dateRange[1]) {
            $query->whereBetween('support_tickets.created_at', $dateRange);
        }

        // Apply status filter
        if (isset($validatedData['status']) && $validatedData['status'] !== 'all') {
            $query->where('support_tickets.status', $validatedData['status']);
        }

        // Apply priority filter
        if (isset($validatedData['priority']) && $validatedData['priority'] !== 'all') {
            $query->where('support_tickets.priority', $validatedData['priority']);
        }

        // Apply category filter
        if (isset($validatedData['category']) && $validatedData['category'] !== 'all') {
            $query->where('support_tickets.category', $validatedData['category']);
        }

        // Include trashed tickets if requested
        if (isset($validatedData['is_trashed']) && $validatedData['is_trashed']) {
            $query->withTrashed();
        }

        // Apply sorting
        $sortBy = $validatedData['sort_by'] ?? 'created_at';
        $sortOrder = $validatedData['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $tickets = $query->get()->map(function ($ticket) {
            // Calculate additional metrics
            $ticket->age_in_days = $ticket->created_at->diffInDays(now());
            $ticket->is_overdue = $this->isTicketOverdue($ticket);
            $ticket->status_label = $this->getStatusLabel($ticket->status);
            // $ticket->priority_label = $this->getPriorityLabel($ticket->priority);
            $ticket->customer_satisfaction = $this->getCustomerSatisfactionScore($ticket);
            
            return $ticket;
        });

        // Calculate summary statistics
        $summary = $this->calculateSummaryStats($tickets, $dateRange);

        return [
            'tickets' => $tickets,
            'summary' => $summary,
            'dateRange' => $dateRange,
            'filters' => $validatedData,
            'dateRanges' => $this->dateRanges,
            'status_options' => $this->statusOptions,
        ];
    }

    /**
     * Calculate comprehensive summary statistics
     */
    private function calculateSummaryStats(Collection $tickets, array $dateRange): array
    {
        $totalTickets = $tickets->count();
        $closedTickets = $tickets->where('status', 'closed')->count();
        $openTickets = $tickets->whereIn('status', ['opened', 'admin_replied', 'customer_replied'])->count();
        $overdueTickets = $tickets->where('is_overdue', true)->count();
        
        // Response time statistics
        $responseTimeTickets = $tickets->whereNotNull('first_response_time_hours');
        $avgResponseTime = $responseTimeTickets->avg('first_response_time_hours');
        $medianResponseTime = $this->calculateMedian($responseTimeTickets->pluck('first_response_time_hours'));
        
        // Resolution time statistics
        $resolvedTickets = $tickets->whereNotNull('resolution_time_hours');
        $avgResolutionTime = $resolvedTickets->avg('resolution_time_hours');
        $medianResolutionTime = $this->calculateMedian($resolvedTickets->pluck('resolution_time_hours'));
        
        // Customer satisfaction
        $satisfactionScores = $tickets->pluck('customer_satisfaction')->filter();
        $avgSatisfaction = $satisfactionScores->avg();
        
        // Status breakdown
        $statusBreakdown = $tickets->groupBy('status')->map->count();
        
        // Priority breakdown
        $priorityBreakdown = $tickets->groupBy('priority')->map->count();
        
        // Category breakdown
        $categoryBreakdown = $tickets->groupBy('category')->map->count();
        
        // Trend analysis (if date range is available)
        $dailyTicketCounts = [];
        if ($dateRange[0] && $dateRange[1]) {
            $dailyTicketCounts = $this->calculateDailyTicketCounts($tickets, $dateRange);
        }

        return [
            'total_tickets' => $totalTickets,
            'open_tickets' => $openTickets,
            'closed_tickets' => $closedTickets,
            'overdue_tickets' => $overdueTickets,
            'in_progress_tickets' => $totalTickets - $closedTickets,
            'resolved_tickets' => $closedTickets,
            'resolution_rate' => $totalTickets > 0 ? ($closedTickets / $totalTickets) * 100 : 0,
            'avg_response_time_hours' => round($avgResponseTime ?? 0, 2),
            'median_response_time_hours' => round($medianResponseTime ?? 0, 2),
            'avg_resolution_time_hours' => round($avgResolutionTime ?? 0, 2),
            'median_resolution_time_hours' => round($medianResolutionTime ?? 0, 2),
            'avg_customer_satisfaction' => round($avgSatisfaction ?? 0, 2),
            'total_messages' => $tickets->sum('message_count'),
            'avg_messages_per_ticket' => $totalTickets > 0 ? round($tickets->avg('message_count'), 2) : 0,
            'status_breakdown' => $statusBreakdown,
            'priority_breakdown' => $priorityBreakdown,
            'category_breakdown' => $categoryBreakdown,
            'daily_ticket_counts' => $dailyTicketCounts,
            'performance_score' => $this->calculatePerformanceScore($tickets),
        ];
    }

    /**
     * Generate report based on format
     */
    private function generateReport(string $format, array $reportData, array $validatedData)
    {
        $fileName = 'ticket_report_' . now()->format('Ymd_His');
        
        switch ($format) {
            case 'pdf':
                return $this->generatePdfReport($reportData, $fileName);
            
            case 'html':
                return $this->generateHtmlReport($reportData);
            
            case 'csv':
                return $this->generateCsvReport($reportData, $fileName);
            
            case 'xlsx':
                return $this->generateExcelReport($reportData, $fileName);
            
            default:
                throw new \InvalidArgumentException('Invalid report format selected.');
        }
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport(array $reportData, string $fileName)
    {
        return Pdf::loadView('reports.tickets.pdf', $reportData)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi' => 96,
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'chroot' => public_path(),
            ])
            ->stream($fileName . '.pdf');
    }

    /**
     * Generate HTML report
     */
    private function generateHtmlReport(array $reportData)
    {
        return view('reports.tickets.html', $reportData);
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport(array $reportData, string $fileName)
    {
        return Excel::download(new TicketReportCsvExport($reportData), $fileName . '.csv');
    }

    /**
     * Generate Excel report
     */
    private function generateExcelReport(array $reportData, string $fileName)
    {
        return Excel::download(new TicketReportExport($reportData), $fileName . '.xlsx');
    }

    /**
     * Validate request parameters for ticket reports
     */
    public function validateTicketReportRequest(Request $request): array
    {
        $rules = [
            'report_format' => 'required|in:pdf,html,csv,xlsx',
            'date_range' => 'required|in:all,today,yesterday,this_week,last_week,this_month,last_month,this_quarter,last_quarter,this_year,last_year,custom',
            'start_date' => 'nullable|date|before_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date|before_or_equal:today',
            'status' => 'nullable|in:all,opened,closed,admin_replied,customer_replied',
            'priority' => 'nullable|in:all,low,medium,high,urgent',
            'category' => 'nullable|string|max:50',
            'is_trashed' => 'nullable|boolean',
        ];

        $messages = [
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'start_date.before_or_equal' => 'Start date cannot be in the future.',
            'end_date.before_or_equal' => 'End date cannot be in the future.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Get optimized date range
     */
    private function getDateRange(string $range, ?string $startDate = null, ?string $endDate = null): array
    {
        if ($range === 'custom') {
            return [
                $startDate ? Carbon::parse($startDate)->startOfDay() : null,
                $endDate ? Carbon::parse($endDate)->endOfDay() : null
            ];
        }

        if ($range === 'all') {
            return [null, null];
        }

        $now = now();

        return match ($range) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'yesterday' => [$now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()],
            'this_week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'last_week' => [$now->copy()->subWeek()->startOfWeek(), $now->copy()->subWeek()->endOfWeek()],
            'this_month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'last_month' => [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()],
            'this_quarter' => [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()],
            'last_quarter' => [$now->copy()->subQuarter()->startOfQuarter(), $now->copy()->subQuarter()->endOfQuarter()],
            'this_year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            'last_year' => [$now->copy()->subYear()->startOfYear(), $now->copy()->subYear()->endOfYear()],
            default => [null, null]
        };
    }

    // Helper methods
    private function generateCacheKey(int $userId, array $validatedData): string
    {
        return 'ticket_report_' . $userId . '_' . md5(serialize($validatedData));
    }

    private function isTicketOverdue($ticket): bool
    {
        if ($ticket->status === 'closed') {
            return false;
        }

        $slaHours = match($ticket->priority) {
            'urgent' => 4,
            'high' => 24,
            'medium' => 72,
            'low' => 168,
            default => 72
        };

        return $ticket->created_at->addHours($slaHours)->isPast();
    }

    private function getStatusLabel(string $status): string
    {
        return match($status) {
            'opened' => 'Open',
            'closed' => 'Closed',
            'admin_replied' => 'Admin Replied',
            'customer_replied' => 'Customer Replied',
            default => ucfirst($status)
        };
    }

    private function getPriorityLabel(string $priority): string
    {
        return ucfirst($priority);
    }

    private function getCustomerSatisfactionScore($ticket): ?float
    {
        // This would typically come from a separate rating/feedback system
        // For now, we'll calculate a simple score based on resolution time and interactions
        if ($ticket->status !== 'closed') {
            return null;
        }

        $baseScore = 5.0;
        
        // Deduct points for long resolution times
        if ($ticket->resolution_time_hours > 72) {
            $baseScore -= 1.0;
        } elseif ($ticket->resolution_time_hours > 24) {
            $baseScore -= 0.5;
        }

        // Deduct points for too many messages (indicating complexity or poor service)
        if ($ticket->message_count > 10) {
            $baseScore -= 0.5;
        }

        return max(1.0, $baseScore);
    }

    private function calculateMedian(Collection $values): float
    {
        $sorted = $values->sort()->values();
        $count = $sorted->count();
        
        if ($count === 0) {
            return 0;
        }

        if ($count % 2 === 0) {
            return ($sorted[$count / 2 - 1] + $sorted[$count / 2]) / 2;
        }

        return $sorted[floor($count / 2)];
    }

    private function calculateDailyTicketCounts(Collection $tickets, array $dateRange): array
    {
        if (!$dateRange[0] || !$dateRange[1]) {
            return [];
        }

        $dailyCounts = [];
        $current = $dateRange[0]->copy();
        
        while ($current->lte($dateRange[1])) {
            $dayTickets = $tickets->filter(function ($ticket) use ($current) {
                return $ticket->created_at->isSameDay($current);
            });
            
            $dailyCounts[] = [
                'date' => $current->format('Y-m-d'),
                'count' => $dayTickets->count(),
                'opened' => $dayTickets->where('status', 'opened')->count(),
                'closed' => $dayTickets->where('status', 'closed')->count(),
            ];
            
            $current->addDay();
        }

        return $dailyCounts;
    }

    private function calculatePerformanceScore(Collection $tickets): float
    {
        if ($tickets->isEmpty()) {
            return 0;
        }

        $score = 100;
        
        // Deduct points for overdue tickets
        $overdueRate = $tickets->where('is_overdue', true)->count() / $tickets->count();
        $score -= $overdueRate * 30;
        
        // Deduct points for poor response time
        $avgResponseTime = $tickets->whereNotNull('first_response_time_hours')->avg('first_response_time_hours');
        if ($avgResponseTime > 24) {
            $score -= 20;
        } elseif ($avgResponseTime > 8) {
            $score -= 10;
        }
        
        // Add points for good resolution rate
        $resolutionRate = $tickets->where('status', 'closed')->count() / $tickets->count();
        $score += $resolutionRate * 10;

        return max(0, min(100, $score));
    }
}