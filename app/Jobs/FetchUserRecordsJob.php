<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class FetchUserRecordsJob implements ShouldQueue
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
        Log::info('User records fetching started...');

        try {
            $response = Http::get('https://randomuser.me/api/?results=20')->json();
            foreach ($response['results'] as $userData) {
                Log::info('response :', $userData);
                if (!isset($userData['login']['password'])) {
                    Log::warning('User record missing password: ' . json_encode($userData));
                    continue; // Skip this user record
                }
                $fullName = $userData['name']['title'] . ' ' . $userData['name']['first'] . ' ' . $userData['name']['last'];


                User::updateOrCreate(['uuid' => $userData['login']['uuid']], [
                    'gender' => $userData['gender'],
                    'name' => $fullName,
                    'location' => $userData['location'],
                    'age' => $userData['dob']['age'],
                    'email' => $userData['email'] ?? null,
                    'password' => $userData['login']['password']
                ]);
                Redis::incr($userData['gender'] == 'male' ? 'male:count' : 'female:count');
            }
            Log::info('User records fetched successfully.');
        } catch (\Exception $e) {
            Log::error('Error fetching user records: ' . $e->getMessage());
        }
    }
}
