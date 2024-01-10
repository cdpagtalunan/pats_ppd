<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StampingIpqc;

class FirstStampingProduction extends Model
{
    use HasFactory;

    protected $table = "first_stamping_productions";
    protected $connection = "mysql";

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function stamping_ipqc()
    {
    	return $this->hasOne(StampingIpqc::class, 'po_number', 'po_num');
    }
}
