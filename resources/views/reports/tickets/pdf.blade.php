<x-pdf-layout>
    <x-slot name="title">Ticket Report</x-slot>

    <style>
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .header .subtitle {
            color: #6b7280;
            font-size: 12px;
            margin: 0;
        }

        .filters-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 10px 0;
            margin-bottom: 25px;
        }

        .filters-title {
            color: #374151;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .filter-item {
            margin-top: 10px;
            display: inline-block;
            margin-right: 20px;
        }

        .filter-label {
            display: inline-block;
            color: #4b5563;
            font-weight: bold;
            font-size: 10px;
        }

        .filter-value {
            display: inline-block;
            color: #111827;
            padding: 2px 6px;
            border: 1px solid #d1d5db;
            background: #fff;
            font-size: 10px;
        }

        .summary-cards {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary-card {
            width: calc(20% - 29.08px);
            display: inline-block;
            vertical-align: top;
            padding: 8px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            text-align: center;
            margin-right: 10px;
        }

        .summary-card:last-child {
            margin-right: 0;
        }

        .summary-card.total {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .summary-card.open {
            background: #fef3c7;
            border-color: #fbbf24;
        }

        .summary-card.in-progress {
            background: #dbeafe;
            border-color: #60a5fa;
        }

        .summary-card.resolved {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .summary-card.closed {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .summary-card h3 {
            margin: 0 0 5px 0;
            font-size: 9px;
            color: #6b7280;
            font-weight: bold;
            text-transform: uppercase;
        }

        .summary-card .amount {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        .total .amount {
            color: #2563eb;
        }

        .open .amount {
            color: #d97706;
        }

        .in-progress .amount {
            color: #3b82f6;
        }

        .resolved .amount {
            color: #059669;
        }

        .closed .amount {
            color: #6b7280;
        }

        .insights-section {
            background: #fefefe;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 25px;
        }

        .insights-title {
            color: #374151;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .insight-item {
            font-size: 10px;
            margin-bottom: 8px;
            padding: 5px;
            border-left: 3px solid #2563eb;
            background: #f8fafc;
        }

        .insight-item.warning {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .insight-item.danger {
            border-left-color: #dc2626;
            background: #fef2f2;
        }

        .insight-item.success {
            border-left-color: #059669;
            background: #ecfdf5;
        }

        .table-container {
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        thead th {
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 8px;
            border-right: 1px solid #cbd5e1;
        }

        thead th:last-child {
            border-right: none;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody td {
            padding: 5px 4px;
            border-right: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tbody td:last-child {
            border-right: none;
        }

        .priority-high {
            color: #dc2626;
            font-weight: bold;
        }

        .priority-medium {
            color: #f59e0b;
            font-weight: bold;
        }

        .priority-low {
            color: #10b981;
            font-weight: bold;
        }

        .status-badge {
            padding: 2px 4px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .status-open {
            background: #fbbf24;
            color: #92400e;
        }

        .status-in-progress {
            background: #60a5fa;
            color: #1e40af;
        }

        .status-resolved {
            background: #a7f3d0;
            color: #065f46;
        }

        .status-closed {
            background: #d1d5db;
            color: #374151;
        }

        .category-color {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }

        .urgency-indicator {
            font-size: 12px;
            margin-right: 3px;
        }

        .sla-warning {
            color: #dc2626;
            font-weight: bold;
        }

        .sla-good {
            color: #059669;
            font-weight: bold;
        }

        .ticket-analytics {
            margin-top: 25px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px;
        }

        .ticket-analytics h3 {
            color: #374151;
            font-size: 14px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .analytics-item {
            font-size: 9px;
            border-bottom: 1px solid #e5e7eb;
            padding: 4px 0;
            display: flex;
            justify-content: space-between;
        }

        .analytics-item:last-child {
            border-bottom: none;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .footer-grid {
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-style: italic;
        }

        .page-break {
            page-break-before: always;
        }

        .assignee-info {
            font-size: 8px;
            color: #6b7280;
        }

        .resolution-time {
            font-size: 8px;
            color: #374151;
        }

        .ticket-id {
            font-weight: bold;
            color: #2563eb;
        }

        .customer-info {
            font-size: 8px;
            color: #4b5563;
        }
    </style>

    <div class="header">
        <h1>Ticket Management Report</h1>
        <p class="subtitle">Comprehensive analysis of support ticket performance and resolution metrics</p>
    </div>

    <div class="filters-section">
        <h3 class="filters-title">Report Parameters</h3>
        <div class="filter-grid">
            <div class="filter-item">
                <span class="filter-label">Date Range:</span>
                <span class="filter-value">
                    @if($dateRange[0] && $dateRange[1])
                        {{ $dateRange[0]->format('M d, Y') }} to {{ $dateRange[1]->format('M d, Y') }}
                    @else
                        All Time
                    @endif
                </span>
            </div>

            <div class="filter-item">
                <span class="filter-label">Total Tickets:</span>
                <span class="filter-value">{{ $summary['total_tickets'] }}</span>
            </div>

            @if(isset($filters['status']))
                <div class="filter-item">
                    <span class="filter-label">Status Filter:</span>
                    <span class="filter-value">{{ ucfirst(str_replace('_', ' ', $filters['status'])) }}</span>
                </div>
            @endif

            @if(isset($filters['priority']))
                <div class="filter-item">
                    <span class="filter-label">Priority Filter:</span>
                    <span class="filter-value">{{ ucfirst($filters['priority']) }}</span>
                </div>
            @endif

            <div class="filter-item">
                <span class="filter-label">Generated:</span>
                <span class="filter-value">{{ now()->format('M d, Y H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card total">
            <h3>Total Tickets</h3>
            <p class="amount">{{ $summary['total_tickets'] }}</p>
        </div>
        <div class="summary-card open">
            <h3>Open Tickets</h3>
            <p class="amount">{{ $summary['open_tickets'] }}</p>
        </div>
        <div class="summary-card in-progress">
            <h3>In Progress</h3>
            <p class="amount">{{ $summary['in_progress_tickets'] }}</p>
        </div>
        <div class="summary-card resolved">
            <h3>Resolved</h3>
            <p class="amount">{{ $summary['resolved_tickets'] }}</p>
        </div>
        <div class="summary-card closed">
            <h3>Closed</h3>
            <p class="amount">{{ $summary['closed_tickets'] }}</p>
        </div>
    </div>

    <div class="insights-section">
        <h3 class="insights-title">Ticket Insights</h3>
        
        @if($summary['overdue_tickets'] > 0)
            <div class="insight-item danger">
                <strong>Alert:</strong> {{ $summary['overdue_tickets'] }} ticket(s) are overdue and require immediate attention.
            </div>
        @endif

        @if($summary['avg_resolution_time_hours'] > 48)
            <div class="insight-item warning">
                <strong>Performance:</strong> Average resolution time is {{ number_format($summary['avg_resolution_time_hours'], 1) }} hours. Consider workflow optimization.
            </div>
        @elseif($summary['avg_resolution_time_hours'] < 24)
            <div class="insight-item success">
                <strong>Excellent Performance:</strong> Average resolution time is {{ number_format($summary['avg_resolution_time_hours'], 1) }} hours - well within SLA targets.
            </div>
        @else
            <div class="insight-item">
                <strong>Good Performance:</strong> Average resolution time is {{ number_format($summary['avg_resolution_time_hours'], 1) }} hours - meeting SLA expectations.
            </div>
        @endif

        @php
            $topAssignee = $tickets->groupBy('assigned_to')->sortByDesc(function($group) { return $group->count(); })->first();
            $mostUrgentCategory = $tickets->where('priority', 'high')->groupBy('category_id')->sortByDesc(function($group) { return $group->count(); })->first();
        @endphp

        @if($summary['avg_customer_satisfaction'] > 0)
            <div class="insight-item {{ $summary['avg_customer_satisfaction'] >= 4 ? 'success' : ($summary['avg_customer_satisfaction'] >= 3 ? '' : 'warning') }}">
                <strong>Customer Satisfaction:</strong> Average rating is {{ number_format($summary['avg_customer_satisfaction'], 1) }}/5.0 
                @if($summary['avg_customer_satisfaction'] >= 4)
                    - Excellent customer experience
                @elseif($summary['avg_customer_satisfaction'] >= 3)
                    - Good customer experience
                @else
                    - Improvement needed in customer experience
                @endif
            </div>
        @endif

        @if($summary['avg_response_time_hours'] > 0)
            <div class="insight-item">
                <strong>Response Time:</strong> Average first response time is {{ number_format($summary['avg_response_time_hours'], 1) }} hours.
            </div>
        @endif

        {{-- @if($summary['escalated_tickets'] > 0)
            <div class="insight-item warning">
                <strong>Escalations:</strong> {{ $summary['escalated_tickets'] }} ticket(s) have been escalated. Review escalation patterns.
            </div>
        @endif --}}
    </div>

    @if($tickets->isEmpty())
        <div class="no-data">No tickets found for the selected filters.</div>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">Ticket ID</th>
                        <th style="width: 15%;">Subject</th>
                        <th style="width: 10%;">Customer</th>
                        <th style="width: 8%;">Category</th>
                        <th style="width: 8%;">Priority</th>
                        <th style="width: 8%;">Status</th>
                        <th style="width: 10%;">Assigned To</th>
                        <th style="width: 8%;">Created</th>
                        <th style="width: 8%;">Last Update</th>
                        <th style="width: 8%;">Resolution Time</th>
                        <th style="width: 5%;">SLA</th>
                        <th style="width: 4%;">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                <span class="ticket-id">#{{ $ticket->id }}</span>
                            </td>
                            <td>
                                {{ Str::limit($ticket->subject, 25) }}
                                @if($ticket->priority === 'high')
                                    <span class="urgency-indicator priority-high">🔥</span>
                                @endif
                            </td>
                            <td class="customer-info">
                                {{ $ticket->user->name ?? 'N/A' }}
                                @if($ticket->user->email)
                                    <br><small>{{ Str::limit($ticket->user->email, 20) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="category-color" style="background-color: {{ $ticket->category->color ?? '#6B7280' }};"></span>
                                {{ $ticket->category->name ?? 'General' }}
                            </td>
                            <td>
                                <span class="priority-{{ $ticket->priority }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ str_replace(' ', '-', strtolower($ticket->status)) }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="assignee-info">
                                {{ $ticket->assignedTo->name ?? 'Unassigned' }}
                                @if($ticket->assignedTo)
                                    <br><small>{{ $ticket->assignedTo->department ?? '' }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $ticket->created_at->format('M d, Y') }}
                                <br><small>{{ $ticket->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                {{ $ticket->updated_at->format('M d, Y') }}
                                <br><small>{{ $ticket->updated_at->format('H:i') }}</small>
                            </td>
                            <td class="resolution-time">
                                @if($ticket->resolved_at)
                                    {{ $ticket->created_at->diffInHours($ticket->resolved_at) }}h
                                    <br><small>{{ $ticket->created_at->diffInDays($ticket->resolved_at) }}d</small>
                                @else
                                    {{ $ticket->created_at->diffInHours(now()) }}h
                                    <br><small>Open</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $slaTarget = $ticket->priority === 'high' ? 4 : ($ticket->priority === 'medium' ? 8 : 24);
                                    $actualTime = $ticket->resolved_at ? $ticket->created_at->diffInHours($ticket->resolved_at) : $ticket->created_at->diffInHours(now());
                                    $slaStatus = $actualTime <= $slaTarget ? 'good' : 'warning';
                                @endphp
                                <span class="sla-{{ $slaStatus }}">
                                    @if($slaStatus === 'good')
                                        ✓
                                    @else
                                        ⚠
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($ticket->satisfaction_rating)
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $ticket->satisfaction_rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Performance Analytics --}}
        <div class="ticket-analytics">
            <h3>Performance Analytics</h3>
            @php
                $statusCounts = $tickets->groupBy('status')->map->count();
                $priorityCounts = $tickets->groupBy('priority')->map->count();
                $avgResolutionByPriority = $tickets->where('resolved_at', '!=', null)->groupBy('priority')->map(function($group) {
                    return $group->avg(function($ticket) {
                        return $ticket->created_at->diffInHours($ticket->resolved_at);
                    });
                });
            @endphp
            
            <div class="analytics-item">
                <span><strong>Resolution Rate:</strong></span>
                <span>{{ number_format(($summary['resolved_tickets'] / max($summary['total_tickets'], 1)) * 100, 1) }}%</span>
            </div>
            
            <div class="analytics-item">
                <span><strong>High Priority Resolution Time:</strong></span>
                <span>{{ number_format($avgResolutionByPriority->get('high', 0), 1) }} hours</span>
            </div>
            
            <div class="analytics-item">
                <span><strong>Medium Priority Resolution Time:</strong></span>
                <span>{{ number_format($avgResolutionByPriority->get('medium', 0), 1) }} hours</span>
            </div>
            
            <div class="analytics-item">
                <span><strong>Low Priority Resolution Time:</strong></span>
                <span>{{ number_format($avgResolutionByPriority->get('low', 0), 1) }} hours</span>
            </div>
            
            <div class="analytics-item">
                <span><strong>Most Active Agent:</strong></span>
                <span>{{ $tickets->groupBy('assigned_to')->sortByDesc(function($group) { return $group->count(); })->keys()->first() ? $tickets->where('assigned_to', $tickets->groupBy('assigned_to')->sortByDesc(function($group) { return $group->count(); })->keys()->first())->first()->assignedTo->name ?? 'N/A' : 'N/A' }}</span>
            </div>
            
            <div class="analytics-item">
                <span><strong>Peak Activity Day:</strong></span>
                <span>{{ $tickets->groupBy(function($ticket) { return $ticket->created_at->format('l'); })->sortByDesc(function($group) { return $group->count(); })->keys()->first() ?? 'N/A' }}</span>
            </div>
            
            {{-- <div class="analytics-item">
                <span><strong>Escalation Rate:</strong></span>
                <span>{{ number_format(($summary['escalated_tickets'] / max($summary['total_tickets'], 1)) * 100, 1) }}%</span>
            </div> --}}
            
            <div class="analytics-item">
                <span><strong>Customer Satisfaction Rate:</strong></span>
                <span>{{ $summary['avg_customer_satisfaction'] > 0 ? number_format($summary['avg_customer_satisfaction'], 1) . '/5.0' : 'No ratings' }}</span>
            </div>
        </div>
    @endif

    <div class="footer">
        <div class="footer-grid">
            <div>Report Generated: {{ now()->format('M d, Y H:i:s T') }}</div>
            <div>Page 1 of 1</div>
        </div>
        <p>This report contains confidential customer support information. Handle with care and ensure secure storage.</p>
    </div>
</x-pdf-layout>