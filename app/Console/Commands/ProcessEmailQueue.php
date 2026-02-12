<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProcessEmailQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesar la cola de emails pendientes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando procesamiento de cola de emails...');
        
        // Procesar la cola de trabajos
        Artisan::call('queue:work', [
            '--stop-when-empty' => true,
            '--tries' => 3,
        ]);
        
        $this->info('Cola de emails procesada exitosamente.');
        
        return 0;
    }
}
