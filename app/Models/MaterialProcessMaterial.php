<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialProcessMaterial extends Model
{
    use HasFactory;

    protected $table = "material_process_materials";
    protected $connection = "mysql";
}
