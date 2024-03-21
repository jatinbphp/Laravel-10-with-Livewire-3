<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButtonClicked extends Model
{
    use HasFactory;
    protected $table = "button_clicked";

    protected $fillable = [
        "user_id",
        "company_id",
        "job_id",
        "page_type",
        "button_type"
    ];
}
