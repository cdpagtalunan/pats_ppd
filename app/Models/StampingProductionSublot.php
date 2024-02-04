<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampingProductionSublot extends Model
{
    use HasFactory;

    protected $table = "stamping_production_sublots";
    protected $connection = "mysql";
}
