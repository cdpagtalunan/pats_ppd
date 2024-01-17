<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OQCInspection;

class StampingIpqc extends Model
{
    use HasFactory;

    protected $table = 'stamping_ipqcs';

    public function ipqc_insp_name(){
        return $this->hasOne(User::class, 'id', 'ipqc_inspector_name');
    }

}
