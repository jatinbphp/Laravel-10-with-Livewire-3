<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DevJob extends Model
{
    use HasFactory;
    protected $table = "dev_jobs";
    protected $fillable = [
        "job_id",
        'company_id',
        'linkedin_company_id',
        'company_name',
        'job_url',
        "job_type",
        'title',
        'city',
        'district',
        'date',
        'no_of_applicants',
        'employment_type',
        'full_description',
        "job_position",
        "dev_exp",
        "max_dev_exp",
        "exp_desc",
        "is_manager_pos",
        "manager_exp",
        "is_tech_lead_pos",
        "tech_lead_exp",
        "is_open",
        "closed_date",
        "promoted",
        "updated_at"
    ];
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id'); //->select("name", "logo_url","company_id")
    }
    public function skills()
    {
        return $this->hasMany(TechSkill::class, 'dev_jobs_id', 'id');
    }
    public function buttonClicked()
    {
        return $this->hasMany(ButtonClicked::class, 'job_id', 'job_id')->where('button_type', 1);
    }
    public function jobTitleClicked()
    {
        return $this->hasMany(JobTitleClicked::class, 'job_id', 'job_id');
    }
}
