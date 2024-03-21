<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;
    protected $table = "developers";
    protected $fillable = [
        "user_id",
        "logged_user_id",
        "first_name",
        "last_name",
        "dob",
        "city",
        "phone",
        "phone_verified",
        "email",
        "email_verified",
        "profile_image",
        "bsc",
        "idf",
        "developer_type",
        "dev_experience",
        "manager_exp",
        "title",
        "description",
        "education",
        "softskills",
        "cv_content",
        "ai_response",
        "filename",
    ];

    
    // Override the boot method to handle custom incrementing logic.
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Manually increment the custom incrementing column.
            $lastRecord = static::orderBy('user_id', 'desc')->first();
            $nextValue = $lastRecord ? $lastRecord->user_id + 1 : 231019;
            $model->user_id = $nextValue;
        });
    }
    public function developerSkills()
    {
        return $this->hasMany(DeveloperSkill::class, 'developer_id', 'id');
    }
}
