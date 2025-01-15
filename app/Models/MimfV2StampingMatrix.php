<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MimfV2StampingMatrix extends Model
{
    protected $table = "mimf_v2_stamping_matrices";
    protected $connection = "mysql";

    public function stamping_pps_whse_info(){
        return $this->hasOne(TblWarehouse::class, 'id','stamping_pps_whse_id')->where('Factory', 3);
    }
}
