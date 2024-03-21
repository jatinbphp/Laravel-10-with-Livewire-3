<div >
    <section class="section-box-2">
        <div class="container">
          <!-- <div class="banner-hero banner-image-single"><img src="{{ asset('assets/imgs/page/company/img.png') }}" alt="DevJobs"></div> -->
          <div class="box-company-profile">
            <div class="image-compay"><img src="{{ $company->logo_url }}" height="85" alt="DevJobs"></div>
            <div class="row mt-10">
              <div class="col-lg-7 col-md-12">
                <h5 class="f-18">{{ $company->name }} <span class="card-location font-regular ml-20">{{ stripslashes($company->city) }}</span></h5>
                <p class="mt-5 font-md color-text-paragraph-2 mb-15">{!! str_replace("   ", "<br/>", $company->description) !!}</p>
              </div>
              <div class="col-lg-5 col-md-12 text-lg-end d-inline-block company-website d-flex justify-content-end align-items-center"> <i class="fi-rr-globe "></i><a class="btn link-blue-with-underline" target="_blank" href="{{ $company->website_url }}"> {{ $company->website_url }}</a></div>
            </div>
          </div>
          
          <div class="border-bottom pt-10 pb-10"></div>
        </div>
    </section>
    <section class="section-box mt-50">
        <div class="container">
          <div class="row">
            <div class="col-lg-9 col-md-12 col-sm-12 col-12 pr-30">
              <div class="content-single">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="tab-about" role="tabpanel" aria-labelledby="tab-about">
                    {!! preg_replace("/\. \s?(?=[A-Z])/", ". <br/><br/>", stripslashes($company->about)) !!}
                  </div>
                  
                </div>
              </div>
              <div class="box-related-job content-page">
                @if($jobs->count() == 0)
                  <h6 class="mb-30">No open developer jobs</h6>
                @else
                  <h5 class="mb-30">Latest open developer jobs</h5>
                @endif
                <div class="box-list-jobs display-list">
                  <div class="row" wire:ignore >
                    @foreach ($jobs as $job)
                      @include('elements.jobgrid')
                    @endforeach
                  </div>
                </div>
               
              </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-12 pl-lg-15 mt-lg-20">
              <div class="sidebar-border">
                <div class="sidebar-heading">
                  <div class="avatar-sidebar">
                    <div class="sidebar-info pl-0"><span class="sidebar-company">{{ $company->name }}</span><span class="card-location">{{ stripslashes($company->city) }}</span></div>
                  </div>
                </div>
                <div class="sidebar-list-job">
                  <div class="box-map">
                   
                    <div style="width: 100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?height=200&amp;hl=en&amp;q={{ urlencode(stripslashes($company->address)) }}+({{ urlencode($company->name) }})&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" allowfullscreen="" loading="lazy"></iframe></div>
                  </div>
                </div>
                <div class="sidebar-list-job">
                  <ul>
                    <li>
                      <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                      <div class="sidebar-text-info"><span class="text-description">Sector / Industry</span><strong class="small-heading">{{ $company->primary_sector }}</strong></div>
                    </li>
                    <li>
                      <div class="sidebar-icon-item"><i class="fi-rr-marker"></i></div>
                      <div class="sidebar-text-info"><span class="text-description">Location</span><strong class="small-heading">{{ stripslashes($company->address) }}</strong></div>
                    </li>
                    <li>
                      <div class="sidebar-icon-item"><i class="fi-rr-user"></i></div>
                      <div class="sidebar-text-info"><span class="text-description">Employees</span><strong class="small-heading">{{ $company->employees }}</strong></div>
                    </li>
                    
                    <li>
                      <div class="sidebar-icon-item"><i class="fi-rr-hand-holding-heart"></i></div>
                      <div class="sidebar-text-info"><span class="text-description">Funding Stage</span><strong class="small-heading">{{ $company->funding_stage }}</strong></div>
                    </li>
                    @if($company->total_funding != '')
                      <li>
                        <div class="sidebar-icon-item"><i class="fi-rr-dollar"></i></div>
                        <div class="sidebar-text-info"><span class="text-description">Total Funding</span><strong class="small-heading">{{ $company->total_funding }}</strong></div>
                      </li>
                    @endif
                    <li>
                      <div class="sidebar-icon-item"><i class="fi-rr-clock"></i></div>
                      <div class="sidebar-text-info"><span class="text-description">Founded</span><strong class="small-heading">{{ $company->founded }}</strong></div>
                    </li>
                    @if($company->type == '2')
                      <li>
                        <div class="sidebar-icon-item"><i class="fi-rr-clock"></i></div>
                        <div class="sidebar-text-info"><span class="text-description">In Israel Since:</span><strong class="small-heading">{{ $company->israel_since }}</strong></div>
                      </li>
                    @endif
                    <li>
                      <div class="sidebar-icon-item"><i class="fi-rr-time-fast"></i></div>
                      <div class="sidebar-text-info"><span class="text-description mw-100 w-100">Total Dev Jobs Posted</span><strong class="small-heading">{{ $jobs->count() }}</strong></div>
                    </li>
                  </ul>
                </div>
                
              </div>
              
            </div>
          </div>
        </div>
    </section>
</div>
