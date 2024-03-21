<div wire:init="initJobsLocation">
    <section class="section-box mt-35">
        <div class="container">
          <div class="text-center">
            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Developer Jobs by Location</h2>
            <!-- <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Find your favourite jobs and get the benefits of yourself</p> -->
          </div>
        </div>
        <div class="container">
          <div class="row mt-50">
            @foreach($jobByLocations as $key => $jobByLocation)
                <div class="{{ $jobByLocation['class'] }}">
                  <div class="card-image-top hover-up"><a href="{{ route('jobs_grid') }}?city={{ stripslashes($jobByLocation['city']) }}" wire:navigate>
                      <div class="image lazyload-image" data-style-image="{{ $jobByLocation['image'] }}">
                        <!-- <span class="lbl-hot">Trending</span> background-image: -->
                    </div></a>
                    <div class="informations"><a href="{{ route('jobs_grid') }}?city={{ stripslashes($jobByLocation['city']) }}" wire:navigate>
                        <h5>{{ stripslashes($jobByLocation['city']) }}</h5></a>
                      <div class="row">
                        <div class="col-lg-6 col-6"><span class="text-14 color-text-paragraph-2">{{ $jobByLocation['dev_job_count'] }} Open Job{{ ($jobByLocation['dev_job_count'] != 1)?'s':'' }}</span></div>
                        <div class="col-lg-6 col-6 text-end"><span class="color-text-paragraph-2 text-14">{{ $jobByLocation['companies_count'] }} {{ ($jobByLocation['companies_count'] == 1)?'company':'companies' }}</span></div>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach

          

          </div>
        </div>
    </section>
</div>
