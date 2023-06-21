<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function getAllTickets()
    {
        return Ticket::all();
    }

    public function createTicket($requestData, $creatorId)
    {
        $ticket = new Ticket();
        $ticket->title = $requestData['title'];
        $ticket->description = $requestData['description'];
        $ticket->type = $requestData['type'];
        $ticket->creator_id = $creatorId;
        $ticket->respond_id = null;
        $ticket->save();

        return $ticket;
    }

    public function getTicketById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function getAllAdminTickets()
    {
        return Ticket::all();
    }

    public function updateTicketStatus($id, $status)
    {
        try {
            $ticket = Ticket::findOrFail($id);

            $ticket->status = $status;
            $ticket->save();

            return true;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return false;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
