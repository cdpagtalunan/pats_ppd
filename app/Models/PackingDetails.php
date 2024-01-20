<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingDetails extends Model
{
    use HasFactory;
    protected $table = "packing_details";
    protected $connection = "mysql";
}
