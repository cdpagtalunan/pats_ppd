<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierDetails extends Model
{
    use HasFactory;
    protected $table = "carrier_details";
    protected $connection = "mysql";
}
