<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FirstStampingProduction;

class StampingProductionSublot extends Model
{
    use HasFactory;

    protected $table = "stamping_production_sublots";
    protected $connection = "mysql";

    public function stamping_info(){
        return $this->hasOne(FirstStampingProduction::class, 'id', 'stamp_prod_id')->where('stamping_cat', 2);
    }
}
