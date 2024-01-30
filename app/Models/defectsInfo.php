<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class defectsInfo extends Model
{
    use HasFactory;

    protected $table = "defects_infos";
    protected $connection = "mysql";
}
