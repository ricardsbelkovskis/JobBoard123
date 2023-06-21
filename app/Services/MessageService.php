<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Purchase;

class MessageService
{
    public function storeMessage($purchaseId, $receiverId, $messageContent)
    {
        $purchase = Purchase::findOrFail($purchaseId);
        $conversation = $purchase->conversation;

        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $receiverId;
        $message->message = $messageContent;
        $message->save();

        return $message;
    }
}