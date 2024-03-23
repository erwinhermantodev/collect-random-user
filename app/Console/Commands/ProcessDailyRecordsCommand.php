<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessDailyRecordsJob;

class ProcessDailyRecordsCommand extends Command
{
    protected $signature = 'process:daily-records';
    protected $description = 'Process daily records';

    public function handle()
    {
        dispatch(new ProcessDailyRecordsJob());
        $this->info('Daily records processed successfully.');
    }
}
