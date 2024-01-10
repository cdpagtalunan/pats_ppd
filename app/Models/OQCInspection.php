<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\WbsOqcInspection;
use App\Models\StampingIpqc;

class OQCInspection extends Model
{
    protected $table = "oqc_inspections";
    protected $connection = "mysql";

    public function ipqc_info(){
        return $this->hasOne(StampingIpqc::class, 'po_number','po_no');
    }

    // public function wbs_oqc_inspection_info(){
    //     return $this->hasOne(WbsOqcInspection::class, '','');
    // }
}
