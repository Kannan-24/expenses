<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketReportCsvExport implements FromCollection, WithHeadings, WithMapping
{
    private array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['tickets']);
    }

    public function headings(): array
    {
        return [
            'Ticket ID',
            'Subject',
            'Status',
            'Priority',
            'Category',
            'Created Date',
            'Last Updated',
            'Closed Date',
            'Customer Name',
            'Customer Email',
            'Admin Assigned',
            'Messages Count',
            'First Response Time (Hours)',
            'Resolution Time (Hours)',
            'Age (Days)',
            'Is Overdue',
            'Customer Satisfaction',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->id,
            $ticket->subject,
            $ticket->status_label,
            $ticket->priority_label,
            $ticket->category,
            $ticket->created_at->format('Y-m-d H:i:s'),
            $ticket->updated_at->format('Y-m-d H:i:s'),
            $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i:s') : null,
            $ticket->customer->name ?? 'N/A',
            $ticket->customer->email ?? 'N/A',
            $ticket->admin->name ?? 'Unassigned',
            $ticket->message_count,
            $ticket->first_response_time_hours,
            $ticket->resolution_time_hours,
            $ticket->age_in_days,
            $ticket->is_overdue ? 'Yes' : 'No',
            $ticket->customer_satisfaction,
        ];
    }
}