<?php

namespace App\Repositories;

use App\Models\UserCreditAllocation;
use Illuminate\Support\Facades\Auth;

class UserCreditAllocationRepository
{
    public function getCurrentUserCreditsCount()
    {
        $user = Auth::user();
        if (is_null($user)) return 0;

        $creditAllocations = $user->creditAllocations()->get();

        if ($creditAllocations->isEmpty()) return 0;

        $creditCount = $creditAllocations->reduce(
            function (int $carry, UserCreditAllocation $creditAllocation) {
                return $carry + ($creditAllocation->quantity_allocated - $creditAllocation->quantity_used);
            },
            0
        );

        return $creditCount;
    }

    public function chargeCredits(int $creditsQuantity = 0): int | false
    {
        $currentUserCreditsCount = $this->getCurrentUserCreditsCount();
        if ($currentUserCreditsCount < $creditsQuantity) return false;

        $user = Auth::user();
        if (is_null($user)) return false;

        $remainingToBeCharged = $creditsQuantity;

        $creditAllocations = $user->creditAllocations()->get();

        foreach ($creditAllocations as $creditAllocation) {
            if (($creditAllocation->quantity_allocated - $creditAllocation->quantity_used) >= $remainingToBeCharged) {
                $creditAllocation->quantity_used += $remainingToBeCharged;
                $creditAllocation->save();
                return $creditsQuantity;
            }

            $remainingToBeCharged -= ($creditAllocation->quantity_allocated - $creditAllocation->quantity_used);
            $creditAllocation->quantity_used = $creditAllocation->quantity_allocated;
            $creditAllocation->save();
        }

        if ($remainingToBeCharged > 0) return false;

        return $creditsQuantity;
    }
}