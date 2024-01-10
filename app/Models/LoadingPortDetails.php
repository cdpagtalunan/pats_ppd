<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadingPortDetails extends Model
{
    use HasFactory;
    protected $table = "loading_port_details";
    protected $connection = "mysql";
}
