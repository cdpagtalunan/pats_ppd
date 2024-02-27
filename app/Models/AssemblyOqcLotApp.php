<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssemblyOqcLotAppSummary;

class AssemblyOqcLotApp extends Model
{
    use HasFactory;

    protected $table = "assembly_oqc_lot_apps";
    protected $connection = "mysql";

    public function user(){
        return $this->hasOne(User::class, 'id', 'operator_name');
    }

    public function oqc_lot_app_summ(){
        return $this->hasMany(AssemblyOqcLotAppSummary::class, 'assy_oqc_lot_app_id', 'id');
    }
}