<x-html-report-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Ticket Management Report</h1>
                    <p class="text-gray-600 mb-2">
                        Comprehensive analysis of support ticket performance and resolution metrics
                    </p>
                    <p class="text-sm text-gray-500">
                        @if($dateRange[0] && $dateRange[1])
                            {{ $dateRange[0]->format('M d, Y') }} - {{ $dateRange[1]->format('M d, Y') }}
                        @else
                            All Time
                        @endif
                    </p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'pdf']) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export PDF
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'xlsx']) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Report Parameters -->
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 mb-8">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Report Parameters</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Date Range:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">
                        @if($dateRange[0] && $dateRange[1])
                            {{ $dateRange[0]->format('M d, Y') }} to {{ $dateRange[1]->format('M d, Y') }}
                        @else
                            All Time
                        @endif
                    </span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Total Tickets:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ $summary['total_tickets'] }}</span>
                </div>
                @if(isset($filters['status']))
                    <div>
                        <span class="font-medium text-gray-600">Status Filter:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ ucfirst(str_replace('_', ' ', $filters['status'])) }}</span>
                    </div>
                @endif
                @if(isset($filters['priority']))
                    <div>
                        <span class="font-medium text-gray-600">Priority Filter:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ ucfirst($filters['priority']) }}</span>
                    </div>
                @endif
                <div>
                    <span class="font-medium text-gray-600">Generated:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ now()->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-ticket-alt text-blue-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">Total Tickets</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $summary['total_tickets'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-hourglass-half text-yellow-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-600">Open Tickets</p>
                        <p class="text-2xl font-bold text-yellow-900">{{ $summary['open_tickets'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-cogs text-blue-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">In Progress</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $summary['in_progress_tickets'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-600">Resolved</p>
                        <p class="text-2xl font-bold text-green-900">{{ $summary['resolved_tickets'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-gray-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Closed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $summary['closed_tickets'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-purple-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Resolution Time</p>
                        <p class="text-xl font-bold text-purple-900">{{ number_format($summary['avg_resolution_time_hours'], 1) }}h</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Overdue Tickets</p>
                        <p class="text-xl font-bold text-red-900">{{ $summary['overdue_tickets'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-star text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Satisfaction Score</p>
                        <p class="text-xl font-bold text-yellow-700">
                            {{ $summary['avg_customer_satisfaction'] > 0 ? number_format($summary['avg_customer_satisfaction'], 1) . '/5.0' : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-level-up-alt text-orange-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Escalated Tickets</p>
                        <p class="text-xl font-bold text-orange-900">{{ $summary['escalated_tickets'] }}</p>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Ticket Insights Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                Ticket Insights
            </h3>
            <div class="space-y-3">
                @if($summary['overdue_tickets'] > 0)
                    <div class="border-l-4 border-red-500 bg-red-50 p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-red-800 font-semibold">Alert</h4>
                                <p class="text-red-700">{{ $summary['overdue_tickets'] }} ticket(s) are overdue and require immediate attention.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($summary['avg_resolution_time_hours'] > 48)
                    <div class="border-l-4 border-yellow-500 bg-yellow-50 p-4">
                        <div class="flex">
                            <i class="fas fa-clock text-yellow-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-yellow-800 font-semibold">Performance Alert</h4>
                                <p class="text-yellow-700">Average resolution time is {{ number_format($summary['avg_resolution_time_hours'], 1) }} hours. Consider workflow optimization.</p>
                            </div>
                        </div>
                    </div>
                @elseif($summary['avg_resolution_time_hours'] < 24)
                    <div class="border-l-4 border-green-500 bg-green-50 p-4">
                        <div class="flex">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-green-800 font-semibold">Excellent Performance</h4>
                                <p class="text-green-700">Average resolution time is {{ number_format($summary['avg_resolution_time_hours'], 1) }} hours - well within SLA targets.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-l-4 border-blue-500 bg-blue-50 p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-blue-800 font-semibold">Good Performance</h4>
                                <p class="text-blue-700">Average resolution time is {{ number_format($summary['avg_resolution_time_hours'], 1) }} hours - meeting SLA expectations.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($summary['avg_customer_satisfaction'] > 0)
                    <div class="border-l-4 border-{{ $summary['avg_customer_satisfaction'] >= 4 ? 'green' : ($summary['avg_customer_satisfaction'] >= 3 ? 'blue' : 'yellow') }}-500 bg-{{ $summary['avg_customer_satisfaction'] >= 4 ? 'green' : ($summary['avg_customer_satisfaction'] >= 3 ? 'blue' : 'yellow') }}-50 p-4">
                        <div class="flex">
                            <i class="fas fa-star text-{{ $summary['avg_customer_satisfaction'] >= 4 ? 'green' : ($summary['avg_customer_satisfaction'] >= 3 ? 'blue' : 'yellow') }}-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-{{ $summary['avg_customer_satisfaction'] >= 4 ? 'green' : ($summary['avg_customer_satisfaction'] >= 3 ? 'blue' : 'yellow') }}-800 font-semibold">Customer Satisfaction</h4>
                                <p class="text-{{ $summary['avg_customer_satisfaction'] >= 4 ? 'green' : ($summary['avg_customer_satisfaction'] >= 3 ? 'blue' : 'yellow') }}-700">
                                    Average rating is {{ number_format($summary['avg_customer_satisfaction'], 1) }}/5.0 - 
                                    @if($summary['avg_customer_satisfaction'] >= 4)
                                        Excellent customer experience
                                    @elseif($summary['avg_customer_satisfaction'] >= 3)
                                        Good customer experience
                                    @else
                                        Improvement needed in customer experience
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- @if($summary['escalated_tickets'] > 0)
                    <div class="border-l-4 border-orange-500 bg-orange-50 p-4">
                        <div class="flex">
                            <i class="fas fa-level-up-alt text-orange-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-orange-800 font-semibold">Escalations</h4>
                                <p class="text-orange-700">{{ $summary['escalated_tickets'] }} ticket(s) have been escalated. Review escalation patterns.</p>
                            </div>
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>

        <!-- Enhanced Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-8">
            <!-- Ticket Status Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                    Status Distribution
                </h3>
                <canvas id="statusChart" height="300"></canvas>
            </div>

            <!-- Priority Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-bar text-red-500 mr-2"></i>
                    Priority Distribution
                </h3>
                <canvas id="priorityChart" height="300"></canvas>
            </div>

            <!-- Daily Ticket Volume -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-line text-green-500 mr-2"></i>
                    Daily Ticket Volume
                </h3>
                <canvas id="volumeChart" height="300"></canvas>
            </div>
        </div>

        <!-- Additional Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Agent Performance -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-users text-purple-500 mr-2"></i>
                    Agent Performance
                </h3>
                <canvas id="agentChart" height="250"></canvas>
            </div>

            <!-- Category Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-tags text-indigo-500 mr-2"></i>
                    Category Distribution
                </h3>
                <canvas id="categoryChart" height="250"></canvas>
            </div>
        </div>

        @if(!$tickets->isEmpty())
            <!-- Detailed Ticket Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-table text-gray-600 mr-2"></i>
                        Ticket Details
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolution Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-blue-600">#{{ $ticket->id }}</div>
                                            <div class="text-sm text-gray-900">{{ Str::limit($ticket->subject, 30) }}</div>
                                            @if($ticket->priority === 'high')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                    🔥 High Priority
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-gray-900">{{ $ticket->customer->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $ticket->customer->email ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $ticket->category->color ?? '#6B7280' }}"></div>
                                            <span class="text-sm text-gray-900">{{ $ticket->category->name ?? 'General' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $ticket->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                               ($ticket->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $ticket->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($ticket->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                               ($ticket->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-gray-900">{{ $ticket->assignedTo->name ?? 'Unassigned' }}</div>
                                            <div class="text-sm text-gray-500">{{ $ticket->assignedTo->department ?? '' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticket->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->resolved_at)
                                            <div class="text-sm text-gray-900">
                                                {{ $ticket->created_at->diffInHours($ticket->resolved_at) }}h
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                ({{ $ticket->created_at->diffInDays($ticket->resolved_at) }} days)
                                            </div>
                                        @else
                                            <div class="text-sm text-orange-600">
                                                {{ $ticket->created_at->diffInHours(now()) }}h (Open)
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->satisfaction_rating)
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $ticket->satisfaction_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">No rating</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Performance Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Analytics Summary -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-analytics text-blue-500 mr-2"></i>
                        Performance Analytics
                    </h3>
                    <div class="space-y-3">
                        @php
                            $resolutionRate = ($summary['resolved_tickets'] / max($summary['total_tickets'], 1)) * 100;
                            // $escalationRate = ($summary['escalated_tickets'] / max($summary['total_tickets'], 1)) * 100;
                            $avgResolutionByPriority = $tickets->where('resolved_at', '!=', null)->groupBy('priority')->map(function($group) {
                                return $group->avg(function($ticket) {
                                    return $ticket->created_at->diffInHours($ticket->resolved_at);
                                });
                            });
                        @endphp
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Resolution Rate:</span>
                            <span class="text-sm font-bold text-green-600">{{ number_format($resolutionRate, 1) }}%</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Escalation Rate:</span>
                            <span class="text-sm font-bold text-orange-600">{{ number_format($escalationRate ?? 0, 1) }}%</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">High Priority Avg Resolution:</span>
                            <span class="text-sm font-bold text-red-600">{{ number_format($avgResolutionByPriority->get('high', 0), 1) }}h</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Medium Priority Avg Resolution:</span>
                            <span class="text-sm font-bold text-yellow-600">{{ number_format($avgResolutionByPriority->get('medium', 0), 1) }}h</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Low Priority Avg Resolution:</span>
                            <span class="text-sm font-bold text-green-600">{{ number_format($avgResolutionByPriority->get('low', 0), 1) }}h</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm font-medium text-gray-600">Most Active Agent:</span>
                            <span class="text-sm font-bold text-blue-600">
                                {{ $tickets->groupBy('assigned_to')->sortByDesc(function($group) { return $group->count(); })->keys()->first() ? $tickets->where('assigned_to', $tickets->groupBy('assigned_to')->sortByDesc(function($group) { return $group->count(); })->keys()->first())->first()->assignedTo->name ?? 'N/A' : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- SLA Performance -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-stopwatch text-green-500 mr-2"></i>
                        SLA Performance
                    </h3>
                    <div class="space-y-4">
                        @php
                            $slaCompliance = $tickets->map(function($ticket) {
                                $slaTarget = $ticket->priority === 'high' ? 4 : ($ticket->priority === 'medium' ? 8 : 24);
                                $actualTime = $ticket->resolved_at ? $ticket->created_at->diffInHours($ticket->resolved_at) : $ticket->created_at->diffInHours(now());
                                return $actualTime <= $slaTarget;
                            });
                            $slaComplianceRate = $slaCompliance->filter()->count() / max($slaCompliance->count(), 1) * 100;
                        @endphp
                        
                        <div class="text-center">
                            <div class="text-3xl font-bold text-{{ $slaComplianceRate >= 90 ? 'green' : ($slaComplianceRate >= 80 ? 'yellow' : 'red') }}-600">
                                {{ number_format($slaComplianceRate, 1) }}%
                            </div>
                            <div class="text-sm text-gray-600">SLA Compliance Rate</div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>High Priority (4h target):</span>
                                <span class="font-medium">{{ number_format($avgResolutionByPriority->get('high', 0), 1) }}h avg</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Medium Priority (8h target):</span>
                                <span class="font-medium">{{ number_format($avgResolutionByPriority->get('medium', 0), 1) }}h avg</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Low Priority (24h target):</span>
                                <span class="font-medium">{{ number_format($avgResolutionByPriority->get('low', 0), 1) }}h avg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <i class="fas fa-ticket-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Ticket Data</h3>
                <p class="text-gray-500">No tickets found for the selected filters.</p>
            </div>
        @endif
    </div>

    <script>
        // Enhanced Chart Configurations
        Chart.defaults.plugins.legend.display = true;
        Chart.defaults.plugins.legend.position = 'bottom';
        Chart.defaults.responsive = true;

        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Open', 'In Progress', 'Resolved', 'Closed'],
                datasets: [{
                    data: [
                        {{ $summary['open_tickets'] }}, 
                        {{ $summary['in_progress_tickets'] }}, 
                        {{ $summary['resolved_tickets'] }}, 
                        {{ $summary['closed_tickets'] }}
                    ],
                    backgroundColor: ['#FbbF24', '#60A5FA', '#A7F3D0', '#D1D5DB'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = {{ $summary['total_tickets'] }};
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Priority Distribution Chart
        const priorityCtx = document.getElementById('priorityChart').getContext('2d');
        const priorityData = {!! json_encode($tickets->groupBy('priority')->map->count()) !!};
        
        new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(priorityData).map(priority => priority.charAt(0).toUpperCase() + priority.slice(1)),
                datasets: [{
                    label: 'Ticket Count',
                    data: Object.values(priorityData),
                    backgroundColor: ['#EF4444', '#F59E0B', '#10B981'],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Daily Volume Chart
        const volumeCtx = document.getElementById('volumeChart').getContext('2d');
        const dailyVolume = {!! json_encode($tickets->groupBy(function($ticket) { return $ticket->created_at->format('Y-m-d'); })->map->count()->take(7)) !!};
        
        new Chart(volumeCtx, {
            type: 'line',
            data: {
                labels: Object.keys(dailyVolume),
                datasets: [{
                    label: 'Daily Tickets',
                    data: Object.values(dailyVolume),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Agent Performance Chart
        const agentCtx = document.getElementById('agentChart').getContext('2d');
        const agentData = {!! json_encode($tickets->groupBy('assignedTo.name')->map->count()->take(5)) !!};
        
        new Chart(agentCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(agentData).map(name => name || 'Unassigned'),
                datasets: [{
                    label: 'Tickets Handled',
                    data: Object.values(agentData),
                    backgroundColor: '#8B5CF6',
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = {!! json_encode($tickets->groupBy('category.name')->map->count()) !!};
        
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(categoryData).map(name => name || 'General'),
                datasets: [{
                    data: Object.values(categoryData),
                    backgroundColor: ['#6366F1', '#8B5CF6', '#EC4899', '#F59E0B', '#10B981', '#3B82F6'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</x-html-report-layout>