<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class PackingDetailsMolding extends Model
{
    use HasFactory;

    protected $table = "packing_details_moldings";
    protected $connection = "mysql";

    public function oqc_info(){
        return $this->hasOne(OQCInspection::class,'id', 'oqc_id')
        ->where('lot_inspected', 1)
        ->where('status', 2);
    }

    public function user_validated_by_info(){
        return $this->hasOne(User::class, 'employee_id', 'countedby');
    }

    public function user_checked_by_info(){
        return $this->hasOne(User::class, 'employee_id', 'checkedby');
    }
}
