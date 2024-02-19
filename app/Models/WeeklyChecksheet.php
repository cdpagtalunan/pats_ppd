<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyChecksheet extends Model
{
    use HasFactory;

    protected $table = 'weekly_checksheets';
    protected $connection = 'mysql';

    public function machine_details(){
        return $this->belongsTo(StampingChecksheetMachineDropdown::class,'machine_id','id');
    }
}
