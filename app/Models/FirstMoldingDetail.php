<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FirstMolding;
use App\Models\FirstMoldingDetailMod;
use App\Models\defectsInfo;



class FirstMoldingDetail extends Model
{
    use HasFactory;

    public function belongsToFirstMolding(){
        return $this->hasOne(FirstMolding::class,'id','first_molding_id')->whereNull('deleted_at');
    }

    // public function defectsInfo(){
    //     return $this->hasOne(defectsInfo::class)->whereNull('deleted_at');
    // }

}
