<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OQCInspection;
use App\Models\PackingDetails;
use App\Models\User;

class PreliminaryPacking extends Model
{
    use HasFactory;
    protected $table = "preliminary_packings";
    protected $connection = "mysql";

    public function oqc_info(){
        return $this->hasOne(OQCInspection::class,'id', 'oqc_id')->where('lot_inspected', 1);
    }

    public function final_packing_info(){
        return $this->hasOne(PackingDetails::class,'oqc_id', 'oqc_id');
    }

    public function user_info_prelim(){
        return $this->hasOne(User::class, 'employee_id', 'validated_by');
    }
}
