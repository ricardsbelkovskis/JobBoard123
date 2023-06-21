<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $tickets=Ticket::all();
    
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);
    
        $ticket = new Ticket();
        $ticket->title = $request->input('title');
        $ticket->description = $request->input('description');
        $ticket->type = $request->input('type');
        $ticket->creator_id = auth()->id();
        $ticket->respond_id = null; // Initially, no admin has responded
        $ticket->save();
    
        return redirect()->route('tickets.success', $ticket)->with('success', 'Support ticket created successfully.');
    }
    

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function admin_index()
    {
        $tickets = Ticket::all();

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
    
        try {
            $ticket = Ticket::findOrFail($id);
    
            $ticket->status = $validatedData['status'];
            $ticket->save();
    
            return redirect()->back()->with('success', 'Status updated successfully!');
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->with('error', 'Record not found');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Failed to update status');
        }
    }
}
