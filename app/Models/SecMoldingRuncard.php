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

    public function fmolding_lot_eight_id(){
    	return $this->hasOne(FirstMolding::class, 'first_molding_device_id', 'lot_number_eight_first_molding_id');
    }

    public function fmolding_lot_nine_id(){
    	return $this->hasOne(FirstMolding::class, 'first_molding_device_id', 'lot_number_eight_first_molding_id');
    }
    
    public function fmolding_lot_ten_id(){
    	return $this->hasOne(FirstMolding::class, 'first_molding_device_id', 'lot_number_eight_first_molding_id');
    }

    public function second_molding_ipqc(){
    	return $this->hasOne(MoldingAssyIpqcInspection::class, 'fk_molding_assy_id', 'id');
    }

}
