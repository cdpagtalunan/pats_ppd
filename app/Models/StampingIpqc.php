<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampingIpqc extends Model
{
    use HasFactory;

    protected $table = 'stamping_ipqcs';

    public function first_stamping_production()
    {
    	return $this->hasOne(FirstStampingProduction::class, 'po_num', 'po_number');
    }
}
