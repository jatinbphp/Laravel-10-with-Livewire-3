<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
  <div class="card-grid-2 hover-up newDesign">
      <div class="card-grid-2-image-left flex-wrap justify-content-center align-items-center text-center">
          <div class="image-box p-0 w-100 d-flex flex-column justify-content-center align-items-center text-center">
              <img src="{{ $job->logo_url }}" height="52" width="52" alt="{{ $job->company_name }}"  >
              <div class="pos-badges"><span class="badge bg-danger">{{ showDevJobsPosition($job->job_position) }}</span>
                @if($job->dev_exp != '')
                <span class="badge bg-danger">{{ $job->dev_exp }}{{ ($job->max_dev_exp != '')?' - '.$job->max_dev_exp:'' }} Year{{ ($job->dev_exp != 1 || $job->max_dev_exp != '')?'s':'' }}</span>
                @endif
              </div>
              @if($job->is_manager_pos)
                <div class="user-icon tooltips"  tooltip="This developer job is a Managerial one"  tooltip-position="left" ><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 0C6.1084 0 3.75 2.3584 3.75 5.25C3.75 7.03418 4.6582 8.61328 6.02344 9.5625C2.94434 10.7637 0.75 13.7637 0.75 17.25H2.25C2.25 13.9512 4.64355 11.1943 7.78125 10.6172L8.25 12H9.75L10.2188 10.6172C13.3564 11.1943 15.75 13.9512 15.75 17.25H17.25C17.25 13.7637 15.0557 10.7637 11.9766 9.5625C13.3418 8.61328 14.25 7.03418 14.25 5.25C14.25 2.3584 11.8916 0 9 0ZM9 1.5C11.0801 1.5 12.75 3.16992 12.75 5.25C12.75 7.33008 11.0801 9 9 9C6.91992 9 5.25 7.33008 5.25 5.25C5.25 3.16992 6.91992 1.5 9 1.5ZM8.25 12.75L7.5 17.25H10.5L9.75 12.75H8.25Z" fill="#3C65F5"></path>
                  </svg>
                  <span></span>
                </div>
              @endif
          </div>
          <div class="right-info w-100">
              <a class="profession color-text-paragraph" href="{{ route('company_details',[ $job->company_id ]) }}" wire:navigate>{{ $job->company_name }}</a>
              <a class="name-job" target="_blank" href="{{ route('job_details',[ $job->job_id ]) }}" wire:click="jobClicked('{{ $job->company_seq_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" >{{ $job->title }}
              </a>
              <div class="w-100 d-flex flex-row justify-content-between align-items-center mt-3"><span class="location-small">{{ $job->city }} ({{ $job->job_type }})</span><span class="card-time">{{ getFormattedDate($job->date) }}</span></div>
          </div>
      </div>
      <div class="card-block-info">
          <ul class="courses">
            @foreach($job->skills as $skill)
              @if($loop->iteration > 5)
                @break
              @endif
              <li class="btn btn-grey-small @if($skill->is_mandatory) is-mandatory @endif">
                @if($skill->icon != '')
                  <img src="{{ $skill->icon }}" alt="{{ $skill->skill_name }}">
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
          <div class="card-2-bottom mt-20">
              <div class="row align-items-center">
                  @if($job->promoted == 1)
                      
                    <div class="col-lg-4 col-12">
                      <p class="small d-flex gap-1 justify-content-start align-items-center">
                        <img src="{{ asset('assets/imgs/favicon.png') }}" alt="" width="16" height="16">Promoted
                      </p>
                    </div>
                    <div class="col-lg-8 col-12 text-end">
                  @else
                    <div class="col-lg-12 col-12 text-end">
                  @endif

                    @guest
                      <a class="btn btn-apply-now login-popup"  wire:click="applyButtonClicked('{{ $job->company_seq_id }}', '{{ $job->job_id }}', '{{ $pageType }}','{{ $job->job_url }}')" data-url="{{ $job->job_url }}" data-jobid="{{ $job->job_id }}" >Apply now</a>
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