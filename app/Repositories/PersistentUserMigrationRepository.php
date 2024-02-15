<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PersistentUserMigrationRepository
{
    /**
     * @throws \Exception
     */
    public function migrateCurrentAnonymousUserToPersistentUser(
        ?string $name,
        ?string $email,
    ): void {
        if ($name === null || $email === null) {
            throw new \Exception('You must enter your name and e-mail address');
        }

        $anonymousUser = Auth::user();

        if ($anonymousUser->email !== null) {
            throw new \Exception('User is already persistent');
        }

        $persistentUser = User::firstOrNew(compact('email'), compact('name'));

        $persistentUser->save();

        $anonymousUser->creditAllocations()->update([
            'user_id' => $persistentUser->id,
        ]);

        $anonymousUser->slotsSpins()->update([
            'user_id' => $persistentUser->id,
        ]);

        Auth::logout();
    }

    public function refreshSession(): void
    {
        Auth::logout();
    }
}
