<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StampingIpqc;
use App\Models\OQCInspection;
use App\Models\AcdcsActiveDocs;

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
        return $this->hasOne(OQCInspection::class,'fs_productions_id','id')->where('status', '!=', 1);
    }

    public function first_stamping_history(){
        return $this->hasMany(StampingProductionHistory::class,'stamping_production_id', 'id');
    }

}
