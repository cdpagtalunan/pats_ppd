<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblWarehouse;

class MaterialProcessMaterial extends Model
{
    use HasFactory;

    protected $table = "material_process_materials";
    protected $connection = "mysql";

    public function stamping_pps_warehouse_info(){
        return $this->hasOne(TblWarehouse::class, 'PartNumber', 'material_code');
    }

}
