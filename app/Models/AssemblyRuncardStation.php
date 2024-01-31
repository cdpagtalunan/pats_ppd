<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyRuncardStation extends Model
{
    use HasFactory;

    protected $table = 'assembly_runcard_stations';
    protected $connection = 'mysql';
}
