<?php

namespace App\Models;

use App\Models\MpHeater;
use App\Models\MpEjector;
use App\Models\MpSupport;
use App\Models\MpMoldOpen;
use App\Models\MpMoldClose;
use App\Models\MpInjectionTab;
use App\Models\MpInjectionVelocity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MachineParameter extends Model
{
    use HasFactory;
    public function mold_close(){
        return $this->hasOne(MpMoldClose::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }

    public function ejector_lub(){
        return $this->hasOne(MpEjector::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }

    public function mold_open(){
        return $this->hasOne(MpMoldOpen::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }

    public function heater(){
        return $this->hasOne(MpHeater::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }

    public function injection_velocity(){
        return $this->hasOne(MpInjectionVelocity::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }

    public function injection_tab(){
        return $this->hasOne(MpInjectionTab::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }

    public function support(){
        return $this->hasOne(MpSupport::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }
    public function setup(){
        return $this->hasOne(MpSetup::class, 'machine_parameter_id', 'id')->where('deleted_at');
    }
}
