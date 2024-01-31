<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyRuncard extends Model
{
    use HasFactory;

    protected $table = 'assembly_runcards';
    protected $connection = 'mysql';
}
