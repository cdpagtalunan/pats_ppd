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

    protected $table = "first_stamping_productions";
    protected $connection = "mysql";

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function stamping_ipqc()
    {
    	return $this->hasOne(StampingIpqc::class, 'fs_productions_id', 'id');
    }

    public function oqc_inspection_info(){
        return $this->hasOne(OQCInspection::class, 'po_no', 'po_num');
    }

    public function acdcs_active_doc_info(){
        // return $this->hasOne(AcdcsActiveDocs::class, 'drawing_no', 'doc_no');
        return $this->hasMany(AcdcsActiveDocs::class, 'doc_no','drawing_no')->where('doc_type', 'B Drawing');
    }

    public function oqc_details(){
        return $this->hasMany(OQCInspection::class,'fs_productions_id', 'id')->where('status', 2);
    }


}
