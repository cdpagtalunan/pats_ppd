<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Station;
use App\Models\AssemblyRuncardStationsMods;

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

}
