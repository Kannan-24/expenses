<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Services\SupportTicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');
        
        $filters = $request->only([
            'user_id', 'show_deleted', 'search', 'filter', 
            'start_date', 'end_date', 'status', 'per_page'
        ]);
        
        // Map 'user' parameter to 'user_id' for consistency
        if ($request->has('user')) {
            $filters['user_id'] = $request->input('user');
        }

        $supportTickets = $this->supportTicketService->getPaginatedSupportTickets(
            $user->id, 
            $isAdmin, 
            $filters
        );

        // For admin, get users for filter dropdown
        $users = $isAdmin ? $this->supportTicketService->getAllUsers() : collect();

        return view('support_tickets.index', compact('supportTickets', 'users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('request support')) {
            abort(403, 'You do not have permission to create a support ticket.');
        }

        return view('support_tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('request support')) {
            abort(403, 'You do not have permission to create a support ticket.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $supportTicket = $this->supportTicketService->createSupportTicket(
                Auth::id(), 
                $request->only(['subject', 'message'])
            );

            return redirect()->route('support_tickets.index')
                ->with('success', 'Support ticket created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create support ticket: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        try {
            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $supportTicket = $this->supportTicketService->getSupportTicketWithMessages($supportTicket);

            return view('support_tickets.show', compact('supportTicket'));
        } catch (\Exception $e) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'You do not have permission to view this support ticket.');
        }
    }

    /**
     * Add a message to the support ticket.
     */
    public function reply(Request $request, SupportTicket $supportTicket)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        try {
            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);

            $request->validate([
                'message' => 'required|string',
            ]);

            $this->supportTicketService->addReplyToTicket(
                $supportTicket, 
                $user->id, 
                $isAdmin, 
                $request->only(['message'])
            );

            return redirect()->route('support_tickets.show', $supportTicket)
                ->with('success', 'Message added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'You do not have permission to add a message to this support ticket.');
        }
    }

    /**
     * Mark as closed.
     */
    public function markAsClosed(SupportTicket $supportTicket)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        try {
            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $this->supportTicketService->closeTicket($supportTicket);

            return redirect()->route('support_tickets.index')
                ->with('success', 'Support ticket closed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'You do not have permission to close this support ticket.');
        }
    }

    /**
     * Mark as reopened.
     */
    public function markAsReopened(SupportTicket $supportTicket)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        try {
            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $this->supportTicketService->reopenTicket($supportTicket);

            return redirect()->route('support_tickets.index')
                ->with('success', 'Support ticket reopened successfully.');
        } catch (\Exception $e) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'You do not have permission to reopen this support ticket.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $supportTicket)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        try {
            $this->supportTicketService->validateTicketOwnership($supportTicket, $user->id, $isAdmin);
            
            $this->supportTicketService->deleteTicket($supportTicket);

            return redirect()->route('support_tickets.index')
                ->with('success', 'Support ticket deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'You do not have permission to delete this support ticket.');
        }
    }

    /**
     * Recover the specified resource from storage.
     */
    public function recover(SupportTicket $supportTicket)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        if (!$isAdmin) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'You do not have permission to recover this support ticket.');
        }

        try {
            $this->supportTicketService->recoverTicket($supportTicket);

            return redirect()->route('support_tickets.index')
                ->with('success', 'Support ticket recovered successfully.');
        } catch (\Exception $e) {
            return redirect()->route('support_tickets.index')
                ->with('error', 'Failed to recover support ticket.');
        }
    }
}
