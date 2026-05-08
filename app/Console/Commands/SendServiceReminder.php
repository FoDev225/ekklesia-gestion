<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ServiceMessageGenerator;

class SendServiceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-service-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!now()->isTuesday()) return;
        
        $message = ServiceMessageGenerator::generate();
        
        if (!$message) return;

        cache()->put('whatsapp_message', $message, now()->addDays());
    }
}
