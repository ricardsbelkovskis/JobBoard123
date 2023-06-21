<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(MessageRequest $request)
    {
        $validatedData = $request->validated();

        $this->messageService->storeMessage(
            $validatedData['purchase_id'],
            $validatedData['receiver_id'],
            $validatedData['message']
        );

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
