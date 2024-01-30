<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnAssemblyRuncard extends Model
{
    use HasFactory;

    protected $table = 'cn_assembly_runcards';
    protected $connection = 'mysql';
}
