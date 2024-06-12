<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPSRequest extends Model
{
    protected $table = "tbl_request";
    protected $connection = "mysql_rapid_pps_test";
    public $timestamps = false;
}
