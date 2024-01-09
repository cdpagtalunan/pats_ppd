<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblWarehouse extends Model
{
    use HasFactory;

    protected $table = 'tbl_Warehouse';
    protected $connection = 'mysql_rapid_pps';
}
