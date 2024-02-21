<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyChecksheet extends Model
{
    use HasFactory;

    protected $table = "monthly_checksheets";
    protected $connection = "mysql";

    public function machine_details(){
        return $this->belongsTo(StampingChecksheetMachineDropdown::class,'machine_id','id');
    }
}
