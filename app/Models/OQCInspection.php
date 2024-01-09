<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\WbsOqcInspection;
use App\Models\StampingIpqc;

class OQCInspection extends Model
{
    public function wbs_oqc_inspection_info(){
        return $this->hasOne(WbsOqcInspection::class, '','');
    }
}
