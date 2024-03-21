<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\DevJob;
use Auth;
use DB;

class CompanyDetail extends Component
{
    public $company;
    public $jobs;
    public $pageType = 5;
    public $jobImageIgnore = true;
    public function mount($companyId)
    {
        if( Company::where('company_id', $companyId)->count() == 0) {
            abort(404);
        }
        $this->company = Company::where('company_id', $companyId)->first();

        $this->jobs = DevJob::select('dev_jobs.id', 'dev_jobs.promoted', 'dev_jobs.is_manager_pos', 'dev_jobs.job_position', 'dev_jobs.dev_exp', 'dev_jobs.max_dev_exp', 'dev_jobs.job_id', 'dev_jobs.company_name', 'dev_jobs.city', 'dev_jobs.job_url', 'dev_jobs.job_type', 'dev_jobs.date', 'dev_jobs.no_of_applicants', 'dev_jobs.full_description', 'dev_jobs.title', 'dev_jobs.employment_type', 'companies.logo_url', 'companies.name', 'companies.company_id', DB::raw("companies.id as company_seq_id"))->join('companies', 'dev_jobs.company_id', '=', 'companies.id')->with(['skills' => function ($query) {
                $query->select('tech_skills.skill_name', 'tech_skills.dev_jobs_id', 'tech_skills.years_exp', 'tech_skills.is_mandatory', 'tech_skills.category_id')
                ->selectRaw('MIN(skills.icon) as icon')
                ->join('skills', 'tech_skills.skill_name', '=', 'skills.display_name')->whereNotIn('tech_skills.category_id',[ 12 ])
                ->orderByRaw("tech_skills.is_mandatory DESC, tech_skills.years_exp DESC, tech_skills.category_id ASC")
                ->groupBy(
                    'tech_skills.skill_name',
                    'tech_skills.dev_jobs_id',
                    'tech_skills.years_exp',
                    'tech_skills.is_mandatory',
                    'tech_skills.category_id'
                );
            } ])->where('dev_jobs.company_id', $this->company->id)->where('dev_jobs.is_open', 1)->orderBy('dev_jobs.promoted', "desc")->orderBy('dev_jobs.date', "desc")->get();
    }
    
    public function applyButtonClicked($company_id, $job_id, $page_type, $url) {
        if(Auth::check()) {
            buttonClicked($company_id, $job_id, $page_type);
        }
    }
    public function jobClicked($company_id, $job_id, $page_type, $url) {
        
        jobTitleClicked($company_id, $job_id, $page_type);
    }
    public function render()
    {
        return view('livewire.company-detail');
    }
}
