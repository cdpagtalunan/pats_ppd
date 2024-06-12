<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueLog extends Model
{
    use HasFactory;

    protected $table = "issue_logs";
    protected $connection = "mysql";
}
