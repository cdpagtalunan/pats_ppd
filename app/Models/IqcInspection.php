<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IqcInspection extends Model
{
    use HasFactory;
    protected $table = 'iqc_inspections';

    protected $fillable = [
        'whs_transaction_id',
        'invoice_no',
        'partcode',
        'partname',
        'supplier',
        'family',
        'app_no',
        'app_no_extension',
        'die_no',
        'total_lot_qty',
        'type_of_inspection',
        'severity_of_inspection',
        'inspection_lvl',
        'aql',
        'accept',
        'reject',
        'shift',
        'time_ins_from',
        'time_ins_to',
        'inspector',
        'submission',
        'category',
        'target_lar',
        'target_dppm',
        'sampling_size',
        'lot_inspected',
        'accepted',
        'no_of_defects',
        'judgement',
        'remarks',
        // 'iqc_inspection_id',
    ];
}
