<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FirstMoldingDetail;
use App\Models\defectsInfo;

class FirstMoldingDetailMod extends Model
{
    use HasFactory;

    public function belongsToFirstMoldingDetail(){
        return $this->belongsTo(FirstMoldingDetail::class,'first_molding_detail_id','id')->whereNull('deleted_at');
    }

    public function defectsInfo(){
        return $this->hasOne(defectsInfo::class,'id','defects_info_id');
    }
}
