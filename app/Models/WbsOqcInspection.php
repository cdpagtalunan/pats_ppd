<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Model\OQCInspection;

class WbsOqcInspection extends Model
{
    protected $table = 'oqc_inspections';
    protected $connection = 'mysql_pmi_cn';
}
