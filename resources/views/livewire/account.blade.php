<div wire:init="initAccountComponent">
    <section class="section-box-2 py-4 my-4">
        <div class="container">
          <div class="banner-hero p-0">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <h3 class="pb-2 wow animate__animated animate__fadeInUp">My Account</h3>
                    @if($isDeveloper)
                        <a href="javaScript:;" class="font-sm link-text color-lightBlue">Update your profile</a>
                    @endif
                </div>
                @if($isDeveloper)
                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 text-end">
                        <a href="{{ route('developer_details', [ $developer['user_id'] ]) }}" target="_blank"  class="font-md preview-btn"><svg class="eye-icon me-2" xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>Preview public profile</a>
                    </div>
                @endif
            </div>
          </div>
        </div>
    </section>
    <section class="section-box  ">
        @if($isDeveloper == false)
            <div class="text-center">
                <div class="dropzone-section first-section-upload-cv mx-auto p-2" wire:ignore>
                    <div class="form-input myAttachment">
                        
                        <div class="dropzoneSubmit dropzone">
                        </div>
                        <p class="addpercentage" style="display:none;"></p>
                        <div class="info-section">
                        <p class="showBrowseButton" style="display:none;">
                          <a href="javaScript:void(0)" id="browseClick">Browse</a>
                          <a href="javaScript:void(0)" id="browseClear">Clear</a>
                        </p>
                        <span class="fileSizeTxt">Up to 5 MB
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" data-toggle='tooltip' data-bs-placement='bottom' title='To upload archives or files larger than 5MB, use the ShareFile link provided in your submitted support ticket.'>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 3.589 12.411 0 8 0C3.589 0 0 3.589 0 8C0 12.411 3.589 16 8 16C12.411 16 16 12.411 16 8ZM1 8C1 4.14 4.14 1 8 1C11.86 1 15 4.14 15 8C15 11.86 11.86 15 8 15C4.14 15 1 11.86 1 8ZM7 4C7 3.44772 7.44772 3 8 3C8.55229 3 9 3.44772 9 4C9 4.55228 8.55229 5 8 5C7.44772 5 7 4.55228 7 4ZM8 6C7.72386 6 7.5 6.22386 7.5 6.5V12.5C7.5 12.7761 7.72386 13 8 13C8.27614 13 8.5 12.7761 8.5 12.5V6.5C8.5 6.22386 8.27614 6 8 6Z" fill="#ffffff"/>
                            </svg>
                        </span>
                      </div>
                    </div>
                </div>
                <a class="mt-2 btn btn-apply btn-apply-big hover-up upload-developer-cv" ><img class="mr-2 d-none" height="22px" src="{{ asset('assets/imgs/template/loader.gif') }}" /> Create Developer Profile</a>
            </div>
        @endif
        @if($isDeveloper == true)
            <div class="container">
                <div class="profile-main-info pb-4 mb-4">
                    <div class="row row-gap-1">
                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                            <div class="profile-pic">
                                <img src="{{ ($developer['profile_image'] == '')?'https://static-00.iconduck.com/assets.00/profile-circle-icon-2048x2048-cqe5466q.png':asset('/storage/avatars/'.$developer['profile_image']) }}" id="output" />
                                <label class="font-md link-underline text-center color-blue mb-0 mt-1" onclick="openProfileImagePopup()" >
                                    <span>Change Avatar</span>
                                </label>
                                
                            </div>
                        </div>
                       
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <div class="profile-information">
                                <div class="border-box-main border p-4">
                                    <h6 class="border-box-title">Private Information<span class="ms-1 fw-light">(No one can see without your approval)</span></h6>
                                    <a href="javaScript:;" onclick="editPrivateInformation()" class="pos-border-icon  edit-icon">
                                        {!! loadEditIconImg() !!}
                                    </a>
                                    <a href="javaScript:;" wire:click="saveProfileInfo" class="pos-border-icon save-icon d-none ">
                                        {!! loadSaveIconImg() !!}
                                    </a>
                                    <form class="profile-form row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first-name" class="form-control" wire:model="developer.first_name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last-name" class="form-control" wire:model="developer.last_name" disabled>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="row align-items-end inputBtn-equalH">
                                            <div>
                                                <div class="form-group mb-0">
                                                    <label>Email<span>*</span></label>
                                                    <input type="email" name="mail" class="form-control" wire:model="developer.email" disabled>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="row align-items-end inputBtn-equalH">
                                            <div>
                                                <div class="form-group mb-0">
                                                    <label>Contact number<span>*</span></label>
                                                    <input type="tel" name="number" class="form-control" wire:model="developer.phone" disabled>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </form>
                                </div>
                                <div class="d-flex flex-column justify-content-end align-items-center gap-4 mt-3">
    
                                    <button type="button" class="btn icon-btn btn-default d-flex align-items-center justify-content-center" onclick="openUpdateCVPopup()">Update CV</button>
                                    @if($developer['email_verified'] == '')
                                    <button type="button" class="btn icon-btn btn-default d-flex align-items-center justify-content-center" wire:click="verifyEmail"  wire:loading.attr="disabled"><img class="" height="22px" wire:loading wire:target="verifyEmail" src="{{ asset('assets/imgs/template/loader.gif') }}" />Verify Email</button>
                                    @else 
                                    <button type="button" class="btn icon-btn btn-default d-flex align-items-center justify-content-center disabled">Email Verified</button>
                                    @endif
                                    @if($developer['phone_verified'] == '')
                                    <button type="button" class="btn icon-btn btn-default d-flex align-items-center justify-content-center" wire:click="verifyPhone"  wire:loading.attr="disabled"><img class="" height="22px" wire:loading wire:target="verifyPhone" src="{{ asset('assets/imgs/template/loader.gif') }}" />Confirm Phone</button>
                                    @else
                                    <button type="button" class="btn icon-btn btn-default d-flex align-items-center justify-content-center disabled">Phone Verified</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-box-main border p-4">
                    <h6 class="border-box-title">Public Information<span class="ms-3 fw-light font-sm color-lightBlue">#{{ $developer['user_id'] }}</span></h6>
                    <div class="d-flex flex-row justify-content-between align-items-start mt-4 mb-4 title-display-section">
                        <h3 class="title-main ">{{ $developer['title'] }}</h3>
                        <a href="javaScript:;" class="edit-icon " onclick="editTitle()">
                            {!! loadEditIconImg() !!}
                        </a>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-start mt-4 mb-4 title-save-section d-none">
                        <input type="text" name="developerTitle" class="title-main mr-2 " wire:model="developer.title" />
                        <a href="javaScript:;" onclick="saveTitle()" class="save-icon ">
                            {!! loadSaveIconImg() !!}
                        </a>
                    </div>

                    <div class="job-overview job-detail-overview">
                        <div class="d-flex flex-row justify-content-between align-items-start border-bottom pb-15 mb-30">
                          <h5 class="m-0">Overview</h5>
                          <a href="javaScript:;" onclick="openOverviewPopup()" class="edit-icon">
                                {!! loadEditIconImg() !!}
                            </a>
                        </div>
                      <div class="row">
                        
                        <div class="col-md-6 d-flex mt-sm-15">
                          <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/job-level.svg') }}" alt="DevJobs"></div>
                          <div class="sidebar-text-info ml-10"><span class="text-description joblevel-icon mb-10">Dev Type</span><strong class="small-heading">{{ $developer['developer_type'] }}</strong></div>
                        </div>                    
                        <div class="col-md-6 d-flex">
                          <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/experience.svg') }}" alt="DevJobs"></div>
                          <div class="sidebar-text-info ml-10"><span class="text-description experience-icon mb-10">Experience</span><strong class="small-heading">{{ $developer['dev_experience'] }}</strong></div>
                        </div>
                      </div>
                      <div class="row margin-top-25">
                        <div class="col-md-6 d-flex mt-sm-15">
                          <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/location.svg') }}" alt="DevJobs"></div>
                          <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Location</span><strong class="small-heading">{{ $developer['city'] }}</strong></div>
                        </div>
                        <div class="col-md-6 d-flex mt-sm-15">
                          <div class="sidebar-icon-item"><img src="{{ asset('assets/imgs/page/job-single/industry.svg') }}" alt="DevJobs"></div>
                          <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Education</span><strong class="small-heading">
                            @if($bsc == '' && ($developer['idf'] == '' || $developer['idf'] == 'None'))
                                N/A
                            @else
                                {{ $bsc.(($bsc != '' && $developer['idf'] != '' && $developer['idf'] != 'None')?', ':'') }} {{ (($developer['idf'] != 'None')?$developer['idf']:'') }}
                            @endif
                          </strong></div>
                        </div>
                      </div>
                    </div>


                    <div class="job-overview developer-description ">
                        <div class="d-flex flex-row justify-content-between align-items-start border-bottom pb-15 mb-30">
                            <h5 class="m-0">About Me</h5>
                            <a href="javaScript:;" onclick="editDeveloperDescription()" class="edit-icon">
                                {!! loadEditIconImg() !!}
                            </a>
                            <a href="javaScript:;" onclick="saveDeveloperDescription()" class="save-icon d-none">
                                {!! loadSaveIconImg() !!}
                            </a>
                        </div>
                        <div class="row content-single">
                            <div class="p-0 ">
                                {!! $developer['description'] !!}
                            </div>
                            <div class="p-0 d-none">
                                <textarea class="form-control" oninput="autoExpand(this)" wire:model="developer.description"></textarea>
                            </div>
                        </div>
                    </div>

                    
                      <livewire:developer-skill :developerId="$developer['id']" :wire:key="$developer['id']"/>
                    
                    <div class="job-overview education-skills-section">
                        <div class="d-flex flex-row justify-content-between align-items-start border-bottom pb-15 mb-30">
                            <h5 class="m-0">Education</h5>
                            <a href="javaScript:;" onclick="editEducation(this)" class="edit-icon ">
                                {!! loadEditIconImg() !!}
                            </a>
                            <a href="javaScript:;" onclick="saveEducation(this)" class="save-icon d-none ">
                                {!! loadSaveIconImg() !!}
                            </a>
                        </div>
                        <div class="row education-skills">
                            <ul class="">
                                @if($developer['education'] != '')
                                    @foreach(explode(";", $developer['education']) as $educationSkill)
                                    <li class="" >
                                        <span class="">{{ $educationSkill }} </span>
                                        <div class="form-group d-flex d-none">
                                            <input type="text" value="{{ $educationSkill }}" class="form-control mb-10 pr-35" />
                                            <span class="close-education-skill  " onclick="deleteEducationSkill(this)">{!! loadCloseIconImg() !!}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="form-group d-none">
                                <button type="button" class="btn btn-border mr-10 " id="addNewEducationSkill" onclick="addNewEducationSkill(this)">Add New Education</button>
                            </div>
                        </div>
                    </div>
                     <div class="job-overview soft-skills-section">
                        <div class="d-flex flex-row justify-content-between align-items-start border-bottom pb-15 mb-30">
                            <h5 class="m-0">Soft Skills</h5>
                            <a href="javaScript:;" onclick="editSoftSkill(this)" class="edit-icon ">
                                {!! loadEditIconImg() !!}
                            </a>
                            <a href="javaScript:;" onclick="saveSoftSkill(this)" class="save-icon d-none ">
                                {!! loadSaveIconImg() !!}
                            </a>
                        </div>
                        <div class="row soft-skills">
                            <ul class="">
                                @if($developer['softskills'] != '')
                                    @foreach(explode(";", $developer['softskills']) as $softSkill)
                                    <li class="" >
                                        <span class="">{{ $softSkill }} </span>
                                        <div class="form-group d-flex d-none">
                                            <input type="text" value="{{ $softSkill }}" class="form-control mb-10 pr-35" />
                                            <span class="close-soft-skill  " onclick="deleteSoftSkill(this)">{!! loadCloseIconImg() !!}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                @endif  
                            </ul>
                             <div class="form-group d-none">
                                <button type="button" class="btn btn-border mr-10 " id="addNewSoftSkill" onclick="addNewSoftSkill(this)">Add New Soft Skill</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <div class="modal fade" id="updateCVPopup" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
           
            <div class="modal-body pl-30 pr-30 pt-50" >
                <div class="text-center">
                    <h2 class="mt-0 mb-20 text-brand-1">Update Developer Profile</h2>
                </div>
                <div class="row">
                    <div class="text-center" >
                        <div class="dropzone-section 22 mx-auto p-2" wire:ignore>
                            <div class="form-input myAttachment">
                                
                                <div class="dropzoneSubmit dropzone">
                                </div>
                                <p class="addpercentage" style="display:none;"></p>
                                <div class="info-section">
                                <p class="showBrowseButton" style="display:none;">
                                  <a href="javaScript:void(0)" id="browseClick">Browse</a>
                                  <a href="javaScript:void(0)" id="browseClear">Clear</a>
                                </p>
                                <span class="fileSizeTxt">Up to 5 MB
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" data-toggle='tooltip' data-bs-placement='bottom' title='To upload archives or files larger than 5MB, use the ShareFile link provided in your submitted support ticket.'>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 3.589 12.411 0 8 0C3.589 0 0 3.589 0 8C0 12.411 3.589 16 8 16C12.411 16 16 12.411 16 8ZM1 8C1 4.14 4.14 1 8 1C11.86 1 15 4.14 15 8C15 11.86 11.86 15 8 15C4.14 15 1 11.86 1 8ZM7 4C7 3.44772 7.44772 3 8 3C8.55229 3 9 3.44772 9 4C9 4.55228 8.55229 5 8 5C7.44772 5 7 4.55228 7 4ZM8 6C7.72386 6 7.5 6.22386 7.5 6.5V12.5C7.5 12.7761 7.72386 13 8 13C8.27614 13 8.5 12.7761 8.5 12.5V6.5C8.5 6.22386 8.27614 6 8 6Z" fill="#ffffff"/>
                                    </svg>
                                </span>
                              </div>
                            </div>
                        </div>
                        <a class="mt-2 btn btn-apply btn-apply-big hover-up upload-developer-cv" ><img class="mr-2 d-none" height="22px" src="{{ asset('assets/imgs/template/loader.gif') }}" /> Update Developer Profile</a>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </div>
    <div class="modal fade" id="overviewPopup" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
           
            <div class="modal-body pl-30 pr-30 pt-50" >
                <div class="text-center">
                    <h2 class="mt-0 mb-20 text-brand-1">Update Overview</h2>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group d-flex flex-row align-items-center gap-2">
                            <label class="m-0 min-w-content">Dev Type:</label>
                            <select class="form-control form-select" wire:model="developer.developer_type">
                                @foreach(getDevJobsCategories() as $devType)
                                    <option value="{{ $devType }}" >{{ $devType }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group d-flex flex-row align-items-center gap-2">
                            <label class="m-0 min-w-content">Experience:</label>                        
                            <input type="number" min="0" max="20" name="dev_experience" id="dev_experience" class="form-control p-1" wire:model="developer.dev_experience" >
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group d-flex flex-row align-items-center gap-2">
                            <label class="m-0 min-w-content">Location:</label>                        
                            <input type="text" name="city" class="form-control" wire:model="developer.city">
                        </div>
                    </div>
                    <div class="col-12 mt-15 mb-15">
                        <div class="form-group d-flex flex-row align-items-center gap-2">
                            <label class="m-0 min-w-content">Education:</label>                        
                            <div class="form-group m-0">
                                <ul class="d-flex flex-wrap align-items-center list-checkbox border-0 p-0">
                                  @foreach($bscValues as $bscKey => $bscValue)
                                  <li>
                                    <label class="cb-container m-0">
                                      <input type="radio" wire:model="developer.bsc" name="bsc" value="{{ $bscKey }}" ><span class="text-small">{{ $bscValue }}</span>
                                    </label>
                                  </li>
                                  @endforeach
                                   
                                </ul>
                              </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group d-flex flex-row align-items-center gap-2">
                            <label class="m-0 min-w-content">IDF:</label>                        
                            <div class="form-group m-0">
                                <ul class="d-flex flex-wrap align-items-center list-checkbox border-0 p-0">
                                  @foreach($idfValues as $idfKey => $idfValue)
                                  <li>
                                    <label class="cb-container m-0">
                                      <input type="radio" wire:model="developer.idf" name="idf" value="{{ $idfKey }}" ><span class="text-small">{{ $idfValue }}</span>
                                    </label>
                                  </li>
                                  @endforeach
                                   
                                </ul>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="form-group w-25 mx-auto mt-4">
                  <button class="btn btn-brand-1 hover-up w-100 pl-10 pr-10" type="button" name="submit" wire:click="updateOverview" data-bs-dismiss="modal" aria-label="Close">Save</button>
                </div>
            </div>
        </div>

      </div>
    </div>
    
    <div class="modal fade" id="profileImages" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content apply-job-form">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
             <input type="hidden" name="profile_image_name" wire:model="developer.profile_image" />
            <div class="modal-body pl-30 pr-30 pt-50" >
                <div class="text-center">
                    <h2 class="mt-10 mb-10 text-brand-1">Select Your Profile Image</h2>
                    <span class="mb-10">Choose an avatar:</span>
                </div>

                <div class="box-swiper pl-35 pr-35" wire:ignore>
                  <div class="swiper-container swiper-group-6 swiper">
                    <div class="swiper-wrapper ">
                        @foreach(avatarImages() as $image) 
                            @if($loop->odd || $loop->first)
                                @if(!$loop->first)
                                    </div>
                                @endif
                                <div class="swiper-slide ">
                            @endif
                                <div class="avsimg pt-2 mb-2 hover-up">
                                    <img class="avatar lazy @if($developer['profile_image'] == $image) border @endif" onclick="selectAvatarImage(this, '{{ $image }}')" data-src="{{ asset('/storage/avatars/'.$image) }}" alt="{{ $image }}">
                                </div>
                            @if($loop->last)
                                </div>
                            @endif
                        @endforeach
                    </div>
                  </div>
                    <div class="swiper-button-next swiper-button-next-group-6"></div>
                    <div class="swiper-button-prev swiper-button-prev-group-6"></div>
                </div>
                <div class="form-group w-25 mx-auto mt-4">
                  <button class="btn btn-brand-1 hover-up w-100 pl-10 pr-10" type="button" name="submit" onclick="updateProfileImage()" >Save</button>
                </div>
            </div>
        </div>


      </div>
    </div>
    @if($confirmPhonePopup)
        <div class="modal fade show" id="phoneVerificationPopup" tabindex="-1" aria-hidden="true" style="display:block;" >
          <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <button class="btn-close" type="button"  wire:click="closePhoneVerificationPopup"></button>
               
                <div class="modal-body pl-30 pr-30 pt-50" >
                    <div class="text-center">
                        <h4 class="mt-0 mb-20 text-brand-1">OTP number was sent to your number {{ $developer['phone'] }}. Please insert it here:</h4>
                    </div>
                    <div class="row">
                        <div class=" col-12">
                            <div class="form-group d-flex flex-row align-items-center gap-2">
                                <input type="text" class="form-control p-1" name="validateCode" wire:model="validateCode" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group w-25 mx-auto mt-4">
                      <button class="btn btn-brand-1 hover-up w-100 pl-10 pr-10" type="button" name="submit" onclick="validatePhoneCode()" >Confirm</button>
                    </div>
                </div>
            </div>

          </div>
        </div>
        <div class="modal-backdrop fade show" wire:click="closePhoneVerificationPopup">
    @endif
</div>
