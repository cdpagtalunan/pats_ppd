<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

}
