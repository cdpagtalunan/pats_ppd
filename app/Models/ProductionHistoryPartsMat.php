<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionHistoryPartsMat extends Model
{
    use HasFactory;

    protected $table = "production_history_parts_mats";
    protected $connection = "mysql";
}
