<?php

namespace App\Models;

use App\Models\Station;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialProcessStation extends Model
{
    use HasFactory;
    protected $table = "material_process_stations";
    protected $connection = "mysql";

    public function stations(){
        return $this->hasOne(Station::class, 'id', 'station_id');
    }
}
