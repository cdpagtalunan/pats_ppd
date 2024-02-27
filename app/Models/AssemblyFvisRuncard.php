<?php

namespace App\Models;

use App\Models\AssemblyRuncardStation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyFvisRuncard extends Model
{
    use HasFactory;

    protected $table = "assembly_fvis_runcards";
    protected $connection = "mysql";

    public function assy_runcard_station_details(){
        return $this->hasOne(AssemblyRuncardStation::class, 'id', 'prod_runcard_station_id');
    }
}
