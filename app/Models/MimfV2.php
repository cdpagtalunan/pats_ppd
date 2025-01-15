<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblPoReceived;
use App\Models\MimfPpsRequest;

class MimfV2 extends Model
{
    protected $table = "mimf_v2";
    protected $connection = "mysql";

    public function pps_po_received_info(){
        return $this->hasOne(TblPoReceived::class, 'id','pps_po_rcvd_id');
    }

    public function mimf_request_details(){
        return $this->hasMany(MimfPpsRequest::class, 'mimf_id','id')->where('logdel', 0);
    }
}
