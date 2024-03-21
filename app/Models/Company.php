<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'company_id',
        'finder_url',
        'description',
        'about',
        'website_url',
        'logo_url',
        'primary_sector',
        'address',
        'city',
        'founded',
        'israel_since',
        'employees',
        'funding_stage',
        'total_funding',
        'careers_url',
        'linkedin_id',
        'type',
        'is_closed',
        'total_jobs',
        'new_jobs',
        'fetched_jobs',
        'total_dev_jobs',
        'email_address',
        'updated_at',
    ];
    public function openDevJobs()
    {
        return $this->hasMany(DevJob::class, 'company_id', 'id')->where('is_open', 1);
    }
    public function devJobs()
    {
        return $this->hasMany(DevJob::class, 'company_id', 'id');
    }
    public function buttonClicked()
    {
        return $this->hasMany(ButtonClicked::class, 'company_id', 'id');
    }
    public function jobTitleClicked()
    {
        return $this->hasMany(JobTitleClicked::class, 'company_id', 'id');
    }
    

}
