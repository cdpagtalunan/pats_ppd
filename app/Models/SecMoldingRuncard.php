<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecMoldingRuncard extends Model
{
    use HasFactory;

    public function cn_assembly_runcard(){
    	return $this->hasOne(CnAssemblyRuncard::class,'sec_molding_runcard_id', 'id');
    }
}
