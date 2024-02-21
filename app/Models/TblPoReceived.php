<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MimfStampingMatrix;
use App\Models\TblDieset;
use App\Models\Device;

class TblPoReceived extends Model
{
    use HasFactory;

    protected $connection = 'mysql_rapid_pps';
    protected $table = 'tbl_POReceived';

    public function pps_dieset_info(){
        return $this->hasOne(TblDieset::class, 'DeviceName','ItemName');
    }

    public function matrix_info(){
        return $this->hasOne(Device::class, 'name','ItemName');
    }

    public function mimf_stamping_matrix_info(){
        return $this->hasOne(MimfStampingMatrix::class, 'item_code','ItemCode');
    }
}
