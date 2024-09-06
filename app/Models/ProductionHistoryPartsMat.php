<?php

namespace App\Models;

use App\Models\FirstMolding;
use App\Models\SecMoldingRuncard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionHistoryPartsMat extends Model
{
    use HasFactory;

    protected $table = "production_history_parts_mats";
    protected $connection = "mysql";

    public function first_molding(){
        return $this->hasOne(FirstMolding::class,'id','first_molding_device_id')->whereNull('deleted_at');
    }
    public function sec_molding_runcard(){
        return $this->hasOne(SecMoldingRuncard::class,'id','first_molding_device_id')->whereNull('deleted_at');
    }
}
