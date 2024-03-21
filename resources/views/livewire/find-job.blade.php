<div wire:init="initFindInJobs">
  <section class="section-box-2">
    <div class="container">
      <div class="banner-hero banner-single banner-single-bg">
        <div class="block-banner text-center">
          <h3 class="wow animate__animated animate__fadeInUp"><span class="color-brand-2">{{ $totalJobs }} Developer Jobs</span> Available Now</h3>
          <!-- <div class="font-sm color-text-paragraph-2 mt-10 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero repellendus magni, <br class="d-none d-xl-block">atque delectus molestias quis?</div> -->
          
        </div>
      </div>
    </div>
  </section>
  <section class="section-box mt-30">
    <div class="container">
      <div class="row flex-row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12 sidebar"  wire:ignore.self>
          <div class="sidebar-shadow none-shadow mb-30">
            <div class="sidebar-filters">
              <div class="filter-block head-border mb-30">
                <h5>Advanced Filter <a class="ml-10  close-filter sidebar-filter-button btn btn-danger mobile-close-button" onclick="showFilterPopup(this)" >Close</a>
                  <a class="mt-1 link-reset reset-filter" wire:click="resetFilter">Reset</a></h5>
              </div>
              <div class="box-loader" id="sidebarFilterLoader" style="display: none" ><img src="https://devjobs.co.il/assets/imgs/template/loading.gif" alt="DevJobs"></div>
              <div class="sidebar-filter-section">
                <div class="filter-block mb-20">
                  <div class="form-group">
                    <input type="text" onkeyup="changeNameFilter(this)" wire:model="nameFilter"  wire:keydown.enter="searchNameText" @keydown.enter="scrollToTop" class="form-control name-search-input" placeholder="Job Name or Any Skill" />
                    <i class="fi-rr-search name-search-icon {{ ($nameFilter != '')?'text-dark':'' }}" onclick="scrollToTop();" wire:click="searchNameText"></i>
                  </div>
                </div>
                <div class="filter-block mb-30">
                  <div class="form-group select-style select-style-icon" wire:ignore>
                    <select id="jobsCityDrop" class="form-control form-icons select-active" wire:model="cityFilter" onchange="changeJobsCity(this)">
                      <option value="" @if($cityFilter == '') selected="true" @endif  disabled >Choose City</option>
                      @foreach($cities as $city)
                        <option value="{{ $city }}" @if($cityFilter == $city) selected="true" @endif  >{{ $city }}</option>
                      @endforeach
                    </select><i class="fi-rr-marker"></i>
                  </div>
                </div>
                <div class="filter-block mb-30">
                  <div class="form-group select-style select-style-icon" wire:ignore>
                    <select id="jobsDistrictDrop" class="form-control form-icons select-active" wire:model="districtFilter" onchange="changeDistrictCity(this)">
                      <option value="" @if($districtFilter == '') selected="true" @endif  disabled >Choose District</option>
                      @foreach($districts as $district)
                        <option value="{{ $district }}" @if($districtFilter == $district) selected="true" @endif  >{{ $district }}</option>
                      @endforeach
                    </select><i class="fi-rr-marker"></i>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Developer Types</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($categories as $category)
                      <li>
                        <label class="cb-container">
                          <input type="checkbox" wire:click="dispatch('scrollToTop')"  wire:model="categories.{{ $loop->index }}.value" value="{{ $category['job_position'] }}" wire:change="changeDeveloperType('{{ $loop->index }}')"><span class="text-small">{{ $category['job_position'] }}</span><span class="checkmark"></span>
                        </label><span class="number-item">{{ (isset($categoriesWithCount[$category['job_position']])?$categoriesWithCount[$category['job_position']]:0) }}</span>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Work Mode</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($types as $type)
                      <li>
                        <label class="cb-container">
                          <input type="checkbox" wire:click="dispatch('scrollToTop')" wire:model="types.{{ $loop->index }}.value" value="{{ $type['job_type'] }}" wire:change="changeSelectedType"><span class="text-small">{{ $type['job_type'] }}</span><span class="checkmark"></span>
                        </label><span class="number-item">{{ (isset($typesCount[$type['job_type']])?$typesCount[$type['job_type']]:0) }}</span>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-25">Experience</h5>
                  <div class="list-checkbox pb-20">
                    <div class="row position-relative mt-10 mb-20">
                      <div class="col-sm-12 box-slider-range1" wire:ignore>
                        <div id="slider-range"></div>
                      </div>
                      <div class="box-input-money">
                        <input class="input-disabled form-control min-value-money" type="hidden" name="min-value-money" disabled="disabled" value="0">
                        <input class="form-control min-value" type="hidden" name="min-value" value="0">
                      </div>
                    </div>
                    <div class="box-number-money">
                      <div class="row mt-30">
                        <div class="col-sm-6 col-6"><span class="font-sm color-brand-1">0</span></div>
                        <div class="col-sm-6 col-6 text-end"><span class="font-sm color-brand-1">20</span></div>
                      </div>
                    </div>
                  </div>
                  
                </div>
                
                <div class="filter-block mb-30">
                  <h5 class="medium-heading mb-10">Job Posted</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($jobsPosted as $jobPosted)
                        <li>
                          <label class="cb-container">
                            <input type="radio" wire:click="dispatch('scrollToTop')" wire:model="jobPostedValue" name="jobPostedValue" value="{{ $jobPosted['date'] }}" wire:change="changeJobPosted"><span class="text-small">{{ $jobPosted['title'] }}</span>
                            <!-- <span class="checkmark"></span> -->
                          </label>
                        </li>
                      @endforeach
                      
                    </ul>
                  </div>
                </div>
                <div class="filter-block mb-30">
                  <h5 class="medium-heading mb-15">Company Name</h5>
                  <div class="form-group select-style select-style-icon" wire:ignore>
                    <select id="jobsCompanyDrop" class="form-control form-icons select-active" wire:model="companyFilter" onchange="changeJobsCompany(this)">
                      <option value="" @if($companyFilter == '') selected="true" @endif disabled >Choose Company</option>
                      @foreach($companies as $company)
                        <option value="{{ $company['company_id'] }}"  @if($companyFilter == $company['company_id']) selected="true" @endif  >{{ $company['company_name'] }}</option>
                      @endforeach
                    </select><i class="fi-rr-marker"></i>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Sector / Industry</h5>
                  <div class="form-group select-style select-style-icon" wire:ignore>
                    <select id="jobsPrimarySectorDrop" class="form-control form-icons select-active" wire:model="primarySectorFilter" onchange="changeJobsPrimarySector(this)">
                      <option value="" selected="true" disabled >Choose Sector</option>
                      @foreach($primarySectors as $primarySector)
                        <option value="{{ $primarySector['primary_sector'] }}" >{{ $primarySector['primary_sector'] }}</option>
                      @endforeach
                    </select><i class="fi-rr-briefcase"></i>
                  </div>
                  
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Funding Stage</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($fundingStages as $fundingStage)
                      <li>
                        <label class="cb-container">
                          <input type="checkbox" wire:click="dispatch('scrollToTop')"  wire:model="fundingStages.{{ $loop->index }}.value" value="{{ $fundingStage['funding_stage'] }}" wire:change="changeSelectedFundingStage"><span class="text-small">{{ $fundingStage['funding_stage'] }}</span><span class="checkmark"></span>
                        </label><span class="number-item">{{ $fundingStage['count'] }}</span>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Employees (In Israel)</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($employees as $employee)
                      <li>
                        <label class="cb-container">
                          <input type="checkbox" wire:click="dispatch('scrollToTop')"  wire:model="employees.{{ $loop->index }}.value" value="{{ $employee['employees'] }}" wire:change="changeSelectedEmployee"><span class="text-small">{{ $employee['employees'] }}</span><span class="checkmark"></span>
                        </label><span class="number-item">{{ $employee['count'] }}</span>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-12 float-right">
          <div class="content-page">
            <div class="box-filters-job">
              <div class="row">
                <div class="col-xl-6 col-lg-5"><span class="text-small text-showing">Showing <strong>{{ $jobs->firstItem() }}-{{ $jobs->lastItem() }} </strong>of <strong>{{ $jobs->total()}} </strong>jobs</span></div>
                <div class="col-xl-6 col-lg-7 text-lg-end mt-sm-15">
                  <div class="display-flex2">
                    <div class="box-border"  >
                      <span class="text-sortby">Sort by:</span>
                      <div class="dropdown dropdown-sort">
                        <button class="btn dropdown-toggle  " id="jobsSortingButton" type="button" onclick="showToggleDropDown(this)"><span>{{ ($defaultSortBy == 'desc')?'Newest':'Oldest' }} </span><i class="fi-rr-angle-small-down"></i></button>
                        <ul class="dropdown-menu dropdown-menu-light " aria-labelledby="jobsSortingButton" id="jobsSortingDropdown">
                          <li wire:click="setSortBy('desc')"><a class="dropdown-item @if($defaultSortBy == 'desc') active @endif" href="javascript:void(0);">Newest</a></li>
                          <li wire:click="setSortBy('asc')"><a class="dropdown-item @if($defaultSortBy == 'asc') active @endif" href="javascript:void(0);">Oldest</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="box-border sidebar-filter-button"  >
                      <div class="dropdown dropdown-sort">
                        <button class="btn dropdown-toggle " type="button" onclick="showFilterPopup(this)"><span>Filter </span><i class="fi-rr-filter"></i></button>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="box-loader" id="jobsLoader" style="display: none" ><img src="https://devjobs.co.il/assets/imgs/template/loading.gif" alt="DevJobs"></div>
            <div class="row" id="jobsGridList" >
              
              @foreach ($jobs as $job)
                @include('elements.jobgrid')
              @endforeach
            </div>
          </div>
          <div  wire:loading.remove>
            {{ $jobs->links('vendor.livewire.custom-bootstrap') }}
          </div>
          
        </div>
        
      </div>
    </div>
  </section>
</div>