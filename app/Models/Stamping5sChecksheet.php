<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamping5sChecksheet extends Model
{
    use HasFactory;
    protected $table = "stamping5s_checksheets";
    protected $connection = "mysql";
}
