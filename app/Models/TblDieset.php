<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblWarehouse;

class TblDieset extends Model
{
    use HasFactory;

    protected $connection = 'mysql_rapid_pps';
    protected $table = 'tbl_dieset';

    public function pps_warehouse_info(){
        return $this->hasOne(TblWarehouse::class, 'MaterialType','Material')->where('Factory', 3);
    }

}
