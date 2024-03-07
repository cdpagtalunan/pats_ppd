<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\WbsOqcInspection;
use App\Models\User;
use App\Models\DropdownOqcAql;
use App\Models\PackingDetails;
use App\Models\PreliminaryPacking;
use App\Models\OqcInspectionReelLot;
use App\Models\OqcInspectionPrintLot;
use App\Models\PackingDetailsMolding;
use App\Models\FirstStampingProduction;
use App\Models\DropdownOqcInspectionType;
use App\Models\OqcInspectionModeOfDefect;
use App\Models\DropdownOqcInspectionLevel;
use App\Models\DropdownOqcSeverityInspection;

class OQCInspection extends Model
{
    protected $table = "oqc_inspections";
    protected $connection = "mysql";

    // public function wbs_oqc_inspection_info(){
    //     return $this->hasOne(WbsOqcInspection::class, '','');
    // }

    public function reel_lot_oqc_inspection_details(){
        return $this->hasMany(OqcInspectionReelLot::class, 'oqc_inspection_id','id');
    }

    public function print_lot_oqc_inspection_details(){
        return $this->hasMany(OqcInspectionPrintLot::class, 'oqc_inspection_id','id');
    }

    public function mod_oqc_inspection_details(){
        return $this->hasMany(OqcInspectionModeOfDefect::class, 'oqc_inspection_id','id');
    }

    public function oqc_inspection_aql_info(){
        return $this->hasOne(DropdownOqcAql::class,'id', 'aql');
    }

    public function oqc_inspection_severity_inspection_info(){
        return $this->hasOne(DropdownOqcSeverityInspection::class,'id', 'severity_of_inspection');
    }

    public function oqc_inspection_type_info(){
        return $this->hasOne(DropdownOqcInspectionType::class,'id', 'type_of_inspection');
    }

    public function oqc_inspection_level_info(){
        return $this->hasOne(DropdownOqcInspectionLevel::class,'id', 'inspection_lvl');
    }

    public function stamping_production_info(){
        return $this->hasOne(FirstStampingProduction::class,'id', 'fs_productions_id');
    }

    public function user_info(){
        return $this->hasOne(User::class, 'employee_id', 'update_user');
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

    public function prodn_info(){
        return $this->hasOne(User::class, 'id', 'countedby');
    }
    

}
