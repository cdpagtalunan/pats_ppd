<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class PackingDetailsMolding extends Model
{
    use HasFactory;

    protected $table = "preliminary_packings";
    protected $connection = "mysql";

    public function user_info(){
        return $this->hasOne(User::class,'validated_by', 'employee_id');
    }
}
