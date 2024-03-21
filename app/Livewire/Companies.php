<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company;
use DB;

class Companies extends Component
{
    use WithPagination;
    protected $listeners = [
        'companiesSelectedCity',
        'companiesSelectedPrimarySector',
    ];
    public $showPageLength = false;
    public $showSortBy = false;
    public $defaultPerPage = 30;
    public $defaultSort = 'Open Jobs';
    public $defaultSortBy = "companies.total_dev_jobs desc, companies.name asc";
    public $defaultSortOptions = [
        'Newest' => "companies.founded desc",
        'Oldest' => "companies.founded asc",
        'Alphabetic' => "companies.name asc",
        'Open Jobs' => "companies.total_dev_jobs desc, companies.name asc"
    ];
    public $displayGridType = 'grid';
    public $cityFilter = '';
    public $characterFilter = '';
    public $perPageOptions = [
        12, 21, 30,50,100
    ];
    public $cities = [];
    public $types = [];
    public $fundingStages = [];
    public $primarySectors = [];
    public $primarySector = '';
    public $employees = [];
    public $typesName = [
        'All',
        'Israeli Tech',
        'Multinational',
        'Investors',
        'Hubs'
    ];
    public function mount()
    {
        $this->cities = Company::select('city')->where('city', "!=",'')->where('is_closed', 0)->groupBy('city')->orderBy('city', 'asc')->pluck('city')->toArray();
        $this->types = Company::select('type', DB::raw("count(*) as count"), DB::raw("0 as value"))->where('is_closed', 0)->groupBy('type')->get()->toArray();

        $this->fundingStages = Company::select('funding_stage', DB::raw("count(*) as count"), DB::raw("0 as value"))->where('funding_stage' , '!=', '')->where('is_closed', 0)->groupBy('funding_stage')->orderByRaw("FIELD(funding_stage,'Pre-Funding','Pre-Seed','Seed','A','B','C','D','E','F','G','Mature','Public','Acquired','Private') ASC")->get()->toArray();

        $this->primarySectors = Company::select(DB::raw("DISTINCT primary_sector as primary_sector"))->where('primary_sector' , '!=', '')->where('is_closed', 0)->orderBy('primary_sector', 'asc')->get()->toArray();
        $this->employees = Company::select('employees', DB::raw("count(*) as count"), DB::raw("0 as value"))->where('employees' , '!=', '')->where('is_closed', 0)->groupBy('employees')->orderByRaw("FIELD(employees,'0','1-10', '11-50', '51-200', '201-500', '500+') ASC")->get()->toArray();

    }
    
    public function companiesSelectedCity($city)
    {
       $this->cityFilter = $city;
       $this->resetPage();
    }
    public function companiesSelectedPrimarySector($primarySector)
    {
       $this->primarySector = $primarySector;
       $this->resetPage();
    }
    public function applyCharacterFilter($character)
    {
       $this->characterFilter = $character;
       $this->resetPage();
    }
    public function setPageLength($perPageOption) {
        $this->defaultPerPage = $perPageOption;
        $this->showPageLengthDropdown();
    }
    public function changeSelectedType() {
        $this->resetPage();
    }
    public function changeSelectedFundingStage() {
        $this->resetPage();
    }
    public function changeSelectedPrimarySector() {
        $this->resetPage();
    }
    public function changeSelectedEmployees() {
        $this->resetPage();
    }
    public function resetFilter() {
        $this->cityFilter = '';
        $this->characterFilter = '';
        $this->primarySector = '';
        $this->dispatch("clearCompaniesFilter");
        foreach ($this->types as &$type) {
           $type['value']=false;
        }
        foreach ($this->fundingStages as &$fundingStage) {
           $fundingStage['value']=false;
        }
        foreach ($this->employees as &$employee) {
           $employee['value']=false;
        }
        $this->resetPage();
    }
    public function showPageLengthDropdown() {
        $this->showPageLength = !$this->showPageLength;
    }
    public function setSortBy($value) {
        $this->defaultSort = $value;
        $this->defaultSortBy = $this->defaultSortOptions[$value];
        $this->resetPage();
    }
    public function showSortByDropdown() {
        $this->showSortBy = !$this->showSortBy;
    }
    
    public function render()
    {
        return view('livewire.companies', [
            'companies' => Company::select('id', 'name', 'company_id', 'description', 'city', 'logo_url', 'type', 'total_dev_jobs')->where('is_closed', 0)->when($this->cityFilter != '', function ($q) {
                return $q->where('city', $this->cityFilter);
            })->when($this->characterFilter != '', function ($q) {
                return $q->where('name', "like", $this->characterFilter."%");
            })->when($this->primarySector != '', function ($q) {
                return $q->where('primary_sector', $this->primarySector );
            })->when(in_array(true, array_column($this->types, 'value')), function($q) {
                $selected = [];
                foreach ($this->types as $type) {
                    if($type['value']) {
                        $selected[] = $type['type'];
                    }
                }
                return $q->whereIn('type', $selected);
            })->when(in_array(true, array_column($this->fundingStages, 'value')), function($q) {
                $selected = [];
                foreach ($this->fundingStages as $fundingStage) {
                    if($fundingStage['value']) {
                        $selected[] = $fundingStage['funding_stage'];
                    }
                }
                return $q->whereIn('funding_stage', $selected);
            })->when(in_array(true, array_column($this->employees, 'value')), function($q) {
                $selected = [];
                foreach ($this->employees as $employee) {
                    if($employee['value']) {
                        $selected[] = $employee['employees'];
                    }
                }
                return $q->whereIn('employees', $selected);
            })->orderByRaw($this->defaultSortBy)->paginate($this->defaultPerPage),
        ]); 
    }
}
