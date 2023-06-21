<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HireService;
use App\Models\Hire;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class HireController extends Controller
{
    private $hireService;

    public function __construct(HireService $hireService)
    {
        $this->hireService = $hireService;
    }

    public function index()
    {
        $hires = $this->hireService->getAllHires();

        return view('hire.index', compact('hires'));
    }

    public function createForm()
    {
        return view('hire.create');
    }

    public function store(Request $request)
    {
        $response = $this->hireService->storeHire($request);

        if (!$response['success']) {
            return response()->json($response, 422);
        }

        return response()->json($response);
    }

    public function show(Hire $hire)
    {
        $photos = $this->hireService->getHirePhotos($hire);

        return view('hire.show', compact('hire', 'photos'));
    }

    public function payment(Hire $hire)
    {
        return $this->hireService->handlePayment($hire);
    }

    public function success(Request $request, Hire $hire)
    {
        $sessionId = $request->query('session_id');
    
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = Session::retrieve($sessionId);

        info('Session ID: ' . $sessionId);

        $line_items = \Stripe\Checkout\Session::allLineItems($session->id, ['limit' => 1]);

        $hire = Hire::where('stripe_price_id', $line_items->data[0]->price->id)->first();

        $purchase = new \App\Models\Purchase();
        $purchase->user_id = $request->user()->id;
        $purchase->hire_id = $hire->id;
        $purchase->status = 'pending';
        $purchase->stripe_session_id = $session->id;
        $purchase->save();

        $conversation = new \App\Models\Conversation();
        $conversation->purchase_id = $purchase->id;
        $conversation->sender_id = auth()->user()->id;
        $conversation->receiver_id = $hire->user_id;
        $conversation->save();

        return view('hire.success', compact('hire', 'session', 'purchase'));
    }

    public function delete(Hire $hire)
    {
        $response = $this->hireService->deleteHire($hire);

        if (!$response['success']) {
            return redirect()->route('hire.index')->with('error', $response['message']);
        }

        return redirect()->route('hire.index')->with('success', $response['message']);
    }
}
