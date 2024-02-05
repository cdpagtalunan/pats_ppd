<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FirstStampingProduction;

class PackingListDetails extends Model
{
    use HasFactory;
    protected $table = "packing_list_details";
    protected $connection = "mysql";
    
    public function stamping_prod_data(){
        return $this->hasOne(FirstStampingProduction::class,'id', 'prod_id');
    }
}
