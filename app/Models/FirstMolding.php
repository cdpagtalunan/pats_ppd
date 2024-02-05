<?php

namespace App\Models;

use App\Models\FirstMoldingDevice;
use App\Models\MoldingAssyIpqcInspection;
use Illuminate\Database\Eloquent\Model;

use App\Models\FirstMoldingMaterialList;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirstMolding extends Model
{
    protected $connection = 'mysql';
    protected $table = 'first_moldings';
    
    /**
     * Get the user associated with the FirstMolding
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function firstMoldingDevice(){
        return $this->hasOne(FirstMoldingDevice::class,'id','first_molding_device_id')->whereNull('deleted_at');
    }

    // public function molding_ipqc_inspection_info(){
    //     return $this->hasOne(MoldingIpqcInspection::class,'id','fk_molding_id ');
    // }

    public function first_molding_ipqc(){
    	return $this->hasOne(MoldingAssyIpqcInspection::class, 'fk_molding_assy_id', 'id');
    }

    /**
     * Get the user associated with the FirstMolding
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function firstMoldingMaterialLists(){
        return $this->hasMany(FirstMoldingMaterialList::class,'first_molding_id','id')->whereNull('deleted_at');
    }

}
