<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Services\SupportTicketService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->middleware('auth:sanctum');
        $this->supportTicketService = $supportTicketService;
    }

    /**
     * Display a listing of support tickets
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');
            
            $filters = $request->only([
                'user_id', 'show_deleted', 'search', 'filter', 
                'start_date', 'end_date', 'status', 'per_page',
                'sort_by', 'sort_order'
            ]);

            $supportTickets = $this->supportTicketService->getPaginatedSupportTickets(
                $user->id, 
                $isAdmin, 
                $filters
            );

            return response()->json([
                'success' => true,
                'data' => $supportTickets,
                'message' => 'Support tickets retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve support tickets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve support tickets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all users for admin filter dropdown
     * 
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $users = $this->supportTicketService->getAllUsers();

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Users retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve users: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created support ticket
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000'
        ]);

        try {
            $user = Auth::user();
            
            if (!$user->can('request support')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to create a support ticket'
                ], 403);
            }

            $supportTicket = $this->supportTicketService->createSupportTicket(
                $user->id, 
                $request->only(['subject', 'message'])
            );

            return response()->json([
                'success' => true,
                'data' => $supportTicket,
                'message' => 'Support ticket created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create support ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create support ticket',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified support ticket with messages
     * 
     * @param SupportTicket $supportTicket
     * @return JsonResponse
     */
    public function show(SupportTicket $supportTicket): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $supportTicketWithMessages = $this->supportTicketService->getSupportTicketWithMessages($supportTicket);

            return response()->json([
                'success' => true,
                'data' => $supportTicketWithMessages,
                'message' => 'Support ticket retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve support ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve support ticket',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Add a reply to the support ticket
     * 
     * @param Request $request
     * @param SupportTicket $supportTicket
     * @return JsonResponse
     */
    public function reply(Request $request, SupportTicket $supportTicket): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:5000'
        ]);

        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);

            $message = $this->supportTicketService->addReplyToTicket(
                $supportTicket, 
                $user->id, 
                $isAdmin, 
                $request->only(['message'])
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'message' => $message,
                    'ticket' => $supportTicket->fresh(['user'])
                ],
                'message' => 'Reply added successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to add reply: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add reply',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Mark support ticket as closed
     * 
     * @param SupportTicket $supportTicket
     * @return JsonResponse
     */
    public function markAsClosed(SupportTicket $supportTicket): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $updatedTicket = $this->supportTicketService->closeTicket($supportTicket);

            return response()->json([
                'success' => true,
                'data' => $updatedTicket,
                'message' => 'Support ticket closed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to close support ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to close support ticket',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Mark support ticket as reopened
     * 
     * @param SupportTicket $supportTicket
     * @return JsonResponse
     */
    public function markAsReopened(SupportTicket $supportTicket): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $updatedTicket = $this->supportTicketService->reopenTicket($supportTicket);

            return response()->json([
                'success' => true,
                'data' => $updatedTicket,
                'message' => 'Support ticket reopened successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to reopen support ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reopen support ticket',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Remove the specified support ticket
     * 
     * @param SupportTicket $supportTicket
     * @return JsonResponse
     */
    public function destroy(SupportTicket $supportTicket): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $this->supportTicketService->deleteTicket($supportTicket);

            return response()->json([
                'success' => true,
                'message' => 'Support ticket deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete support ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete support ticket',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Recover deleted support ticket (Admin only)
     * 
     * @param SupportTicket $supportTicket
     * @return JsonResponse
     */
    public function recover(SupportTicket $supportTicket): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $recoveredTicket = $this->supportTicketService->recoverTicket($supportTicket);

            return response()->json([
                'success' => true,
                'data' => $recoveredTicket,
                'message' => 'Support ticket recovered successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to recover support ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to recover support ticket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get support ticket statistics
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getStats(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $stats = $this->supportTicketService->getSupportTicketStats(
                $user->id, 
                $isAdmin
            );

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Support ticket statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve support ticket statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve support ticket statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get tickets by status
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getTicketsByStatus(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $ticketsByStatus = $this->supportTicketService->getTicketsByStatus(
                $user->id, 
                $isAdmin
            );

            return response()->json([
                'success' => true,
                'data' => $ticketsByStatus,
                'message' => 'Tickets by status retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve tickets by status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tickets by status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk operations on support tickets
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ticket_ids' => 'required|array|min:1',
            'ticket_ids.*' => 'exists:support_tickets,id',
            'action' => 'required|in:close,reopen,delete'
        ]);

        try {
            $user = Auth::user();
            $isAdmin = $user->hasRole('admin');

            $updatedCount = $this->supportTicketService->bulkUpdateTickets(
                $request->ticket_ids,
                $request->action,
                $user->id,
                $isAdmin
            );

            return response()->json([
                'success' => true,
                'data' => ['updated_count' => $updatedCount],
                'message' => "Successfully {$request->action}d {$updatedCount} ticket(s)"
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to bulk update support tickets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to bulk update support tickets',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
