<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Email;
use App\Mail\UserEmailMailable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Enviar el email
        Mail::to($this->email->destinatario)
            ->send(new UserEmailMailable($this->email));

        // Actualizar estado a "enviado"
        $this->email->update(['estado' => 'enviado']);
    }
}
