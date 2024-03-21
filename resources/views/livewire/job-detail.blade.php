<div >
    <section class="section-box mt-50">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
              <div class="box-border-single">
                <div class="row mt-10">
                  <div class="col-lg-8 col-md-12">
                    <h3>{{ $job->title }}</h3>
                    
                  </div>
                  <div class="col-lg-4 col-md-12 text-lg-end">
                    @if($job->is_open == 1)
                      @guest
                        <a class="btn btn-apply-icon btn-apply-now btn-apply-now btn-apply btn-apply-big hover-up login-popup" wire:click="applyButtonClicked('{{ $job->company_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now</a>
                      @else
                        <a class="btn btn-apply-icon btn-apply-now btn-apply-now btn-apply btn-apply-big hover-up" wire:click="applyButtonClicked('{{ $job->company_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now</a>
                      @endguest
                    @endif
                  </div>
                  @if($job->is_open == 0)
                  <div class="job-error-section">
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                        <path d="M10.8 1H5.2L1 5.2v5.6L5.2 15h5.6l4.2-4.2V5.2zM12 9H4V7h8z"></path>
                      </svg>
                    </span>
                    <span class="feedback-message">No longer accepting applications</span>
                  </div>
                  @endif
                </div>
                <div class="border-bottom pt-10 pb-10"></div>
                
                <div class="job-overview job-detail-overview">
                  <h5 class="border-bottom pb-15 mb-30">Overview</h5>
                  <div class="row">
                    
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/job-level.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description joblevel-icon mb-10">Job Type</span><strong class="small-heading">{{ $job->job_type }}</strong></div>
                    </div>                    
                    <div class="col-md-6 d-flex">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/experience.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description experience-icon mb-10">Experience</span><strong class="small-heading">@if($job->dev_exp != ''){{ $job->dev_exp }} {{ (($job->max_dev_exp != '')?'- '.$job->max_dev_exp:'') }} year{{ ($job->dev_exp != 1 || $job->max_dev_exp != '')?'s':'' }} @else {{ $job->exp_desc }} @endif</strong></div>
                    </div>
                  </div>
                  <div class="row margin-top-25">
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/job-type.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description jobtype-icon mb-10">Job Position</span><strong class="small-heading">{{ $job->job_position }}</strong></div>
                    </div>
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/updated.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description jobtype-icon mb-10">Updated</span><strong class="small-heading">{{ getFormattedDate($job->date) }}</strong></div>
                    </div>
                  </div>
                  <div class="row margin-top-25">
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/location.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Location</span><strong class="small-heading">{{ $job->city }}</strong></div>
                    </div>
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/salary.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Salary</span><strong class="small-heading">N/A</strong></div>
                    </div>
                  </div>
                </div>
                @if($job->skills->count() > 0)
                  <div class="job-overview">
                    <h5 class="border-bottom pb-15 mb-30">Skills</h5>
                    <div class="row">
                      <ul class="courses">
                        @foreach($job->skills as $skill)
                         
                          <li class="btn btn-grey-small @if($skill->is_mandatory) is-mandatory @endif" wire:ignore >
                            @if($skill->icon != '')
                              <img src="{{ $skill->icon }}" alt="{{ $skill->skill_name }}">
                            @endif
                            {{ $skill->skill_name }} @if($skill->years_exp > 0) ꞏ {{ $skill->years_exp }}y @endif
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                @endif
                <div class="content-single">
                  {!! $job->full_description !!}
                </div>
                <div class="author-single"><span>{{ $job->company->name  }}</span></div>
                <div class="single-apply-jobs">
                  <div class="row align-items-center">
                    <div class="col-md-5">
                      @if($job->is_open == 1)
                        @guest
                          <a class="btn btn-default btn-apply-now mr-15 login-popup" wire:click="applyButtonClicked('{{ $job->company_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now</a>
                        @else
                          <a class="btn btn-default btn-apply-now mr-15" wire:click="applyButtonClicked('{{ $job->company_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now</a>
                        @endguest
                      @endif
                      <!-- <a class="btn btn-border" href="#">Save job</a> -->
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
              <div class="sidebar-border">
                <div class="sidebar-heading">
                  <div class="avatar-sidebar">
                    <a class="image-block-link" href="{{ route('company_details',[ $job->company->company_id  ]) }}" wire:navigate><figure><img alt="DevJobs" src="{{ $job->company->logo_url }}" height="85" width="85" ></figure></a>
                    <div class="sidebar-info"><a href="{{ route('company_details',[ $job->company->company_id  ]) }}" wire:navigate><span class="sidebar-company">{{ $job->company->name  }}</span></a><span class="card-location">{{ stripslashes($job->company->city)  }}</span><a class="link-underline mt-15" href="{{ route('jobs_grid') }}?companyId={{ $job->company->company_id }}" wire:navigate>{{ $job->company->total_dev_jobs }} Open Job{{ ($job->company->total_dev_jobs == 1)?'':'s' }}</a></div>
                  </div>
                </div>
                <div class="sidebar-list-job">
                  <div class="box-map">
                    <div style="width: 100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?height=200&amp;hl=en&amp;q={{ urlencode(stripslashes($job->company->address)) }}+({{ urlencode($job->company->name) }})&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" allowfullscreen="" loading="lazy"></iframe></div>
                  </div>
                  <ul class="ul-disc">
                    <li>{{ stripslashes($job->company->address) }}</li>
                  </ul>
                </div>
              </div>
              <div class="sidebar-border">
                <h6 class="f-18">Similar jobs</h6>
                <div class="sidebar-list-job">
                  <ul>
                    @foreach($similarJobs as $similarJob)
                    <li>
                      <div class="card-list-4 wow animate__animated animate__fadeIn hover-up">
                        <div class="image"><a class="scroll-to-top" href="{{ route('job_details',[ $similarJob['job_id'] ]) }}" wire:navigate><img src="{{ $similarJob['company']['logo_url'] }}" height="50" width="50" alt="{{ $similarJob['company']['name'] }}"></a></div>
                        <div class="info-text">
                          <h5 class="font-md font-bold color-brand-1"><a  wire:click="jobClicked('{{ $similarJob['company']['id'] }}', '{{ $similarJob['job_id'] }}', '{{ $pageType }}','{{ $similarJob['job_url'] }}')" href="{{ route('job_details', [ $similarJob['job_id'] ]) }}" target="_blank" >{{ $similarJob['title'] }}</a></h5>
                          <div class="mt-0"><span class="card-briefcase">{{ $similarJob['city'] }}</span><span class="card-time"><span>{{ getFormattedDate($similarJob['date']) }} </span></div>
                          
                        </div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </section>
     
   
     
</div>
