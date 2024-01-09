<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstStampingProduction extends Model
{
    use HasFactory;

    protected $table = "first_stamping_productions";
    protected $connection = "mysql";

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
