<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssemblyRuncardStation;

class AssemblyRuncard extends Model
{
    use HasFactory;

    protected $table = 'assembly_runcards';
    protected $connection = 'mysql';

    public function device_details(){
    	return $this->hasOne(Device::class,'name', 'device_name');
    }

    public function assembly_runcard_station(){
        return $this->hasMany(AssemblyRuncardStation::class, 'assembly_runcards_id', 'id');
    }

    public function assembly_ipqc(){
    	return $this->hasOne(MoldingAssyIpqcInspection::class, 'fk_molding_assy_id', 'id');
    }

}
