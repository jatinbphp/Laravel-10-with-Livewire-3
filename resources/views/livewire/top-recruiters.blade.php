<div>
    <section class="section-box mt-50">
        <div class="container">
          <div class="text-center">
            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Top Companies Recruiting Now</h2>
            
          </div>
        </div>
        <div class="container top-recruiters">
          <div class="box-swiper mt-50">
            <div class="swiper-container swiper-group-1 swiper-style-2 swiper">
              <div class="swiper-wrapper pt-5">
                <div class="swiper-slide1 same-height-box">
                  @foreach ($companies as $company)
                    <div class="item-5 mb-15 hover-up wow animate__animated animate__fadeIn">
                      <div class="item-logo">
                        <div class="image-left"><img class="lazyload" data-src="{{ $company->logo_url }}" height="52" width="52" alt="{{ $company->name }}"></div>
                        <div class="text-info-right mt-2">
                          <h4><a href="{{ route('company_details',[ $company->company_id ]) }}" wire:navigate>{{ $company->name }}</a></h4>
                        </div>
                        <p class="font-xs color-text-paragraph-2">{{ $company->description }}</p>
                        <div class="text-info-bottom mt-2">
                          <span class="font-xs color-text-mutted icon-location"><a href="{{ route('jobs_grid') }}?city={{ stripslashes($company->city) }}" wire:navigate>{{ stripslashes($company->city) }}</a></span><span class="font-xs color-text-mutted float-end mt-5"><a href="{{ route('jobs_grid') }}?companyId={{ $company->company_id }}" wire:navigate>{{ $company->total_dev_jobs }}<span> Open Jobs</span></a></span>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!-- <div class="swiper-button-next swiper-button-next-1"></div>
            <div class="swiper-button-prev swiper-button-prev-1"></div> -->
          </div>
        </div>
    </section>
</div>
