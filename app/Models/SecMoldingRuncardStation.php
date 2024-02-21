<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecMoldingRuncardStationMod;

class SecMoldingRuncardStation extends Model
{
    use HasFactory;

    public function sec_molding_runcard_station_mods(){
        return $this->hasMany(SecMoldingRuncardStationMod::class, 'sec_molding_runcard_station_id', 'id');
    }
}
