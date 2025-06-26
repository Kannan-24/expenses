<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $supportTickets = SupportTicket::with('user')->paginate(10);
        } else {
            $supportTickets = SupportTicket::where('user_id', Auth::id())
                ->with('user')
                ->paginate(10);
        }

        return view('support_tickets.index', compact('supportTickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('support_tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    public function replay(Request $request, SupportTicket $supportTicket)
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
