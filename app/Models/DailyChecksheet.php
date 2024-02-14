<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyChecksheet extends Model
{
    use HasFactory;
    protected $table = "daily_checksheets";
    protected $connection = "mysql";
}
