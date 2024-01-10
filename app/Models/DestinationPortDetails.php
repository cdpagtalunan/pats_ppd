<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationPortDetails extends Model
{
    use HasFactory;
    protected $table = "destination_port_details";
    protected $connection = "mysql";
}
