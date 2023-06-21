<?php

namespace App\Services;

use App\Models\Review;
use App\Models\User;

class PublicProfileService
{
    public function getIndexData($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            abort(404);
        }

        $reviews = Review::all();

        return [
            'user' => $user,
            'reviews' => $reviews,
        ];
    }
}
