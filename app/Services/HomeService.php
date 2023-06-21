<?php

namespace App\Services;

use App\Models\User;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\Diy;

class HomeService
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getHomeData(User $user)
    {
        $postCount = $this->userService->getUserPostCount($user);
        $favoritesCount = $this->userService->getUserFavoritesCount($user);
        $listingCount = $this->userService->getUserHiresCount($user);
        $hiredForPurchases = $this->userService->getHiredForPurchases($user);
        $reviews = Review::all();
        $growthPercentage = $this->userService->calculateGrowthPercentage($postCount);

        return [
            'user' => $user,
            'postCount' => $postCount,
            'favoritesCount' => $favoritesCount,
            'listingCount' => $listingCount,
            'growthPercentage' => $growthPercentage,
            'hiredForPurchases' => $hiredForPurchases,
            'reviews' => $reviews
        ];
    }

    public function isUserAuthorized(Purchase $purchase): bool
    {
        return $this->userService->isUserAuthorized($purchase);
    }

    public function isUserLoggedIn(): bool
    {
        return $this->userService->isUserLoggedIn();
    }

    public function isPurchaseCompleted(Purchase $purchase): bool
    {
        return $this->userService->isPurchaseCompleted($purchase);
    }

    public function updatePurchaseStatus(Purchase $purchase, string $status): void
    {
        $this->userService->updatePurchaseStatus($purchase, $status);
    }
}
