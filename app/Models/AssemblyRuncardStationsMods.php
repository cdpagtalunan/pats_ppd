<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyRuncardStationsMods extends Model
{
    use HasFactory;

    protected $table = 'assembly_runcard_stations_mods';
    protected $connection = 'mysql';

    public function mode_of_defect(){
        return $this->hasMany(defectsInfo::class, 'id', 'mod_id');
    }
}
