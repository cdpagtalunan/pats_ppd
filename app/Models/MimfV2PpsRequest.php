<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PPSRequest;

class MimfV2PpsRequest extends Model
{
    protected $table = "mimf_v2_pps_requests";
    protected $connection = "mysql";

    public function rapid_pps_request_info(){
        return $this->hasOne(PPSRequest::class, 'mimf_pps_request_id','id');
    }
}
