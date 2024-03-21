<div>
    <section class="section-box dashboard-banner">
        <div class="banner-hero hero-3 hero-2 ">
          <div class="banner-inner">
            <div class="block-banner">
              <h1 class="text-62 color-white wow animate__animated animate__fadeInUp"><span>לוח המשרות הגדול בישראל</span><br class="1d-none d-lg-block"><span class="hero-text-color">למתכנתים/ות</span></h1>
              <div class="font-lg font-regular color-white mt-20 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">Git your dream job here!<br/><br/>{{ $totalDevJobs }} developer jobs are waiting for You.<br class="d-none d-lg-block"> {{ $totalDevJobsOpenedToday }} new jobs opened today.</div>
              <div class="form-find mt-40 wow animate__animated animate__fadeIn w-auto pl-30 pr-30" data-wow-delay=".2s">
                <form class="">
                  <div class="d-flex align-items-center box-categories me-1">
                    <label class="w-auto mr-10 m-0">I'm a</label>
                    <select required class="form-input mr-10 w-auto pl-10 box-border" placeholder="Select Developer Type" wire:model="category" wire:change="findCategoryJob">
                      <option value=""  disabled selected hidden >Select Developer Type</option>
                      @foreach(getDevJobsCategories()  as $category)
                        <option value="{{ $category }}">{{ $category }} Developer</option>
                      @endforeach
                    </select>
                  </div>
                </form>
              </div>
             
            </div>
          </div>
        </div>
    </section>
</div>
