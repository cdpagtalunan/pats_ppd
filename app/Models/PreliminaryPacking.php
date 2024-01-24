<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OQCInspection;

class PreliminaryPacking extends Model
{
    use HasFactory;
    protected $table = "preliminary_packings";
    protected $connection = "mysql";

    public function oqc_info(){
        return $this->hasOne(OQCInspection::class,'id', 'oqc_id')->where('lot_inspected', 1);
    }
}
