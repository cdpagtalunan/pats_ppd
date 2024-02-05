<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoldingAssyIpqcInspection extends Model
{
    use HasFactory;

    protected $table = 'molding_assy_ipqc_inspections';

    public function ipqc_insp_name(){
        return $this->hasOne(User::class, 'id', 'ipqc_inspector_name');
    }

    public function bdrawing_active_doc_info(){
        return $this->hasMany(AcdcsActiveDocs::class, 'doc_no','doc_no_b_drawing')->where('doc_type', 'B Drawing')->orderBy('date_time_created', 'DESC');
    }

    public function ud_drawing_active_doc_info(){
        return $this->hasMany(AcdcsActiveDocs::class, 'doc_no','doc_no_urgent_direction')->where('doc_type', 'Urgent Direction')->orderBy('date_time_created', 'DESC');
    }

    public function insp_std_drawing_active_doc_info(){
        return $this->hasMany(AcdcsActiveDocs::class, 'doc_no','doc_no_insp_standard')->where('doc_type', 'Inspection Standard')->orderBy('date_time_created', 'DESC');
    }
}
