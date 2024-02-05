<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OQCInspection;

class PackingDetails extends Model
{
    use HasFactory;
    protected $table = "packing_details";
    protected $connection = "mysql";

    public function user_validated_by_info(){
        return $this->hasOne(User::class, 'employee_id', 'validated_by_packer');
    }

    public function user_checked_by_info(){
        return $this->hasOne(User::class, 'employee_id', 'validated_by_qc');
    }

    public function oqc_data_info(){
        return $this->hasOne(OQCInspection::class, 'id', 'oqc_id');
    }

}
