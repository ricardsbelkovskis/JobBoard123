<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\Review;

class ReviewService
{
    public function storeReview($requestData, $userId)
    {
        $purchase = Purchase::where('user_id', $userId)
            ->where('status', 'completed')
            ->first();

        $review = new Review();
        $review->user_id = $userId;
        $review->hire_id = $purchase->hire_id;
        $review->content = $requestData['content'];
        $review->save();

        return $review;
    }
}
