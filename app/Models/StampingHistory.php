<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class StampingHistory extends Model
{
    protected $table = "stamping_histories";
    protected $connection = "mysql";
}
