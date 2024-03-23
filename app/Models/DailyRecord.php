<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    use HasFactory;
    protected $fillable = ['data', 'male_count', 'female_count', 'male_avg_age', 'female_avg_age'];
    protected $casts = ['data' => 'date'];
}
