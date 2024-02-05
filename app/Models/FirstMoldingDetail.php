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

    // public function firstMoldingDetailMods(){
    //     return $this->hasMany(FirstMoldingDetailMod::class)->whereNull('deleted_at');
    // }
    // public function defectsInfo(){
    //     return $this->hasOne(defectsInfo::class)->whereNull('deleted_at');
    // }

}
