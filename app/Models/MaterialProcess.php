<?php

namespace App\Models;

use App\Models\Process;
use App\Models\MaterialProcessStation;
use App\Models\MaterialProcessMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialProcess extends Model
{
    use HasFactory;

    protected $table = "material_processes";
    protected $connection = "mysql";

    public function material_details(){
        return $this->hasMany(MaterialProcessMaterial::class, 'mat_proc_id', 'id');
    }

    public function process_details(){
        return $this->hasOne(Process::class, 'id', 'process');
    }

    public function station_details(){
        return $this->hasMany(MaterialProcessStation::class, 'mat_proc_id', 'id');
    }
}
