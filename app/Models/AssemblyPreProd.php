<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssemblyPreProd extends Model
{
    use HasFactory;

    protected $table = 'assembly_pre_prods';
    protected $connection = 'mysql';

}
