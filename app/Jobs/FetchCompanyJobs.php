<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;
use Illuminate\Support\Facades\Artisan;

class FetchCompanyJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $companyId;
    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::debug("FetchCompanyJobs start");
        \Log::debug($this->companyId);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $company = Company::find($this->companyId);
        if(!empty($company)) {
            $company->re_run_jobs = 2;
            $company->save();
            
            Artisan::call('command:linkedinjobs', [
                '--companyId' => $company->id
            ]);
        }
        \Log::debug("FetchCompanyJobs endd");
    }
}
