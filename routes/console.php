<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\FetchUserRecordsJob;
use App\Jobs\ProcessDailyRecordsJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('fetch:user-records', function () {
    $this->info('Fetching user records...');
    dispatch(new FetchUserRecordsJob());
})->everyMinute();

Artisan::command('process:daily-records', function () {
    $this->info('Processing daily records...');
    dispatch(new ProcessDailyRecordsJob());
})->dailyAt('23:59');