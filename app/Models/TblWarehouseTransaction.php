<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblWarehouseTransaction extends Model
{
    use HasFactory;

    protected $table = 'tbl_WarehouseTransaction';
    protected $connection = 'mysql_rapid_pps';
}
