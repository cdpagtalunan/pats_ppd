<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EEDMSMachine extends Model
{
    use HasFactory;

    protected $table = "generallogistics";
    protected $connection = "mysql_rapid_eedms";
}
