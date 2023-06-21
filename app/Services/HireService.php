<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Hire;
use App\Models\Photo;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\DB;

class HireService
{
    public function getAllHires()
    {
        return Hire::all();
    }

    public function storeHire(Request $request)
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
        $product = Product::create([
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

        return [
            'success' => true,
            'message' => 'Hire created successfully',
            'hire' => $hire,
        ];
    }

    public function getHirePhotos(Hire $hire)
    {
        return Photo::where('hire_id', $hire->id)->get();
    }

    public function handlePayment(Hire $hire)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $successUrl = route('hire.success', ['hire' => $hire->id]) . '?session_id={CHECKOUT_SESSION_ID}';

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

    public function handleSuccessPayment(Request $request, Hire $hire)
    {
        $sessionId = $request->query('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = Session::retrieve($sessionId);

        $lineItems = Session::allLineItems($session->id, ['limit' => 1]);
        $priceId = $lineItems->data[0]->price->id;

        $hire = Hire::where('stripe_price_id', $priceId)->first();

        $purchase = new Purchase();
        $purchase->user_id = $request->user()->id;
        $purchase->hire_id = $hire->id;
        $purchase->status = 'pending';
        $purchase->stripe_session_id = $session->id;
        $purchase->save();

        return view('hire.success', compact('hire', 'session', 'purchase'));
    }

    public function deleteHire(Hire $hire)
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

            return [
                'success' => true,
                'message' => 'Hire deleted successfully.',
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'message' => 'Failed to delete product.',
            ];
        }
    }
}
