<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table = "devices";
    protected $connection = "mysql";

    public function material_process(){
        return $this->hasMany(MaterialProcess::class, 'device_id', 'id');
    }
}
