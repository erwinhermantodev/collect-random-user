<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyRecord;

class DailyRecordController extends Controller
{
    public function index()
    {
        $dailyRecords = DailyRecord::all();
        return view('daily_records.index', compact('dailyRecords'));
    }
}
