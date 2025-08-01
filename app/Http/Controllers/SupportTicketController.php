<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use App\Notifications\SupportTicketCreated;
use App\Notifications\SupportTicketReplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SupportTicketController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with('user');

        // Filter by role
        if (!Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        } else {
            // For admin, allow filtering by user
            if ($userId = $request->input('user')) {
                $query->where('user_id', $userId);
            }
        }

        // Handle deleted tickets
        if ($request->boolean('show_deleted')) {
            $query->withTrashed();
        }

        // Handle search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Quick filter (last 7/15/30 days)
        if ($filter = $request->input('filter')) {
            if ($filter === '7days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($filter === '15days') {
                $query->where('created_at', '>=', now()->subDays(15));
            } elseif ($filter === '1month') {
                $query->where('created_at', '>=', now()->subMonth());
            }
        }

        // Start date filter
        if ($start = $request->input('start_date')) {
            $query->whereDate('created_at', '>=', $start);
        }

        // End date filter
        if ($end = $request->input('end_date')) {
            $query->whereDate('created_at', '<=', $end);
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $supportTickets = $query->paginate(6)->appends($request->except('page'));

        // For admin, pass users for filter dropdown
        $users = [];
        if (Auth::user()->hasRole('admin')) {
            $users = \App\Models\User::orderBy('name')->get();
        }

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

        $supportTicket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'status' => 'opened',
        ]);

        $supportTicket->messages()->create([
            'user_id' => Auth::id(),
            'is_admin' => false,
            'message' => $request->message,
        ]);

        // Notify admins about the new support ticket
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
        Notification::send($admins, new SupportTicketCreated($supportTicket));

        return redirect()->route('support_tickets.index')->with('success', 'Support ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        if (!$this->canAccessTicket($supportTicket)) {
            return redirect()->route('support_tickets.index')->with('error', 'You do not have permission to view this support ticket.');
        }

        $supportTicket->load(['messages.user']);

        return view('support_tickets.show', compact('supportTicket'));
    }

    /**
     * Add a message to the support ticket.
     */
    public function reply(Request $request, SupportTicket $supportTicket)
    {
        if (!$this->canAccessTicket($supportTicket)) {
            return redirect()->route('support_tickets.index')->with('error', 'You do not have permission to add a message to this support ticket.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $supportTicket->update([
            'status' => Auth::user()->hasRole('user') ? 'customer_replied' : 'admin_replied',
        ]);

        $supportTicket->messages()->create([
            'user_id' => Auth::id(),
            'is_admin' => Auth::user()->hasRole('admin'),
            'message' => $request->message,
        ]);

        /**
         *  Notify the ticket creator about the reply - if reply is from admin
         */
        if (Auth::user()->hasRole('admin')) {
            $supportTicket->user->notify(new SupportTicketReplied($supportTicket, $supportTicket->messages()->latest()->first(), false));
        } else if (Auth::user()->hasRole('user')) {
            // Find last replied admin
            $lastAdminMessage = $supportTicket->messages()->where('is_admin', true)->latest()->first();
            if ($lastAdminMessage) {
                $lastAdmin = User::find($lastAdminMessage->user_id);
                if ($lastAdmin) {
                    $lastAdmin->notify(new SupportTicketReplied($supportTicket, $supportTicket->messages()->latest()->first(), true));
                } else {
                    $admins = User::whereHas('roles', function ($query) {
                        $query->where('name', 'admin');
                    })->get();
                    Notification::send($admins, new SupportTicketReplied($supportTicket, $supportTicket->messages()->latest()->first(), true));
                }
            }
        }

        return redirect()->route('support_tickets.show', $supportTicket)->with('success', 'Message added successfully.');
    }

    /**
     *  Mark as closed.
     */
    public function markAsClosed(SupportTicket $supportTicket)
    {
        if (!$this->canAccessTicket($supportTicket)) {
            return redirect()->route('support_tickets.index')->with('error', 'You do not have permission to close this support ticket.');
        }

        $supportTicket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->route('support_tickets.index')->with('success', 'Support ticket closed successfully.');
    }

    /**
     *  Mark as reopened.
     */
    public function markAsReopened(SupportTicket $supportTicket)
    {
        if (!$this->canAccessTicket($supportTicket)) {
            return redirect()->route('support_tickets.index')->with('error', 'You do not have permission to reopen this support ticket.');
        }

        $supportTicket->update([
            'status' => 'opened',
            'closed_at' => null,
        ]);
        return redirect()->route('support_tickets.index')->with('success', 'Support ticket reopened successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $supportTicket)
    {
        if (!$this->canAccessTicket($supportTicket)) {
            return redirect()->route('support_tickets.index')->with('error', 'You do not have permission to delete this support ticket.');
        }

        $supportTicket->delete();

        return redirect()->route('support_tickets.index')->with('success', 'Support ticket deleted successfully.');
    }

    /**
     * Recover the specified resource from storage.
     */
    public function recover(SupportTicket $supportTicket)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('support_tickets.index')->with('error', 'You do not have permission to recover this support ticket.');
        }

        $supportTicket->restore();
        return redirect()->route('support_tickets.index')->with('success', 'Support ticket recovered successfully.');
    }

    /**
     * Check if the user can access the support ticket.
     */
    protected function canAccessTicket(SupportTicket $supportTicket)
    {
        if (Auth::user()->hasRole('admin')) {
            return true;
        }

        return $supportTicket->user_id === Auth::id();
    }
}
