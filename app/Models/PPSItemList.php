<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPSItemList extends Model
{
    protected $table = "tbl_itemList";
    protected $connection = "mysql_rapid_pps";
    // protected $connection = "mysql_rapid_pps_test";
}
