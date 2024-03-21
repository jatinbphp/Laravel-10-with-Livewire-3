<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DevJob;
use Auth;

class JobDetail extends Component
{
    public $job;
    public $pageType = 4;
    public $similarJobs = [];
    public function mount($jobId)
    {
        if( DevJob::where('job_id', $jobId)->count() == 0) {
            abort(404);
        }
        $this->job = DevJob::with([ 'skills' => function ($query) {
               
                $query->select('tech_skills.skill_name', 'tech_skills.dev_jobs_id', 'tech_skills.years_exp', 'tech_skills.is_mandatory', 'tech_skills.category_id')->selectRaw('MIN(skills.icon) as icon')->leftJoin('skills', 'tech_skills.skill_name', '=', 'skills.display_name')->orderByRaw("tech_skills.category_id ASC, tech_skills.years_exp DESC, tech_skills.is_mandatory DESC")->groupBy('tech_skills.skill_name', 'tech_skills.dev_jobs_id', 'tech_skills.years_exp', 'tech_skills.is_mandatory', 'tech_skills.category_id');
            } ])->where('job_id', $jobId)->firstOrFail();
        $this->similarJobs = DevJob::select('title', 'job_id','date','employment_type','city','company_id', 'job_url')->with(["company" => function($query) {
                $query->select(['id', 'name', 'logo_url']);
            } ])->where("job_position", $this->job->job_position)->where("dev_exp", $this->job->dev_exp)->where("is_open", 1)->where("job_id", "!=", $this->job->job_id)->orderBy('updated_at', 'desc')->limit(8)->get()->toArray();
    }
    public function applyButtonClicked($company_id, $job_id, $page_type, $url) {
        if(Auth::check()) {
            buttonClicked($company_id, $job_id, $page_type);
            // $this->dispatch("redirectWithNewTab", $url);
        }
    }
    public function jobClicked($company_id, $job_id, $page_type, $url) {
        
        jobTitleClicked($company_id, $job_id, $page_type);
    }
    public function render()
    {
        return view('livewire.job-detail');
    }
}
