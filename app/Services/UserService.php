<?php

namespace App\Services;

use App\Models\User;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\Diy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getUserPostCount(User $user): int
    {
        return $user->posts()->count();
    }

    public function getUserFavoritesCount(User $user): int
    {
        return $user->favorites()->count();
    }

    public function getUserHiresCount(User $user): int
    {
        return $user->hires()->count();
    }

    public function getHiredForPurchases(User $user)
    {
        return Purchase::whereHas('hire', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('hire.user')->get();
    }

    public function calculateGrowthPercentage(int $currentPostCount): float
    {
        $previousMonth = now()->subMonth();
        $previousPostCount = $this->getPostCountForMonth($previousMonth);

        if ($previousPostCount != 0) {
            return round((($currentPostCount - $previousPostCount) / $previousPostCount) * 100, 2);
        }

        return 0;
    }

    private function getPostCountForMonth($month)
    {
        return Diy::whereMonth('created_at', $month->month)->count();
    }

    public function updateUser(User $user, array $validatedData): void
    {
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->description = $validatedData['description'];

        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }

        if (isset($validatedData['avatar'])) {
            $this->updateUserAvatar($user, $validatedData['avatar']);
        }

        $user->save();
    }

    public function isUserAuthorized(Purchase $purchase): bool
    {
        return $purchase->user_id === auth()->user()->id;
    }

    public function isUserLoggedIn(): bool
    {
        return auth()->check();
    }

    public function isPurchaseCompleted(Purchase $purchase): bool
    {
        return $purchase->status === 'completed';
    }

    public function updatePurchaseStatus(Purchase $purchase, string $status): void
    {
        $purchase->status = $status;
        $purchase->save();
    }

    private function updateUserAvatar(User $user, $avatar): void
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $avatarPath = $avatar->store('avatars', 'public');
        $user->avatar = $avatarPath;
    }
}
