<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperSkill extends Model
{
    use HasFactory;
    protected $table = "developer_skills";
    protected $fillable = [
        "developer_id",
        "skill_name",
        "category_id",
        "years_exp",
    ];
}
