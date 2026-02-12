<?php

namespace App\Observers;

use App\Models\Email;
use App\Models\ActivityLog;

class EmailObserver
{
    /**
     * Handle the Email "created" event.
     */
    public function created(Email $email): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model_type' => 'Email',
            'model_id' => $email->id,
            'old_values' => null,
            'new_values' => $email->toArray(),
        ]);
    }

    /**
     * Handle the Email "updated" event.
     */
    public function updated(Email $email): void
    {
        // Registrar cuando cambia de estado (no_enviado -> enviado)
        if ($email->wasChanged('estado')) {
            ActivityLog::create([
                'user_id' => $email->user_id,
                'action' => 'update',
                'model_type' => 'Email',
                'model_id' => $email->id,
                'old_values' => ['estado' => $email->getOriginal('estado')],
                'new_values' => ['estado' => $email->estado],
            ]);
        }
    }
}
