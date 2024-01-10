<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\User;

class StampingIpqc extends Model
{
    use HasFactory;

    protected $table = 'stamping_ipqcs';

    public function ipqc_insp_name(){
        return $this->hasOne(User::class, 'id', 'ipqc_inspector_name');
    }

    // public function first_stamping_production()
    // {
    // 	return $this->hasOne(FirstStampingProduction::class, 'po_num', 'po_number');
    // }
}
