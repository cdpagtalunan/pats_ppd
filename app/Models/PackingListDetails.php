<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingListDetails extends Model
{
    use HasFactory;
    protected $table = "packing_list_details";
    protected $connection = "mysql";
}
