<?php

namespace App\Models;

use App\Models\AssemblyFvisRuncard;
use App\Models\AssemblyOqcLotApp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssemblyFvi extends Model
{
    use HasFactory;

    protected $table = "assembly_fvis";
    protected $connection = "mysql";

    public function fvi_runcards(){
        return $this->hasMany(AssemblyFvisRuncard::class, 'assembly_fvis_id', 'id');
    }
    
    public function oqc_lot_app(){
        return $this->hasOne(AssemblyOqcLotApp::class, 'assy_fvi_id', 'id')->whereNull('deleted_at');
    }

}
