<div>
    @auth
    <div class="container">
        <div class="row login-register-cover">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            
        
                <div class="box-loader" id="uploadResumeLoader" style="display: none;" wire:ignore>
                    <img src="{{ asset('assets/imgs/template/loading.webp') }}" alt="DevJobs" loading="lazy">
                </div>
                <div class="text-center">
                  <p class="font-sm text-brand-2">Job Application </p>
                  <h2 class="mt-10 mb-5 text-brand-1 text-capitalize">Start your career today</h2>
                  <p class="font-sm text-muted mb-30">Please fill in your information and send it to the employer.                   </p>
                </div>
                <form class="login-register text-start mt-20 pb-30" wire:submit="submit" onsubmit="submitUploadResume()">
                  
                  <div class="form-group">
                    <label class="form-label" for="des">Additional Text</label>
                    <textarea class=" input-comment" placeholder="Write an Additional Text" wire:model="additionalText"  ></textarea>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="resume">Upload Resume</label>
                    <input class="form-control" id="resume" name="resume" type="file" wire:model="resume"  wire:key="resumeUploadFileKey">
                    @error('resume') <span class="error">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group">
                    <button class="btn btn-default hover-up w-100" type="submit" name="uploadCV"  wire:loading.attr="disabled">Apply Now</button>
                  </div>
                </form>
            </div>
        </div>
    </div> 
    @endauth
</div>
