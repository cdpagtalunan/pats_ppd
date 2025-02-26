<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TblPoReceived;
use App\Models\PPSRequest;

class Mimf extends Model
{
    protected $table = "mimfs";
    protected $connection = "mysql";

    public function pps_po_received_info(){
        return $this->hasOne(TblPoReceived::class, 'id','pps_po_rcvd_id');
    }

    public function pps_request_info(){
        return $this->hasOne(PPSRequest::class, 'mimf_pps_request_id','id');
    }
}
