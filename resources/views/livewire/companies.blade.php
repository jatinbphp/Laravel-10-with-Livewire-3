<div>
  <section class="section-box-2">
    <div class="container">
      <div class="banner-hero banner-company">
        <div class="block-banner text-center">
          <h3 class="wow animate__animated animate__fadeInUp">Browse Companies</h3>
          <div class="font-sm color-text-paragraph-2 mt-10 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">Navigate Israel's Diverse Tech Companies: Uncover Opportunities in Startups, Hi-Tech Giants, and <br class="d-none d-xl-block">Multinationals. Explore, Connect, and Discover Your Next Professional Home.</div>
          
          <div class="box-list-character">
            <ul>
              @foreach (range('A', 'Z') as $character)
                <li><a class="cursor-pointer @if($characterFilter == $character) active @endif" wire:click="applyCharacterFilter('{{ $character }}')">{{ $character }}</a></li>
              @endforeach
              
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section-box mt-30">
    <div class="container">
      <div class="row flex-row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12 sidebar" wire:ignore.self>
          <div class="sidebar-shadow none-shadow mb-30">
            <div class="sidebar-filters">
              <div class="filter-block head-border mb-30">
                <h5>Advanced Filter  <a class="ml-10 close-filter sidebar-filter-button btn btn-danger mobile-close-button" onclick="showFilterPopup(this)" >Close</a> <a class="mt-1 link-reset reset-filter"  wire:click="resetFilter">Reset</a></h5>
              </div>
              <div class="box-loader" id="sidebarFilterLoader" style="display: none" ><img src="https://devjobs.co.il/assets/imgs/template/loading.gif" alt="DevJobs"></div>
              <div class="sidebar-filter-section">
                <div class="filter-block mb-30">
                  <div class="form-group select-style select-style-icon" wire:ignore>
                    <select id="companiesCityDrop" class="form-control form-icons select-active" wire:model="cityFilter" >
                      <option value="" selected="true" disabled  >Choose City</option>
                      @foreach($cities as $city)
                        <option value="{{ $city }}" >{{ $city }}</option>
                      @endforeach
                    </select><i class="fi-rr-marker"></i>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Company Type</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($types as $type)
                      <li>
                        <label class="cb-container">
                          <input type="checkbox" wire:click="dispatch('scrollToTop')" wire:model="types.{{ $loop->index }}.value" value="{{ $type['type'] }}" wire:change="changeSelectedType"><span class="text-small">{{ $typesName[$type['type']] }}</span><span class="checkmark"></span>
                        </label><span class="number-item">{{ $type['count'] }}</span>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Funding Stage</h5>
                  <div class="form-group">
                    <ul class="list-checkbox">
                      @foreach($fundingStages as $fundingStage)
                      <li>
                        <label class="cb-container">
                          <input type="checkbox" wire:click="dispatch('scrollToTop')" wire:model="fundingStages.{{ $loop->index }}.value" value="{{ $fundingStage['funding_stage'] }}" wire:change="changeSelectedFundingStage"><span class="text-small">{{ $fundingStage['funding_stage'] }}</span><span class="checkmark"></span>
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
                          <input type="checkbox" wire:click="dispatch('scrollToTop')" wire:model="employees.{{ $loop->index }}.value" value="{{ $employee['employees'] }}" wire:change="changeSelectedPrimarySector"><span class="text-small">{{ $employee['employees'] }}</span><span class="checkmark"></span>
                        </label><span class="number-item">{{ $employee['count'] }}</span>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                <div class="filter-block mb-20">
                  <h5 class="medium-heading mb-15">Sector / Industry</h5>
                  <div class="form-group select-style select-style-icon" wire:ignore>
                    <select id="companiesPrimarySectorDrop" class="form-control form-icons select-active" wire:model="primarySector" >
                      <option value="" selected="true" disabled  >Choose Sector</option>
                      @foreach($primarySectors as $primarySector)
                        <option value="{{ $primarySector['primary_sector'] }}" >{{ $primarySector['primary_sector'] }}</option>
                      @endforeach
                    </select><i class="fi-rr-marker"></i>
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
                <div class="col-xl-6 col-lg-5"><span class="text-small text-showing">Showing <strong>{{ $companies->firstItem() }}-{{ $companies->lastItem() }} </strong>of <strong>{{ $companies->total()}} </strong>companies</span></div>

                <div class="col-xl-6 col-lg-7 text-lg-end mt-sm-15">
                  <div class="display-flex2">
                    <div class="box-border"  >
                      <span class="text-sortby">Sort by:</span>
                      <div class="dropdown dropdown-sort">
                        <button class="btn dropdown-toggle  " id="dropdownSort2" type="button" onclick="showToggleDropDown(this)"><span>{{ $defaultSort  }} </span><i class="fi-rr-angle-small-down"></i></button>
                        <ul class="dropdown-menu dropdown-menu-light " aria-labelledby="dropdownSort2">
                          @foreach($defaultSortOptions as $defaultSortOption => $val)
                            <li wire:click="setSortBy('{{ $defaultSortOption }}')"><a class="dropdown-item @if($defaultSort == $defaultSortOption) active @endif" href="javascript:void(0);">{{ $defaultSortOption }}</a></li>
                          @endforeach
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
            <div class="box-loader" wire:loading.block ><img src="https://devjobs.co.il/assets/imgs/template/loading.gif" alt="DevJobs"></div>
            <div class="row" id="companiesGridList"  wire:loading.remove>
                @foreach ($companies as $company)

                  
                      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="card-grid-1 hover-up wow animate__animated animate__fadeIn">
                          <div class="image-box"><a href="{{ route('company_details',[ $company->company_id ]) }}" wire:navigate><img src="{{ $company->logo_url }}" height="52" width="52" alt="{{ $company->name }}"></a></div>
                          <div class="info-text mt-10">
                            <h5 class="font-bold"><a href="{{ route('company_details',[ $company->company_id ]) }}" wire:navigate>{{ $company->name }}</a></h5>
                            <div class="card-block-info">
                                <p class="font-xs color-text-paragraph-2">{{ $company->description }}</p>
                            </div>
                            <span class="card-location">{{ stripslashes($company->city) }}</span>
                            <div class="mt-30"><a class="btn btn-grey-big" href="{{ route('jobs_grid') }}?companyId={{ $company->company_id }}" wire:navigate><span>{{ $company->total_dev_jobs }}</span><span> Job{{ ($company->total_dev_jobs == 1)?'':'s' }} Open</span></a></div>
                          </div>
                        </div>
                      </div>
                  
                @endforeach
            </div>
          </div>
          <div  wire:loading.remove>
            {{ $companies->links('vendor.livewire.custom-bootstrap') }}
          </div>
        </div>
      </div>
    </div>
  </section>
  
</div>
