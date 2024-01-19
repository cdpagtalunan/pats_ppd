<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampingProductionHistory extends Model
{
    use HasFactory;

    protected $table = "stamping_production_histories";
    protected $connection = "mysql";
}
