<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class ClearLogs extends Command
{
    protected $signature = 'log:clear';
    protected $description = 'Clear Laravel log files in storage/logs';

    public function handle(): void
    {
        $logPath = storage_path('logs');

        if (!File::exists($logPath)) {
            $this->info('Log folder not found.');
            return;
        }

        $files = File::glob($logPath . '/*.log');

        foreach ($files as $file) {
            File::delete($file);
        }

        $this->info('All Laravel log files have been cleared!');
    }
}
