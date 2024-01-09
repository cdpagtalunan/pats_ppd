<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcdcsActiveDocs extends Model
{
    use HasFactory;

    protected $table = 'tbl_active_docs';
    protected $connection = 'mysql_rapid_acdcs';
}
