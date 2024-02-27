<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Station;
use App\Models\AssemblyRuncardStationsMods;
use App\Models\MaterialProcess;
use App\Models\MaterialProcessStation;

class AssemblyRuncardStation extends Model
{
    use HasFactory;

    protected $table = 'assembly_runcard_stations';
    protected $connection = 'mysql';

    public function user(){
        return $this->hasOne(User::class, 'id', 'operator_name');
    }

    public function station_name(){
        return $this->hasMany(Station::class, 'id', 'station');
    }

    // public function station_details(){
    //     return $this->hasMany(Station::class,'station', 'id');
    // }

    // public function material_process_station(){
    //     return $this->hasMany(MaterialProcessStation::class, 'station', 'station_id');
    // }

}
