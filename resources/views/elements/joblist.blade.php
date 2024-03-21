<div class="col-xl-12 col-12">
  <div class="card-grid-2 hover-up">
      <!-- <span class="flash"></span> -->
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card-grid-2-image-left">
          <div class="image-box" wire:ignore><img src="{{ $job->logo_url }}" height="52" width="52" alt="{{ $job->name}}"></div>
          <div class="right-info"><a class="name-job" href="{{ route('company_details',[ $job->company_id ]) }}" wire:navigate>{{ $job->company_name }}</a><span class="location-small">{{ $job->city }}</span></div>
        </div>
      </div>
      <div class="col-lg-6 text-start text-md-end pr-60 col-md-6 col-sm-12">
        <div class="pl-15 mb-15 mt-30"><a class="btn btn-grey-small mr-5" href="#">{{ $job->job_type }}</a>
          <!-- <a class="btn btn-grey-small mr-5" href="#">Figma</a> -->
      </div>
      </div>
    </div>
    <div class="card-block-info">
      <h4><a href="{{ route('job_details',[ $job->job_id ]) }}" wire:click="jobClicked('{{ $job->company_seq_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" wire:navigate >{{ $job->title }}</a></h4>
      <div class="mt-5"><span class="card-briefcase">{{ $job->employment_type }}</span><span class="card-time"><span>{{ getFormattedDate($job->date) }}</span></span></div>
      <p class="font-sm color-text-paragraph mt-10">{!! mb_substr(preg_replace('/<[^>]*>/', ' ',$job->full_description), 0, 250) !!}...</p>
      <div class="card-2-bottom mt-20">
        <div class="row">
          <div class="col-lg-7 col-7"></div>
          <div class="col-lg-5 col-5 text-end">
            @guest
              <a class="btn btn-apply-now login-popup"  wire:click="applyButtonClicked('{{ $job->company_seq_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now</a>
            @else
              <a class="btn btn-apply-now"  wire:click="applyButtonClicked('{{ $job->company_seq_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}">Apply now</a>
            @endguest
            <a class="btn btn-square-icon" target="_blank" href="{{ route('job_details',[ $job->job_id ]) }}" wire:click="jobClicked('{{ $job->company_seq_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" ><i class="square-icon"><svg enable-background="new 0 0 32 32"  id="Слой_1" version="1.1" viewBox="0 0 32 32"  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Fullscreen_1_"><path d="M31,18c-0.509,0-1,0.438-1,1v11H2V2h11c0.531,0,1-0.469,1-1c0-0.531-0.5-1-1-1H2C0.895,0,0,0.895,0,2v28   c0,1.105,0.895,2,2,2h28c1.105,0,2-0.895,2-2V18.985C32,18.431,31.594,18,31,18z" /><path d="M31,0H21c-0.552,0-1,0.448-1,1c0,0.552,0.448,1,1,1h7.596L8.282,22.313c-0.388,0.388-0.388,1.017,0,1.405   c0.388,0.388,1.017,0.388,1.404,0L30,3.404V11c0,0.552,0.448,1,1,1s1-0.448,1-1V1v0C32,0.462,31.538,0,31,0z" /></g><g/><g/><g/><g/><g/><g/></svg></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>