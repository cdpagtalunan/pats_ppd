<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstMoldingMaterialList extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "first_molding_material_lists";
}
