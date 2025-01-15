<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblWarehouseTransaction;
use App\Models\MimfV2StampingMatrix;

class TblWarehouse extends Model
{
    use HasFactory;

    protected $table = 'tbl_Warehouse';
    protected $connection = 'mysql_rapid_pps';

    public function pps_warehouse_transaction_info(){
        return $this->hasMany(TblWarehouseTransaction::class, 'fkid','id')->orderBy('pkid', 'ASC');
    }

    public function stamping_info(){
        return $this->hasOne(MimfV2StampingMatrix::class, 'stamping_pps_whse_id','id')->where('logdel', 0);
    }
}
