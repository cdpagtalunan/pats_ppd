<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingDetails extends Model
{
    use HasFactory;
    protected $table = "receiving_details";
    protected $connection = "mysql";
}
