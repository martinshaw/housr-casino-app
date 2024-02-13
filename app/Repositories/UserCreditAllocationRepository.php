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
}