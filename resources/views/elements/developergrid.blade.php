<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
  <div class="card-grid-2 hover-up newDesign">
      <div class="card-grid-2-image-left flex-wrap justify-content-center align-items-center text-center">
          <div class="image-box p-0 w-100 d-flex flex-column justify-content-center align-items-center text-center">
              <img src="{{ asset('/storage/avatars/'.$developer->profile_image) }}" height="75" width="75" alt=""  >
              <div class="pos-badges"><span class="badge bg-danger">{{ showDevJobsPosition($developer->developer_type) }}</span>
                @if($developer->dev_experience != '')
                <span class="badge bg-danger">{{ $developer->dev_experience }} Year{{ ($developer->dev_experience != 1 )?'s':'' }}</span>
                @endif
              </div>

              <div class="pos-badges text-end">
                @if($bsc = getBscValue($developer->bsc) )
                <span class="badge bg-danger">{{ $bsc }}</span>
                @endif
                @if($developer->idf != 'None')
                <span class="badge bg-danger">{{ $developer->idf }}</span>
                @endif
              </div>
              
          </div>
          <div class="right-info w-100 mt-2">
             
              <a class="name-job" target="_blank" href="{{ route('developer_details', [ $developer->user_id ]) }}"  >{{ $developer->title }}
              </a>
              <div class="w-100 d-flex flex-row justify-content-center align-items-center mt-3"><span class="location-small">{{ $developer->city }}</span></div>
          </div>
      </div>
      <div class="card-block-info">
          <ul class="courses" data-skillCount="{{  $developer->developerSkills->count() }}" >
            @foreach($developer->developerSkills as $skill)
              @if($loop->iteration > 8)
                @break
              @endif
              <li class="btn btn-grey-small ">
                @if($skill->icon != '')
                  <img src="{{ $skill->icon }}" alt="{{ $skill->skill_name }}">
                @endif
                {{ $skill->skill_name }} @if($skill->years_exp > 0) ꞏ {{ $skill->years_exp }}y @endif
              </li>
            @endforeach
            
              
            
          </ul>
          <div class="card-2-bottom mt-20">
              <div class="row align-items-center">
                <div class="col-lg-6 col-6 text-start">
                  <span class="card-briefcase bg-none p-0 fw-normal">#{{ $developer->user_id }}</span>
                </div>
                <div class="col-lg-6 col-6 text-end">
                  <a class="btn btn-apply-now" target="_blank" href="{{ route('developer_details', [ $developer->user_id ]) }}" >View More</a>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>