<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnAssemblyRuncardStation extends Model
{
    use HasFactory;

    protected $table = 'cn_assembly_runcard_stations';
    protected $connection = 'mysql';
}
