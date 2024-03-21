<?php

namespace App\Listeners;

use App\Events\ManuallyJobAIRun;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Setting;
use App\Models\Company;
use App\Models\DevJob;
use App\Models\EducationSkill;
use App\Models\GeneralSkill;
use App\Models\TechSkill;
use App\Models\Skill;
use App\Models\SkillNotFound;
use App\Models\NotDeveloperJob;
use App\Models\DevJobsLog;
use App\Models\SeparationSkill;
use DB;
class ManuallyJobAIListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    protected $runAgainCurrentRequest = false;
    protected $newCompanyAddingInSitemap = [];
    protected $removeCompanyAddingInSitemap = [];
    protected $devJobsCategories = [];
    public function handle(ManuallyJobAIRun $jobData): void
    {
        
        $job = $jobData->job;
       
        $settings = Setting::select('value')->where("key", "ExtractDevJobsAndSkillsPrompt")->orderBy("id","asc")->first();
        
        $this->devJobsCategories = getDevJobsCategories();
        if(!empty($settings)) {
            $prompt =  [ [ "role" => "system", "content" => $settings->value ], [ "role" => "user", "content" => '' ]];
            $description = preg_replace('!\s+!', ' ', preg_replace('#<[^>]+>#', ' ', $job->full_description));

            $prompt[1]['content'] = "Job title: ".$job->title.". \n".trim(html_entity_decode(preg_replace('/[\p{C}]/u', '',strip_tags($description)), ENT_QUOTES, 'UTF-8'));
            $this->runAgainCurrentRequest = true;
            $aiResponse = azureOpenAI($prompt);
            $exception = false;
            try {
                try {
                    $this->saveJobsData($aiResponse, $job);
                    
                } catch (\Exception $innerException) {
                    
                    $exception = true;
                    
                }
                if($exception) {
                    if($this->runAgainCurrentRequest) {
                        $this->runAgainCurrentRequest = false;
                        sleep(3);
                        $aiResponse = azureOpenAI($prompt);
                        $this->saveJobsData($aiResponse, $job);
                    } else {
                        
                        $job->developer = 2;
                        $job->error_message = $innerException->getMessage();
                        $job->save();
                        $this->noOfJobsError++;
                        $this->deleteJobsData($job);
                    }
                }
            } catch (\Exception $outerException) {

                 
                $job->developer = 2;
                $job->error_message = $outerException->getMessage();
                $job->save();
                $this->deleteJobsData($job);                    

            }
        }
    }
    public function deleteJobsData($job) {
        DevJob::where("job_id", $job->job_id)->where("company_id", $job->company_id)->where("linkedin_company_id", $job->linkedin_company_id)->delete();
        TechSkill::where("job_id", $job->job_id)->delete();
        GeneralSkill::where("job_id", $job->job_id)->delete();
        EducationSkill::where("job_id", $job->job_id)->delete();
    }
    public function saveJobsData($aiResponse, $job) {
        $response = json_decode($aiResponse, true);
        
        if(isset($response['JobPosition'])) {
            if($response['JobPosition'] == "Not Developer") {
                $job->developer = 0;
                $job->error_message = null;
                $job->ai_job_desc = null;
                $job->save();
            } elseif(!in_array(trim($response['JobPosition']), $this->devJobsCategories)) {
                $this->noOfJobsError++;
               
                $job->developer = 2;
                $job->ai_job_desc = $aiResponse;
                $job->error_message = "Job position is not exit";
                $job->save();
            } else {
                $job->developer = 1;
                $job->ai_job_desc = $aiResponse;
                $job->error_message = null;
                $job->save();
               
                $devExp = null;
                $maxDevExp = null;
                $expDesc = null;
                if(!isset($response['TechLeadPos'])) {
                    $response['TechLeadPos'] = false;
                }
                if(!isset($response['ManagerPosition'])) {
                    $response['ManagerPosition'] = false;
                }
                $devExpResponse = str_replace("+", "", $response['DevExp']);
                //print_r($devExpResponse);
                if(is_numeric($devExpResponse)) {
                    $devExp = $devExpResponse;
                } else {
                    // $explodedValue = explode("-", $devExpResponse);
                    $explodedValue = preg_split('/\s+to\s+|\s*-\s*/', $devExpResponse);
                    if(is_numeric($explodedValue[0])) {
                        $devExp = trim($explodedValue[0]);
                        $maxDevExp = isset($explodedValue[1])?filter_var(trim($explodedValue[1]), FILTER_SANITIZE_NUMBER_INT):null;
                    } else {
                        $filterValue = filter_var($devExpResponse, FILTER_SANITIZE_NUMBER_INT);
                        if(is_numeric($filterValue)) {
                            $devExp = $filterValue;
                        } else {
                            $expDesc = $devExpResponse;
                        }
                    }
                }
                if(strtolower($job->employment_type) == "internship" || strtolower($expDesc) == "student" || strtolower($expDesc) == "intern") {
                    $devExp = 0;
                    $maxDevExp = null;
                }
                $managerExp = null;
                if($response['ManagerPosition']) {
                    if(isset($response['ManagerExp']) && $response['ManagerExp'] != "unknown") {
                        preg_match("/([0-9]+)/", $response['ManagerExp'], $matchesManagerExp);
                        if(isset($matchesManagerExp[0])) {
                            $managerExp = $matchesManagerExp[0];
                        }
                    }
                }

                $techLeadExp = null;
                if($response['TechLeadPos']) {
                    if(isset($response['TechLeadExp']) && $response['TechLeadExp'] != "unknown") {
                        preg_match("/([0-9]+)/", $response['TechLeadExp'], $matchesTechLeadExp);
                        if(isset($matchesTechLeadExp[0])) {
                            $techLeadExp = $matchesTechLeadExp[0];
                        }
                    }
                }
                
                $district = null;
                
                $cityDevJob = DevJob::select("district")->where("city", $job->city)->first();
                $district = isset($cityDevJob->district)?$cityDevJob->district:null;
                $devJob = DevJob::updateOrCreate([
                    "job_id" => $job->job_id,
                    'company_id' => $job->company_id,
                    'linkedin_company_id' => null,
                    ], [
                    'company_name' => $job->company_name,
                    'job_url' => null,
                    "job_type" => $job->job_type,
                    'title' => $job->title,
                    'city' => $job->city,
                    'district' => $district,
                    'date' => date("Y-m-d"),
                    'no_of_applicants' => null,
                    'employment_type' => $job->employment_type,
                    'full_description' => @$job->full_description,
                    "job_position" => $response['JobPosition'],
                    "dev_exp" => $devExp,
                    "max_dev_exp" => $maxDevExp,
                    "exp_desc" => $expDesc,
                    "is_manager_pos" => $response['ManagerPosition'],
                    "manager_exp" =>  $managerExp,
                    "is_tech_lead_pos" => $response['TechLeadPos'],
                    "tech_lead_exp" =>  $techLeadExp,
                    "is_open" =>  1,
                    "updated_at" => date('Y-m-d H:i:s'),
                ]);
                TechSkill::where("job_id", $job->job_id)->delete();
                EducationSkill::where("job_id", $job->job_id)->delete();
                GeneralSkill::where("job_id", $job->job_id)->delete();
                foreach ($response['TechSkills'] as $key => $techSkill) {
                    preg_match("/(^.*), (.*?), (.*?)$/", $techSkill, $techSkillArray);
                       
                    //$techSkillArray = explode(", ", $techSkill);
                    $name = trim($techSkillArray[1]);
                    $skillData = Skill::select("category_id", "name", "display_name")->where('name', '='  , trim($techSkillArray[1]))->first();
                    $yearsExp = null;
                    $yearsExpDesc = null;
                    if(isset($techSkillArray[3])) {
                        preg_match("/([0-9]+)/", $techSkillArray[3], $matchesYearsExp);
                        if(isset($matchesYearsExp[0])) {
                            $yearsExp = $matchesYearsExp[0];
                        } else {
                            $yearsExpDesc = $techSkillArray[3];
                        }
                    }
                    if(isset($skillData->category_id)) {
                        
                        if(!TechSkill::where("skill_name", $skillData->display_name)->where("job_id", $job->job_id)->exists()){
                            TechSkill::create([
                                "job_id" => $job->job_id,
                                "dev_jobs_id" => $devJob->id,
                                "skill_name" => $skillData->display_name,
                                "category_id" => $skillData->category_id,
                                "is_mandatory" => $techSkillArray[2],
                                "years_exp" => $yearsExp,
                                "years_exp_desc" => $yearsExpDesc
                            ]);
                        }
                    } else {
                        $separationSkillName = $name;
                        $name = str_replace([ "TCP/IP","TCP / IP", "CI/CD","CI / CD", "L2/L3","e.g."], ["TCP__IP", "TCP__IP", "CI__CD", "CI__CD", "L2__L3", "" ], $name );
                        $skillExplodeArray = multiexplode(["/"," /", " or "," (",") "," [","] ", ","], $name);
                        
                        foreach ($skillExplodeArray as &$skillExplode) {
                            if(substr(trim($skillExplode), -1) == ")" && stripos($skillExplode, "(") === false) {
                                $skillName = substr_replace(trim($skillExplode),"",-1);
                            } elseif(substr(trim($skillExplode), -1) == "]" && stripos($skillExplode, "[") === false) {
                                $skillName = substr_replace(trim($skillExplode),"",-1);
                            } else {
                                $skillName = trim($skillExplode);
                            }
                            $skillName = str_replace([ "TCP__IP", "CI__CD", "L2__L3" ], [ "TCP/IP", "CI/CD", "L2/L3"], $skillName );
                            $skillExplode = $skillName;
                            if(strtolower($skillName) != "etc.") {
                                $skillData = Skill::select("category_id", "name", "display_name")->where('name', '='  , $skillName)->first();
                                if(isset($skillData->category_id)) {
                                    $category_id = $skillData->category_id;
                                    $skillName = $skillData->display_name;
                                } else {
                                    $category_id = 12;
                                    if(SkillNotFound::where("name", $skillName)->exists()) {
                                        $skillNotFound = SkillNotFound::where("name", $skillName)->first();
                                        
                                        if (!in_array($job->job_id, explode(";", $skillNotFound->job_id))) {
                                            $skillNotFound->job_id = $skillNotFound->job_id.";".$job->job_id;
                                            $skillNotFound->save();
                                        }

                                    } else {
                                        SkillNotFound::create([
                                            "name" => $skillName,
                                            "job_id" => $job->job_id
                                        ]);
                                    }
                                    
                                }
                                if(!TechSkill::where("skill_name", $skillName)->where("job_id", $job->job_id)->exists()){
                                    TechSkill::create([
                                        "job_id" => $job->job_id,
                                        "dev_jobs_id" => $devJob->id,
                                        "skill_name" => $skillName,
                                        "category_id" => $category_id,
                                        "is_mandatory" => $techSkillArray[2],
                                        "years_exp" => $yearsExp,
                                        "years_exp_desc" => $yearsExpDesc
                                    ]);
                                }
                            }
                        }
                        if(count($skillExplodeArray) > 1) {
                            SeparationSkill::create([
                                "job_id" => $job->job_id,
                                "skill_name" => $separationSkillName,
                                "separation_skill" => implode(";", $skillExplodeArray)
                            ]);
                        }
                        
                    }
                    
                }
                foreach ($response['EducationSkills'] as $key => $educationSkill) {
                   // $educationSkillArray = explode(", ", $educationSkill);
                     preg_match("/(^.*), (.*?)$/", $educationSkill, $educationSkillArray);
                    EducationSkill::create([
                        "job_id" => $job->job_id,
                        "dev_jobs_id" => $devJob->id,
                        "skill_name" => $educationSkillArray[1],
                        "is_mandatory" => $educationSkillArray[2]
                    ]);
                }
                foreach ($response['GeneralSkills'] as $key => $generalSkill) {
                    // $generalSkillArray = explode(", ", $generalSkill);
                    preg_match("/(^.*), (.*?)$/", $generalSkill, $generalSkillArray);
                    GeneralSkill::create([
                        "job_id" => $job->job_id,
                        "dev_jobs_id" => $devJob->id,
                        "skill_name" => $generalSkillArray[1],
                        "is_mandatory" => $generalSkillArray[2]
                    ]);
                    
                }
               
                $company = Company::select("total_dev_jobs","id")->where('id', $job->company_id)->first();
                $company->total_dev_jobs = $company->total_dev_jobs + 1;
                \Log::debug($company->total_dev_jobs. " : ".$job->company_id);
                $company->save();
            }
            
        } else {
            $job->developer = 2;
            $job->save();
        }
    }

}
