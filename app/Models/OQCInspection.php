<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ReelLot;
use App\Models\PrintLot;
use App\Models\ModeOfDefect;
// use App\Models\WbsOqcInspection;
use App\Models\FirstStampingProduction;
use App\Models\PackingDetails;
use App\Models\PreliminaryPacking;
use App\Models\PackingDetailsMolding;

class OQCInspection extends Model
{
    protected $table = "oqc_inspections";
    protected $connection = "mysql";

    // public function wbs_oqc_inspection_info(){
    //     return $this->hasOne(WbsOqcInspection::class, '','');
    // }

    public function reel_lot_oqc_inspection_info(){
        return $this->hasMany(ReelLot::class, 'oqc_inspection_id','id');
    }

    public function print_lot_oqc_inspection_info(){
        return $this->hasMany(PrintLot::class, 'oqc_inspection_id','id');
    }

    public function mod_oqc_inspection_info(){
        return $this->hasMany(ModeOfDefect::class, 'oqc_inspection_id','id');
    }

    public function stamping_production_info(){
        return $this->hasOne(FirstStampingProduction::class,'id', 'fs_productions_id');
    }

    public function packing_info(){
        return $this->hasOne(PackingDetails::class,'oqc_id', 'id');
    }

    public function prelim_packing_info(){
        return $this->hasOne(PreliminaryPacking::class,'oqc_id', 'id');
    }

    public function first_molding_info(){
        return $this->hasOne(PackingDetailsMolding::class,'oqc_id', 'id');
    }


}
