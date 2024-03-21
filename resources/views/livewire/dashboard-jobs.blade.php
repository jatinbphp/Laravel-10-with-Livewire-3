<div wire:init="initDashboardJobs" >
    <section class="section-box mt-50">
        <div class="container">
          <div class="text-center">
            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Most Recent Jobs</h2>
            <div class="list-tabs mt-40">
              <ul class="nav nav-tabs dashboard-jobs-tabs" role="tablist">
                @foreach($categories as $key => $category)
                <li>
                  <a class="@if($key == $activeIndex) active @endif" wire:click="fetchJobs({{ $key }}, '{{ $category['job_position'] }}')" id="nav-tab-job-{{ $key }}" href="#tab-job-{{ $key }}" data-bs-toggle="tab" role="tab" aria-controls="tab-job-{{ $key }}" aria-selected="true">{{ $category['show_job_position'] }}</a>
                </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          <div class="mt-70">
            <div class="tab-content dashboard-jobs-content" id="myTabContent-1">
              <div class="box-loader" id="dashboardJobsLoader" style="display:none;" ><img data-src="https://devjobs.co.il/assets/imgs/template/loading.gif" alt="DevJobs" loading="lazy"></div>
              
                @foreach($categories as $key => $category)
                  <div class="tab-pane fade @if($key == $activeIndex) show active @endif" id="tab-job-{{ $key }}" role="tabpanel" aria-labelledby="tab-job-{{ $key }}">
                    <div class="row">
                      
                      @foreach($category['jobs'] as $job)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                          <div class="card-grid-2 hover-up newDesign">
                            <div class="card-grid-2-image-left flex-wrap justify-content-center align-items-center text-center">
                              <div class="image-box p-0 w-100 d-flex flex-column justify-content-center align-items-center text-center" wire:ignore>
                                  <img @if($initDashboardJob == false) class="lazyload" data-src="{{ $job->company->logo_url }}" @else src="{{ $job->company->logo_url }}" @endif height="52" width="52" alt="{{ $job->company->name }}">
                                  <div class="pos-badges"><span class="badge bg-danger">{{ $category['show_job_position'] }}</span>
                                    @if($job->dev_exp != '')
                                    <span class="badge bg-danger">{{ $job->dev_exp }}{{ ($job->max_dev_exp != '')?' - '.$job->max_dev_exp:'' }} Year{{ ($job->dev_exp != 1 || $job->max_dev_exp != '')?'s':'' }}</span>
                                    @endif
                                  </div>
                                  @if($job->is_manager_pos)
                                    <div class="user-icon tooltips"  tooltip="This developer job is a Managerial one"  tooltip-position="left" >
                                      <img @if($initDashboardJob == false) class="lazyload" data-src="{{ asset('assets/imgs/managerial.svg') }}" @else src="{{ asset('assets/imgs/managerial.svg') }}" @endif alt="Managerial Job" height="18px" width="18px" loading="lazy" />
                                      <span></span>
                                    </div>
                                  @endif
                              </div>
                              <div class="right-info w-100">
                                  <a class="profession color-text-paragraph" href="{{ route('company_details',[ $job->company->company_id ]) }}" wire:navigate>{{ $job->company->name }}</a>
                                  <a class="name-job" target="_blank" href="{{ route('job_details',[ $job->job_id ]) }}" wire:click="jobClicked('{{ $job->company->id }}', '{{ $job->job_id }}', '1','{{ $job->job_url }}')" >{{ $job->title }} 
                                  </a>
                                  <div class="w-100 d-flex flex-row justify-content-between align-items-center mt-3"><span class="location-small">{{ $job->city }} ({{ $job->job_type }})</span><span class="card-time">{{ getFormattedDate($job->date) }}</span></div>
                              </div>
                          </div>
                          <div class="card-block-info">
                              <ul class="courses" wire:ignore>
                                @foreach($job->skills as $skill)
                                  @if($loop->iteration > 5)
                                    @break
                                  @endif
                                  <li class="btn btn-grey-small @if($skill->is_mandatory) is-mandatory @endif">
                                    @if($skill->icon != '')
                                      <img @if($initDashboardJob == false) class="lazyload" data-src="{{ $skill->icon }}" @else src="{{ $skill->icon }}" @endif alt="{{ $skill->skill_name }}dd">
                                    @endif
                                    {{ $skill->skill_name }} @if($skill->years_exp > 0) ꞏ {{ $skill->years_exp }}y @endif
                                  </li>
                                @endforeach
                                @php
                                  $skillCount = $job->skills->count();
                                @endphp
                                @if($skillCount > 5)
                                  <li class="btn btn-dark-grey-small">+{{ ($skillCount - 5) }}</li>
                                @endif
                              </ul>
                              <div class="card-2-bottom mt-20 row">
                                <div class="col-lg-12 col-12 text-end">
                                  @guest
                                    <button class="btn btn-apply-now login-popup" wire:click="applyButtonClicked('{{ $job->company->id }}', '{{ $job->job_id }}', '1','{{ $job->job_url }}')"  data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now </button>
                                  @else
                                    <button class="btn btn-apply-now" wire:click="applyButtonClicked('{{ $job->company->id }}', '{{ $job->job_id }}', '1','{{ $job->job_url }}')"  data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now </button>
                                  @endguest
                                  <a class="btn btn-square-icon" target="_blank" href="{{ route('job_details',[ $job->job_id ]) }}" wire:click="jobClicked('{{ $job->company->id }}', '{{ $job->job_id }}', '1','{{ $job->job_url }}')" ><i class="square-icon">
                                    <svg enable-background="new 0 0 32 32"  id="Слой_1" version="1.1" viewBox="0 0 32 32"  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Fullscreen_1_"><path d="M31,18c-0.509,0-1,0.438-1,1v11H2V2h11c0.531,0,1-0.469,1-1c0-0.531-0.5-1-1-1H2C0.895,0,0,0.895,0,2v28   c0,1.105,0.895,2,2,2h28c1.105,0,2-0.895,2-2V18.985C32,18.431,31.594,18,31,18z" /><path d="M31,0H21c-0.552,0-1,0.448-1,1c0,0.552,0.448,1,1,1h7.596L8.282,22.313c-0.388,0.388-0.388,1.017,0,1.405   c0.388,0.388,1.017,0.388,1.404,0L30,3.404V11c0,0.552,0.448,1,1,1s1-0.448,1-1V1v0C32,0.462,31.538,0,31,0z" /></g><g/><g/><g/><g/><g/><g/></svg>
                                  </i></a>
                                </div>
                              </div>
                          </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                    @if(count($category['jobs']) >= 8)
                      <div class="text-center">
                        <a class="btn btn-outline-primary mt-10 see-more-jobs " href="{{ route('jobs_grid') }}?developerTypes={{ urlencode($category['job_position']) }}" wire:navigate> See More Jobs <svg fill="#05264e" xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg></a>
                      </div>
                    @endif
                  </div>
                @endforeach

              
              
            </div>
          </div>
        </div>
      </section>
</div>
