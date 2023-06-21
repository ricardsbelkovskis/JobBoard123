<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TicketRequest;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $tickets = $this->ticketService->getAllTickets();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(TicketRequest $request)
    {
        $validatedData = $request->validated();
    
        $ticket = $this->ticketService->createTicket($validatedData, Auth::id());
    
        return redirect()->route('tickets.success', $ticket)
            ->with('success', 'Support ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function admin_index()
    {
        $tickets = $this->ticketService->getAllAdminTickets();

        return view('admin.tickets.tickets', compact('tickets'));
    }

    public function success(Ticket $ticket)
    {
        return view('tickets.success', compact('ticket'));
    }

    public function update_status(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required'
        ]);

        $statusUpdated = $this->ticketService->updateTicketStatus($id, $validatedData['status']);

        if ($statusUpdated) {
            return redirect()->back()->with('success', 'Status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update status');
        }
    }
}
