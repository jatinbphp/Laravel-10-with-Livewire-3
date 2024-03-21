<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DevJob;
use App\Models\District;
use App\Models\TechSkill;
use App\Models\Company;
use DB;
use Carbon\Carbon;
use Auth;
use Livewire\Attributes\Url;

class FindJob extends Component
{
    use WithPagination;
    #[Url(history: true)]
    protected $listeners = [
        'jobSelectedCity',
        'jobSelectedDistrict',
        'changeExperienceYear',
        'jobSelectedCompany',
        'jobSelectedPrimarySector',
    ];
    public $pageType = 2;
    public $showPageLength = false;
    protected $queryString = [
        'companyFilter' => ['as' => 'companyId'],
        'cityFilter' => ['as' => 'city'],
        'districtFilter' => ['as' => 'district'],
        'developerTypes',
        //'categories' => ['except' => '', 'as' => 'developer_types']
    ];
    /* Query String Filter */
    public $developerTypes = '';
    /* Query String Filter End */
    public $showSortBy = false;
    public $jobImageIgnore = false;
    public $defaultPerPage = 30;
    public $defaultSortBy = 'desc';
    public $displayGridType = 'grid';
    public $perPageOptions = [
        12, 21, 30,50,100
    ];

    public $cities = [];
    public $districts = [];
    public $cityFilter = '';
    public $districtFilter = '';
    public $experienceMinYear = 0;
    public $experienceMaxYear = 'Any';
    public $jobPostedValue = '';
    public $types = [
        [
            'job_type' => "On-site",
            'value' => false
        ],
        [
            'job_type' => "Remote",
            'value' => false
        ], 
        [
            'job_type' => "Hybrid",
            'value' => false
        ]
    ];
    public $jobsPosted = [
        [
            'title' => "Any time",
            'days' => "",
            'value' => true,
            'count' => 0,
            'date' => ''
        ],
        [
            'title' => "Last 24 hours",
            'days' => "1",
            'value' => false,
            'count' => 0,
            'date' => ''
        ],
        [
            'title' => "Last week",
            'days' => "7",
            'value' => false,
            'count' => 0,
            'date' => ''
        ], 
        [
            'title' => "Last month",
            'days' => "30",
            'value' => false,
            'count' => 0,
            'date' => ''
        ]
    ];
    public $typesCount = [];
    public $categoriesWithCount = [];
    public $categories = [];
    public $nameFilter = '';
    public $companyFilter = '';
    public $companies = [];
    public $fundingStages = [];
    public $primarySectorFilter = '';
    public $primarySectors = [];
    public $employees = [];
    public $totalJobs = 0;
    public function mount()
    {
        $this->totalJobs = DevJob::where('dev_jobs.is_open', 1)->count();
        foreach ($this->jobsPosted as &$jobPosted) {

            $jobPosted['date'] = ($jobPosted['days'] != '')?Carbon::now()->subDays($jobPosted['days'])->format("Y-m-d"):'';
            // $jobPosted['count'] = DevJob::when($jobPosted['date'] != '', function ($q) use($jobPosted) {
            //     return $q->whereDate("date", '>=', $jobPosted['date']);
            // })->where('is_open', 1)->count();
        }
        $devlopers = explode(",", $this->developerTypes);
        foreach(getDevJobsCategories() as $category) {
            $this->categories[] = [
                'job_position' => $category,
                'value' =>  in_array($category, $devlopers)?true:false
            ];
        }
        $this->categoriesWithCount = DevJob::select('job_position', DB::raw("count(*) as count"))->where('is_open', 1)->groupBy('job_position')->pluck("count","job_position")->toArray();
        $this->cities = DevJob::select('city')->where('city', "!=",'')->where('is_open', 1)->groupBy('city')->orderBy('city', 'asc')->pluck('city')->toArray();
        $this->districts = District::select("name")->orderBy('name', 'asc')->pluck('name')->toArray();

        $this->typesCount = DevJob::select('job_type', DB::raw("count(*) as count"))->where('is_open', 1)->groupBy('job_type')->pluck('count', 'job_type')->toArray();
        $this->companies = DevJob::select('dev_jobs.company_name', 'companies.company_id')->join('companies', 'dev_jobs.company_id', '=', 'companies.id')->where('dev_jobs.is_open', 1)->groupBy('company_id','company_name')->orderBy('company_name', 'asc')->get()->toArray();
        /*
        
        */
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
    public function jobSelectedCity($city)
    {
       $this->cityFilter = $city;
       $this->resetPage();
    }
    public function jobSelectedDistrict($district)
    {
       $this->districtFilter = $district;
       $this->resetPage();
    }
    public function scrollToTop() {
        $this->dispatch("scrollToTop");
    }
    public function changeSelectedType() {
        $this->resetPage();
    }
    public function changeDeveloperType($index) {
        if($this->categories[$index]['value']) {
            $this->developerTypes .= (($this->developerTypes != '')?",":'').$this->categories[$index]['job_position'];
        } else {
            $devlopers = explode(",", $this->developerTypes);
            unset($devlopers[array_search( $this->categories[$index]['job_position'], $devlopers )]);
            $this->developerTypes = implode(",", $devlopers);
        }
        $this->resetPage();
    }
    public function changeJobPosted() {
      //  dd($this->jobPostedValue );
        $this->resetPage();
    }
    public function changeSelectedFundingStage() {
        $this->resetPage();
    }
    public function changeSelectedPrimarySector() {
        $this->resetPage();
    
    }
    public function changeSelectedEmployee() {
        $this->resetPage();
    }
    public function changeExperienceYear($minYear, $maxYear) {
        $this->experienceMinYear = $minYear;
        $this->experienceMaxYear = $maxYear;
        $this->resetPage();
    }
    public function jobSelectedCompany($companyId) {
        $this->companyFilter = $companyId;
        $this->resetPage();
    }
    public function jobSelectedPrimarySector($primarySector) {
        $this->primarySectorFilter = $primarySector;
        $this->resetPage();
    }
    public function setPageLength($perPageOption) {
        $this->defaultPerPage = $perPageOption;
        $this->showPageLengthDropdown();
    }
    public function showPageLengthDropdown() {
        $this->showPageLength = !$this->showPageLength;
    }
    public function setSortBy($value) {
        $this->defaultSortBy = $value;
        $this->resetPage();
       // $this->showSortByDropdown();
    }
    public function showSortByDropdown() {
        $this->showSortBy = !$this->showSortBy;
    }
    public function searchNameText() {
        // $this->scrollToTop();
        $this->resetPage();
    }
    public function resetFilter() {
        // $this->dispatch('scrollToTop');
        $this->cityFilter = '';
        $this->districtFilter = '';
        $this->nameFilter = '';
        $this->companyFilter = '';
        $this->primarySectorFilter = '';
        $this->experienceMinYear = 0;
        $this->experienceMaxYear = 'Any';
        $this->jobPostedValue = '';
        $this->developerTypes = '';
        $this->dispatch("clearJobsFilter");
        $this->dispatch("resetRangeSlider");
        foreach ($this->categories as &$category) {
           $category['value']=false;
        }
        foreach ($this->types as &$type) {
           $type['value']=false;
        }
        // foreach ($this->jobsPosted as &$jobPosted) {
        //    $jobPosted['value']=false;
        // }
        foreach ($this->fundingStages as &$fundingStage) {
           $fundingStage['value']=false;
        }
        // foreach ($this->primarySectors as &$primarySector) {
        //    $primarySector['value']=false;
        // }
        foreach ($this->employees as &$employee) {
           $employee['value']=false;
        }
        $this->resetPage();
    }
    public function initFindInJobs()
    {

        $this->dispatch("initRangeSlider");
        
        $this->fundingStages = Company::leftJoin('dev_jobs', 'companies.id', '=', 'dev_jobs.company_id')->select('companies.funding_stage', DB::raw('COUNT(dev_jobs.id) as count'), DB::raw('0 as value'))->where('companies.funding_stage', '!=', '')->where('companies.is_closed', '=', 0)->groupBy('companies.funding_stage')->orderByRaw("FIELD(companies.funding_stage, 'Pre-Funding', 'Pre-Seed', 'Seed', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'Mature', 'Public', 'Acquired', 'Private') ASC")->get()->toArray();
       
        $this->primarySectors = Company::join('dev_jobs', 'companies.id', '=', 'dev_jobs.company_id')->select('companies.primary_sector', DB::raw('COUNT(dev_jobs.id) as count'))->where('companies.primary_sector', '!=', '')->where('companies.is_closed', '=', 0)->groupBy('companies.primary_sector')->havingRaw('COUNT(dev_jobs.id) > 0')->orderBy('primary_sector','asc')->get()->toArray(); //->get()->toArray();
        
       $this->employees = Company::select('companies.employees', DB::raw('COUNT(dev_jobs.id) as count'), DB::raw('0 as value'))->leftJoin('dev_jobs', 'companies.id', '=', 'dev_jobs.company_id')->where('companies.employees', '!=', '')->where('companies.is_closed', '=', 0)->groupBy('companies.employees')->orderByRaw("FIELD(companies.employees, '0', '1-10', '11-50', '51-200', '201-500', '500+') ASC")->get()->toArray();
        $this->dispatch("initFundingStageDropdown", $this->primarySectors);
        /*
        $this->employees = Company::select('companies.employees', DB::raw("(SELECT COUNT(dev_jobs.id) 
        FROM dev_jobs 
        WHERE dev_jobs.company_id IN (SELECT id FROM companies as cmp WHERE cmp.employees = `companies`.`employees` AND cmp.`is_closed` = 0)) as count"), DB::raw("0 as value"))->where('companies.employees' , '!=', '')->where('is_closed', 0)->groupBy('companies.employees')->orderByRaw("FIELD(employees,'0','1-10', '11-50', '51-200', '201-500', '500+') ASC")->get()->toArray(); 
        */
    }

    public function render()
    {
        
        return view('livewire.find-job', [
            'jobs' => DevJob::select('dev_jobs.id','dev_jobs.promoted', 'dev_jobs.is_manager_pos', 'dev_jobs.job_position', 'dev_jobs.dev_exp', 'dev_jobs.max_dev_exp', 'dev_jobs.job_id', 'dev_jobs.company_name', 'dev_jobs.city', 'dev_jobs.job_url', 'dev_jobs.job_type', 'dev_jobs.date', 'dev_jobs.no_of_applicants', 'dev_jobs.full_description', 'dev_jobs.title', 'dev_jobs.employment_type', 'companies.logo_url', 'companies.name', 'companies.company_id', DB::raw("companies.id as company_seq_id"))->join('companies', 'dev_jobs.company_id', '=', 'companies.id')->with(['skills' => function ($query) {
                $query->select('tech_skills.skill_name', 'tech_skills.dev_jobs_id', 'tech_skills.years_exp', 'tech_skills.is_mandatory', 'tech_skills.category_id')->selectRaw('MIN(skills.icon) as icon')->join('skills', 'tech_skills.skill_name', '=', 'skills.display_name')->whereNotIn('tech_skills.category_id',[ 12 ])->orderByRaw("tech_skills.is_mandatory DESC, tech_skills.years_exp DESC, tech_skills.category_id ASC")->groupBy( 'tech_skills.skill_name', 'tech_skills.dev_jobs_id', 'tech_skills.years_exp', 'tech_skills.is_mandatory', 'tech_skills.category_id');
            } ])->where('dev_jobs.is_open', 1)
            ->when($this->cityFilter != '', function ($q) {
                return $q->where('dev_jobs.city', $this->cityFilter);
            })->when($this->districtFilter != '', function ($q) {
                return $q->where('dev_jobs.district', $this->districtFilter);
            })->when($this->nameFilter != '', function ($q) {
                // return $q->where('dev_jobs.title', "like", "%".$this->nameFilter."%");
                return $q->where(function ($query) {
                    $query->where('dev_jobs.title', "like", "%".$this->nameFilter."%")->orWhereIn("dev_jobs.job_id", function($subquery)
                    {
                        $subquery->select('job_id')
                        ->from(with(new TechSkill)->getTable())
                        ->where('tech_skills.skill_name', "like", "%".$this->nameFilter."%");
                    });
                });
            })->when($this->companyFilter != '', function ($q) {
                return $q->where('companies.company_id', $this->companyFilter);
            })->when(($this->experienceMinYear != '0' || $this->experienceMaxYear != 'Any'), function ($mainQuery) {
                
                return $mainQuery->when(($this->experienceMaxYear == 'Any'), function ($q) {
                    return $q->where(function ($query) {
                        $query->where('dev_jobs.dev_exp', ">=", $this->experienceMinYear)->orWhere('dev_jobs.max_dev_exp', ">=", $this->experienceMinYear);
                    });
                }, function ($q) { 
                    return $q->where(function ($query) {
                        $query->where(function ($subquery) {
                            $subquery->where('dev_jobs.dev_exp', ">=", $this->experienceMinYear)->where('dev_jobs.dev_exp', "<=", $this->experienceMaxYear);
                        })->orWhere(function ($subquery) {
                            $subquery->where('dev_jobs.max_dev_exp', ">=", $this->experienceMinYear)->where('dev_jobs.max_dev_exp', "<=", $this->experienceMaxYear);
                        });
                    });
                });
                
            })->when(in_array(true, array_column($this->types, 'value')), function($q) {
                $selected = [];
                foreach ($this->types as $type) {
                    if($type['value']) {
                        $selected[] = $type['job_type'];
                    }
                }
                return $q->whereIn('dev_jobs.job_type', $selected);
            })->when(in_array(true, array_column($this->categories, 'value')), function($q) {
                $selected = [];
                foreach ($this->categories as $category) {
                    if($category['value']) {
                        $selected[] = $category['job_position'];
                    }
                }
                return $q->whereIn('dev_jobs.job_position', $selected);
            })->when($this->jobPostedValue != '', function ($q) {
                return $q->whereDate("date", '>=', $this->jobPostedValue );
            })->when(in_array(true, array_column($this->fundingStages, 'value')), function($q) {
                $selected = [];
                foreach ($this->fundingStages as $fundingStage) {
                    if($fundingStage['value']) {
                        $selected[] = $fundingStage['funding_stage'];
                    }
                }
                return $q->whereIn('companies.funding_stage', $selected);
                /* return $q->whereIn('company_id', function($query) use($selected) {
                        $query->select('id')
                        ->from(with(new Company)->getTable())
                        ->whereIn('funding_stage', $selected);
                    }); */
            })->when($this->primarySectorFilter != '', function ($q) {
                return $q->where('companies.primary_sector', $this->primarySectorFilter);
                // return $q->whereIn('company_id', function($query)  {
                //         $query->select('id')
                //         ->from(with(new Company)->getTable())
                //         ->where('primary_sector', $this->primarySectorFilter);
                //     });
            })
            ->when(in_array(true, array_column($this->employees, 'value')), function($q) {
                $selected = [];
                foreach ($this->employees as $employee) {
                    if($employee['value']) {
                        $selected[] = $employee['employees'];
                    }
                }
                return $q->whereIn('companies.employees', $selected);
                /* return $q->whereIn('company_id', function($query) use($selected) {
                        $query->select('id')
                        ->from(with(new Company)->getTable())
                        ->whereIn('employees', $selected);
                    });
                */
            })->orderBy('dev_jobs.promoted', $this->defaultSortBy)->orderBy('dev_jobs.date', $this->defaultSortBy)->paginate($this->defaultPerPage),
        ]);
    }
}
