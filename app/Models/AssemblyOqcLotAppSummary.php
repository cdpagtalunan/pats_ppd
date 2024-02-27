<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyOqcLotAppSummary extends Model
{
    use HasFactory;

    protected $table = "assembly_oqc_lot_app_summaries";
    protected $connection = "mysql";

    public function user(){
        return $this->hasOne(User::class, 'id', 'operator_name');
    }

    public function oqc_lot_app_summ(){
        return $this->belongsTo(AssemblyOqcLotApp::class, 'assy_oqc_lot_app_id', 'id');
    }
}
