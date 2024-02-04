<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class SecMoldingRuncard extends Model
{
    use HasFactory;

    public function device_id(){
    	return $this->hasOne(Device::class,'name', 'device_name');
    }
}
