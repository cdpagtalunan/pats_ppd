<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DropdownOqcAql;
use App\Models\DropdownOqcFamily;
use App\Models\DropdownOqcAssemblyLine;
use App\Models\DropdownOqcInspectionType;
use App\Models\DropdownOqcInspectionLevel;
use App\Models\DropdownOqcSeverityInspection;

class Category extends Model
{
    protected $table = "categories";
    protected $connection = "mysql";

    public function aql_info(){
        return $this->hasOne(DropdownOqcAql::class, 'id', 'category_id');
    }

    public function assembly_line_info(){
        return $this->hasOne(DropdownOqcAssemblyLine::class, 'id', 'category_id');
    }

    public function family_info(){
        return $this->hasOne(DropdownOqcFamily::class, 'id', 'category_id');
    }

    public function inspection_level_info(){
        return $this->hasOne(DropdownOqcInspectionLevel::class, 'id', 'category_id');
    }

    public function inspection_type_info(){
        return $this->hasOne(DropdownOqcInspectionType::class, 'id', 'category_id');
    }

    public function severity_inspection_info(){
        return $this->hasOne(DropdownOqcSeverityInspection::class, 'id', 'category_id');
    }
}
