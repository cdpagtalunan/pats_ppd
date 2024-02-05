<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\IqcInspection;

class ReceivingDetails extends Model
{
    use HasFactory;
    protected $table = "receiving_details";
    protected $connection = "mysql";

    public function iqc_info(){
        return $this->hasOne(IqcInspection::class, 'receiving_detail_id', 'id');
    }

}
