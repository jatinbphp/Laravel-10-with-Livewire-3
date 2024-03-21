<div >
    <section class="section-box mt-50">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
              <div class="box-border-single">
                <div class="row mt-10">
                  <div class="col-lg-9 col-md-12">
                    <div class="d-flex flex-row align-items-start justify-content-start gap-2">
                        <img src="{{ ($developer->profile_image == '')?'https://static-00.iconduck.com/assets.00/profile-circle-icon-2048x2048-cqe5466q.png':asset('/storage/avatars/'.$developer->profile_image) }}" width="75">
                        <h3 class="d-flex flex-column align-items-start justify-content-start gap-1 developer-title">{{ $developer->title }}<span class="card-briefcase bg-none p-0 fw-normal" style="line-height: normal;">#{{ $developer->user_id }}</span></h3>
                    </div>

                  </div>
                  <div class="col-lg-3 col-md-12 text-end">
                    
                  </div>
                  
                </div>
                <div class="pt-10 pb-10"></div>
                
                <div class="job-overview job-detail-overview">
                  <h5 class="border-bottom pb-15 mb-30">Overview</h5>
                  <div class="row">
                    
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/job-level.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description joblevel-icon mb-10">Dev Type</span><strong class="small-heading">{{ $developer->developer_type }}</strong></div>
                    </div>                    
                    <div class="col-md-6 d-flex">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/experience.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description experience-icon mb-10">Experience</span><strong class="small-heading">@if($developer->dev_experience != ''){{ $developer->dev_experience }} year{{ ($developer->dev_experience != 1 )?'s':'' }} @else N/A @endif</strong></div>
                    </div>
                  </div>
                  <div class="row margin-top-25">
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/location.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Location</span><strong class="small-heading">{{ $developer->city }}</strong></div>
                    </div>
                    <div class="col-md-6 d-flex mt-sm-15">
                      <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/industry.svg') }}" alt="DevJobs"></div>
                      <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Education</span><strong class="small-heading">
                        @if($bsc == '' && ($developer->idf == '' || $developer->idf == 'None'))
                            N/A
                        @else
                            {{ $bsc.(($bsc != '' && $developer->idf != '' && $developer->idf != 'None')?', ':'') }} {{ (($developer->idf != 'None')?$developer->idf:'') }}
                        @endif
                      </strong></div>
                    </div>
                  </div>
                </div>
                <div class="job-overview developer-description ">
                        <div class="d-flex flex-row justify-content-between align-items-start border-bottom pb-15 mb-30">
                            <h5 class="m-0">About Me</h5>
                            </div>
                <div class="row content-single">
                  
                  {!! $developer->description !!}
                
                </div>
                </div>
                @if($developer->developerSkills->count() > 0)
                  <div class="job-overview ">
                    <h5 class="border-bottom pb-15 mb-30">Skills ({{ $developer->developerSkills->count() }})</h5>
                    <div class="row developer-skills">
                        @php
                            $categoryId = '';
                        @endphp
                        @foreach($developer->developerSkills as $skill)
                            
                            @if($categoryId != $skill->category_id) 
                                @if (!$loop->first)
                                    </ul>
                                    </div>
                                @endif
                                <div class="developer-category mb-3"> <label>{{ $categories[$skill->category_id] }}</label>
                                @if (!$loop->first)
                                    <ul class="courses">
                                @endif
                            @endif
                            @if ($loop->first)
                                <ul class="courses">
                            @endif

                              <li class="btn btn-grey-small " wire:ignore >
                                @if($skill->icon != '')
                                  <img src="{{ $skill->icon }}" alt="{{ $skill->skill_name }}">
                                @endif
                                {{ $skill->skill_name }} @if($skill->years_exp > 0) ꞏ {{ $skill->years_exp }}y @endif
                              </li>
                            @if ($loop->last)
                                </ul>
                                </div>
                            @endif
                            @php
                                $categoryId = $skill->category_id;
                            @endphp
                        @endforeach
                    </div>
                  </div>
                @endif
                <div class="job-overview ">
                    <h5 class="border-bottom pb-15 mb-30">Education</h5>
                    <div class="row education-skills">
                      @if($this->developer->education != '')
                        <ul class="">
                            @foreach(explode(";", $this->developer->education) as $educationSkill)
                            <li class="" >
                                {{ $educationSkill }} 
                            </li>
                            @endforeach
                        </ul>
                      @endif
                    </div>
                </div>
                 <div class="job-overview ">
                    <h5 class="border-bottom pb-15 mb-30">Soft Skills</h5>
                    <div class="row soft-skills">
                      @if($this->developer->softskills != '')
                        <ul class="">
                            @foreach(explode(";", $this->developer->softskills) as $softSkill)
                            <li class="" >
                                {{ $softSkill }} 
                            </li>
                            @endforeach
                        </ul>
                      @endif
                    </div>
                </div>
                
                <div class="single-apply-jobs d-none">
                  <div class="row align-items-center">
                    <div class="col-md-5">
                      
                     
                      <!-- <a class="btn btn-border" href="#">Save job</a> -->
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
              
              <div class="sidebar-border">
                <h6 class="f-18">Similar Developers</h6>
                <div class="sidebar-list-job">
                  <ul>
                    @foreach($similarDevelopers as $similarDeveloper)
                    <li>
                      <div class="card-list-4 wow animate__animated animate__fadeIn hover-up">
                        <div class="image"><a class="scroll-to-top" href="{{ route('developer_details',[ $similarDeveloper['user_id'] ]) }}" wire:navigate><img src="{{ ($similarDeveloper['profile_image'] == '')?'https://static-00.iconduck.com/assets.00/profile-circle-icon-2048x2048-cqe5466q.png':asset('/storage/avatars/'.$similarDeveloper['profile_image']) }}" height="50" width="50" alt="{{ $similarDeveloper['title'] }}"></a></div>
                        <div class="info-text">
                          <h5 class="font-md font-bold color-brand-1"><a href="{{ route('developer_details', [ $similarDeveloper['user_id'] ]) }}" target="_blank" >{{ $similarDeveloper['title'] }}</a></h5>
                          <div class="mt-0"><span class="card-briefcase">{{ $similarDeveloper['city'] }}</span></div>
                          
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
