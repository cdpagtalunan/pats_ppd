<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialProcessMachine extends Model
{
    use HasFactory;

    protected $table = "material_process_machines";
    protected $connection = "mysql";
}
