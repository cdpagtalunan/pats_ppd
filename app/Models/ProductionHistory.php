<?php

namespace App\Models;

use App\Models\User;
use App\Models\FirstMoldingDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionHistory extends Model
{
    use HasFactory;

    protected $table = "production_histories";
    protected $connection = "mysql";

    public function operator_info(){
        return $this->hasOne(User::class, 'id', 'opt_id');
    }

    public function qc_info(){
        return $this->hasOne(User::class, 'id', 'qc_id');
    }

    public function prod_history_parts_mat_details(){
        return $this->hasMany(ProductionHistoryPartsMat::class, 'prod_history_id', 'id');
    }

    public function first_molding_device(){
        return $this->hasOne(FirstMoldingDevice::class, 'id', 'fkid_molding_devices')->whereNull('deleted_at');

    }

}
