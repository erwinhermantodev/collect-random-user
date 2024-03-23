<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\DailyRecord;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class ProcessDailyRecordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $maleCount = Redis::get('male:count');
            $femaleCount = Redis::get('female:count');

            if ($maleCount === null) {
                $maleCount = 0;
            }

            if ($femaleCount === null) {
                $femaleCount = 0;
            }

            DailyRecord::create([
                'data' => now()->toDateString(),
                'male_count' => $maleCount,
                'female_count' => $femaleCount,
                'male_avg_age' => User::where('gender', 'male')->avg('age'),
                'female_avg_age' => User::where('gender', 'female')->avg('age')
            ]);

            Redis::del('male:count', 'female:count');

            Log::info('Daily records processed successfully.');
        } catch (\Exception $e) {
            Log::error('Error processing daily records: ' . $e->getMessage());
        }
    }
}
