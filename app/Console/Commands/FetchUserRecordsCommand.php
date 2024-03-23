<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchUserRecordsJob;
use Illuminate\Support\Facades\Log;

class FetchUserRecordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:user-records';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch user records from API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('User records fetching started...');
        dispatch(new FetchUserRecordsJob());
        $this->info('User records fetched successfully.');
    }
}
