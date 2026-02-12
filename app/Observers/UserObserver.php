<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model_type' => 'User',
            'model_id' => $user->id,
            'old_values' => null,
            'new_values' => $user->toArray(),
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model_type' => 'User',
            'model_id' => $user->id,
            'old_values' => $user->getOriginal(),
            'new_values' => $user->getChanges(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model_type' => 'User',
            'model_id' => $user->id,
            'old_values' => $user->toArray(),
            'new_values' => null,
        ]);
    }
}
