<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstMoldingDetail extends Model
{
    use HasFactory;

    public function firstMoldingUpdateStatus(){
        return 'true';

    }
}
