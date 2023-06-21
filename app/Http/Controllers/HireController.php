<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hire;
use App\Models\Photo;
use App\Models\Purchases;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\Product as StripeProduct;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\DB;



class HireController extends Controller
{
    public function index()
    {
        $hires = Hire::all();

        return view('hire.index', compact('hires'));
    }

    public function createForm()
    {
        return view('hire.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'time_to_finish' => 'required',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $hire = new Hire();
        $hire->title = $validatedData['title'];
        $hire->description = $validatedData['description'];
        $hire->price = $validatedData['price'];
        $hire->time_to_finish = $validatedData['time_to_finish'];
        $hire->user_id = auth()->user()->id;
        $hire->save();
    
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $product = \Stripe\Product::create([
            'name' => $hire->title,
        ]);
    
        $price = Price::create([
            'product' => $product->id,
            'unit_amount' => $hire->price * 100,
            'currency' => 'usd',
        ]);
    
        $hire->stripe_product_id = $product->id;
        $hire->stripe_price_id = $price->id;
        $hire->save();
    
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            foreach ($photos as $photo) {
                $path = $photo->store('photos', 'public');
                $hire->photos()->create(['path' => $path]);
            }
        }

        $responseData = [
            'route' => route('hire.show', $hire->id),
            'hire' => [
                'title' => $hire->title,
                'user' => [
                    'name' => $hire->user->name,
                ],
                'price' => $hire->price,
            ],
            'paymentRoute' => route('hire.payment', ['hire' => $hire->id]),
        ];
    
        return response()->json($responseData);
    }
    

    public function show(Hire $hire)
    {
        $photos = Photo::where('hire_id', $hire->id)->get();
        return view('hire.show', compact('hire', 'photos'));
    }

    public function payment(Hire $hire)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    
        $successUrl = route('hire.success', ['hire' => $hire->id]) . '?session_id={CHECKOUT_SESSION_ID}';
    
        info('Success URL: ' . $successUrl);
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $hire->stripe_price_id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => route('hire.index'),
        ]);
    
        return redirect($session->url);
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
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $productID = $hire->stripe_product_id;
        $priceID = $hire->stripe_price_id;
    
        try {
            $product = Product::retrieve($productID);

            $prices = $product->prices->data ?? [];

            $filteredPrices = array_filter($prices, function ($item) use ($priceID) {
                return $item->id !== $priceID;
            });

            $updatedPrices = [];

            foreach ($filteredPrices as $price) {
                $updatedPrices[] = $price->id;
            }

            $product->prices = $updatedPrices;
    
            $product->save();

            $price = Price::retrieve($priceID);

            $price->active = false;

            $price->save();

            $hire->delete();

            return redirect()->route('hire.index')->with('success', 'Product deleted successfully');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->route('hire.index')->with('error', 'Failed to delete product');
        }
    }
}
