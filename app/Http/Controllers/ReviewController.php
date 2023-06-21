<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function ReviewStore(Request $request)
    {
        $request->validate([
            'content' => 'required|min:5',
        ]);

        $userId = Auth::id();

        $review = $this->reviewService->storeReview($request->all(), $userId);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
