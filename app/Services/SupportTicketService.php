<?php

namespace App\Services;

use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\User;
use App\Notifications\SupportTicketCreated;
use App\Notifications\SupportTicketReplied;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SupportTicketService
{
    /**
     * Get paginated support tickets with filtering
     */
    public function getPaginatedSupportTickets(int $userId, bool $isAdmin, array $filters = []): LengthAwarePaginator
    {
        $query = SupportTicket::with(['user', 'messages']);

        // Apply user filter based on role
        if (!$isAdmin) {
            $query->where('user_id', $userId);
        } else {
            // For admin, allow filtering by specific user
            if (!empty($filters['user_id'])) {
                $query->where('user_id', $filters['user_id']);
            }
        }

        $this->applyFilters($query, $filters);

        $perPage = $filters['per_page'] ?? 6;
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    /**
     * Apply filters to the support ticket query
     */
    private function applyFilters($query, array $filters): void
    {
        // Handle deleted tickets
        if (!empty($filters['show_deleted']) && $filters['show_deleted']) {
            $query->withTrashed();
        }

        // Search functionality
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Quick filter (last 7/15/30 days)
        if (!empty($filters['filter'])) {
            switch ($filters['filter']) {
                case '7days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '15days':
                    $query->where('created_at', '>=', now()->subDays(15));
                    break;
                case '1month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
            }
        }

        // Date range filters
        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        // Status filter
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }

    /**
     * Get all users for admin filter dropdown
     */
    public function getAllUsers(): Collection
    {
        return User::orderBy('name')->get(['id', 'name', 'email']);
    }

    /**
     * Create a new support ticket
     */
    public function createSupportTicket(int $userId, array $data): SupportTicket
    {
        return DB::transaction(function () use ($userId, $data) {
            // Create support ticket
            $supportTicket = SupportTicket::create([
                'user_id' => $userId,
                'subject' => $data['subject'],
                'status' => 'opened',
            ]);

            // Create initial message
            $supportTicket->messages()->create([
                'user_id' => $userId,
                'is_admin' => false,
                'message' => $data['message'],
            ]);

            // Notify admins about the new support ticket
            $this->notifyAdminsOfNewTicket($supportTicket);

            return $supportTicket->fresh(['user', 'messages']);
        });
    }

    /**
     * Get support ticket with messages
     */
    public function getSupportTicketWithMessages(SupportTicket $supportTicket): SupportTicket
    {
        return $supportTicket->load(['messages.user', 'user']);
    }

    /**
     * Add a reply to support ticket
     */
    public function addReplyToTicket(SupportTicket $supportTicket, int $userId, bool $isAdmin, array $data): SupportMessage
    {
        return DB::transaction(function () use ($supportTicket, $userId, $isAdmin, $data) {
            // Update ticket status based on who is replying
            $newStatus = $isAdmin ? 'admin_replied' : 'customer_replied';
            $supportTicket->update(['status' => $newStatus]);

            // Create the message
            $message = $supportTicket->messages()->create([
                'user_id' => $userId,
                'is_admin' => $isAdmin,
                'message' => $data['message'],
            ]);

            // Send notifications
            $this->notifyAboutReply($supportTicket, $message, $isAdmin);

            return $message->fresh(['user']);
        });
    }

    /**
     * Mark support ticket as closed
     */
    public function closeTicket(SupportTicket $supportTicket): SupportTicket
    {
        $supportTicket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return $supportTicket->fresh();
    }

    /**
     * Mark support ticket as reopened
     */
    public function reopenTicket(SupportTicket $supportTicket): SupportTicket
    {
        $supportTicket->update([
            'status' => 'opened',
            'closed_at' => null,
        ]);

        return $supportTicket->fresh();
    }

    /**
     * Delete support ticket
     */
    public function deleteTicket(SupportTicket $supportTicket): void
    {
        $supportTicket->delete();
    }

    /**
     * Recover deleted support ticket
     */
    public function recoverTicket(SupportTicket $supportTicket): SupportTicket
    {
        $supportTicket->restore();
        return $supportTicket->fresh();
    }

    /**
     * Check if user can access the support ticket
     */
    public function canUserAccessTicket(SupportTicket $supportTicket, int $userId, bool $isAdmin): bool
    {
        if ($isAdmin) {
            return true;
        }

        return $supportTicket->user_id === $userId;
    }

    /**
     * Get support ticket statistics
     */
    public function getSupportTicketStats(int $userId = null, bool $isAdmin = false): array
    {
        $query = SupportTicket::query();

        // If not admin, filter by user
        if (!$isAdmin && $userId) {
            $query->where('user_id', $userId);
        }

        $totalTickets = $query->count();
        $openedTickets = $query->where('status', 'opened')->count();
        $closedTickets = $query->where('status', 'closed')->count();
        $customerRepliedTickets = $query->where('status', 'customer_replied')->count();
        $adminRepliedTickets = $query->where('status', 'admin_replied')->count();

        // Recent activity (last 30 days)
        $recentTickets = SupportTicket::where('created_at', '>=', now()->subDays(30));
        if (!$isAdmin && $userId) {
            $recentTickets->where('user_id', $userId);
        }
        $recentCount = $recentTickets->count();

        return [
            'total_tickets' => $totalTickets,
            'opened_tickets' => $openedTickets,
            'closed_tickets' => $closedTickets,
            'customer_replied_tickets' => $customerRepliedTickets,
            'admin_replied_tickets' => $adminRepliedTickets,
            'recent_tickets_30_days' => $recentCount,
            'avg_response_time' => $this->calculateAverageResponseTime($userId, $isAdmin),
        ];
    }

    /**
     * Get tickets by status
     */
    public function getTicketsByStatus(int $userId = null, bool $isAdmin = false): array
    {
        $query = SupportTicket::query();

        if (!$isAdmin && $userId) {
            $query->where('user_id', $userId);
        }

        $tickets = $query->get();

        return [
            'opened' => $tickets->where('status', 'opened')->count(),
            'customer_replied' => $tickets->where('status', 'customer_replied')->count(),
            'admin_replied' => $tickets->where('status', 'admin_replied')->count(),
            'closed' => $tickets->where('status', 'closed')->count(),
        ];
    }

    /**
     * Bulk operations on support tickets
     */
    public function bulkUpdateTickets(array $ticketIds, string $action, int $userId = null, bool $isAdmin = false): int
    {
        $query = SupportTicket::whereIn('id', $ticketIds);

        // If not admin, ensure user can only update their own tickets
        if (!$isAdmin && $userId) {
            $query->where('user_id', $userId);
        }

        $tickets = $query->get();

        return DB::transaction(function () use ($tickets, $action) {
            $updatedCount = 0;

            foreach ($tickets as $ticket) {
                switch ($action) {
                    case 'close':
                        if ($ticket->status !== 'closed') {
                            $this->closeTicket($ticket);
                            $updatedCount++;
                        }
                        break;
                    case 'reopen':
                        if ($ticket->status === 'closed') {
                            $this->reopenTicket($ticket);
                            $updatedCount++;
                        }
                        break;
                    case 'delete':
                        $this->deleteTicket($ticket);
                        $updatedCount++;
                        break;
                }
            }

            return $updatedCount;
        });
    }

    /**
     * Validate ticket ownership for non-admin users
     */
    public function validateTicketOwnership(SupportTicket $supportTicket, int $userId, bool $isAdmin): void
    {
        if (!$this->canUserAccessTicket($supportTicket, $userId, $isAdmin)) {
            throw new \Exception('Unauthorized access to this support ticket.', 403);
        }
    }

    /**
     * Notify admins about new support ticket
     */
    private function notifyAdminsOfNewTicket(SupportTicket $supportTicket): void
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        Notification::send($admins, new SupportTicketCreated($supportTicket));
    }

    /**
     * Notify about ticket reply
     */
    private function notifyAboutReply(SupportTicket $supportTicket, SupportMessage $message, bool $isAdminReply): void
    {
        if ($isAdminReply) {
            // Notify the ticket creator about admin reply
            $supportTicket->user->notify(new SupportTicketReplied($supportTicket, $message, false));
        } else {
            // Notify admins about customer reply
            $lastAdminMessage = $supportTicket->messages()->where('is_admin', true)->latest()->first();
            
            if ($lastAdminMessage) {
                $lastAdmin = User::find($lastAdminMessage->user_id);
                if ($lastAdmin) {
                    $lastAdmin->notify(new SupportTicketReplied($supportTicket, $message, true));
                } else {
                    // Fallback to all admins if specific admin not found
                    $this->notifyAllAdminsAboutReply($supportTicket, $message);
                }
            } else {
                // No previous admin interaction, notify all admins
                $this->notifyAllAdminsAboutReply($supportTicket, $message);
            }
        }
    }

    /**
     * Notify all admins about customer reply
     */
    private function notifyAllAdminsAboutReply(SupportTicket $supportTicket, SupportMessage $message): void
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        Notification::send($admins, new SupportTicketReplied($supportTicket, $message, true));
    }

    /**
     * Calculate average response time for support tickets
     */
    private function calculateAverageResponseTime(int $userId = null, bool $isAdmin = false): float
    {
        $query = SupportTicket::with('messages');

        if (!$isAdmin && $userId) {
            $query->where('user_id', $userId);
        }

        $tickets = $query->where('status', '!=', 'opened')->get();
        $totalResponseTime = 0;
        $ticketsWithResponses = 0;

        foreach ($tickets as $ticket) {
            $firstMessage = $ticket->messages()->orderBy('created_at')->first();
            $firstReply = $ticket->messages()->where('id', '>', $firstMessage->id)->orderBy('created_at')->first();

            if ($firstReply) {
                $responseTime = $firstMessage->created_at->diffInHours($firstReply->created_at);
                $totalResponseTime += $responseTime;
                $ticketsWithResponses++;
            }
        }

        return $ticketsWithResponses > 0 ? round($totalResponseTime / $ticketsWithResponses, 2) : 0;
    }
}
