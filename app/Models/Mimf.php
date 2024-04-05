<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblPoReceived;

class Mimf extends Model
{
    protected $table = "mimfs";
    protected $connection = "mysql";

    public function pps_po_received_info(){
        return $this->hasOne(TblPoReceived::class, 'id','pps_po_rcvd_id');
    }
}
