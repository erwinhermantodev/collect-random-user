<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Models\DailyRecord;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $totalUserCount = $users->count();
        return view('users.index', compact('users', 'totalUserCount'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $gender = $user->gender;
        $user->delete();
        Redis::decr($gender == 'male' ? 'male:count' : 'female:count');
        // Update DailyRecord here
        $this->updateDailyRecord($gender);
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function updateDailyRecord($gender)
    {
        $dailyRecord = DailyRecord::where('data', now()->toDateString())->first();
        if ($dailyRecord) {
            if ($gender == 'male') {
                $dailyRecord->decrement('male_count');
                $dailyRecord->male_avg_age = User::where('gender', 'male')->avg('age');
            } else {
                $dailyRecord->decrement('female_count');
                $dailyRecord->female_avg_age = User::where('gender', 'female')->avg('age');
            }
            $dailyRecord->save();
        }
    }
}
