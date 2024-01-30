<?php

namespace App\Models;

use App\Models\FirstMoldingDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirstMolding extends Model
{
    use HasFactory;
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
    /**
     * Get the user associated with the FirstMolding
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

}
