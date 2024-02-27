<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblWarehouse;

class MimfStampingMatrix extends Model
{
    protected $table = "mimf_stamping_matrices";
    protected $connection = "mysql";

    public function pps_whse_info(){
        return $this->hasOne(TblWarehouse::class, 'id','pps_whse_id');
    }
}
