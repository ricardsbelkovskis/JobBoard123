<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        $purchase = \App\Models\Purchase::findOrFail($validatedData['purchase_id']);

        $message = new Message();
        $message->conversation_id = $purchase->conversation->id;
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $validatedData['receiver_id'];
        $message->message = $validatedData['message'];
        $message->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');

    }
}
