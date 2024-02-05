<?php

namespace App\Models;

use App\Models\StampingIpqc;
use App\Models\OQCInspection;
use App\Models\AcdcsActiveDocs;
use Illuminate\Database\Eloquent\Model;
use App\Models\StampingProductionSublot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirstStampingProduction extends Model
{
    use HasFactory;

    protected $table = "stamping_productions";
    protected $connection = "mysql";

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function stamping_ipqc(){
    	return $this->hasOne(StampingIpqc::class, 'fs_productions_id', 'id');
    }

    public function oqc_inspection_info(){
        return $this->hasOne(OQCInspection::class, 'po_no', 'po_num')->orderBy('id', 'DESC');
    }

    public function oqc_details(){
        return $this->hasOne(OQCInspection::class,'fs_productions_id','id');
    }

    public function first_stamping_history(){
        return $this->hasMany(StampingProductionHistory::class,'stamping_production_id', 'id');
    }

    public function second_stamping_sublots(){
        return $this->hasMany(StampingProductionSublot::class,'stamp_prod_id', 'id');
    }

}
