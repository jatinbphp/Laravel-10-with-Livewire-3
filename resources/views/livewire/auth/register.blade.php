<div>
  <div id="registerLoader" wire:loading wire:target="submit" >
      <div class="preloader d-flex align-items-center justify-content-center opacity-50">
        <div class="preloader-inner position-relative">
          <div class="text-center"><img src="{{ asset('assets/imgs/template/loading.gif') }}" alt="DevJobs"></div>
        </div>
      </div>
  </div>
    
    <section class="pt-20 login-register">
        <div class="container"> 
          <div class="row login-register-cover">
            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
              <div class="box-loader" id="loginLoader" style="display: none;" wire:ignore>
                <img src="https://devjobs.co.il/assets/imgs/template/loading.gif" alt="DevJobs">
              </div>
              <div class="text-center">
                <h2 class="mt-10 mb-30 text-brand-1">Start for free Today</h2>
                <a class="btn social-login hover-up mb-20" href="{{ route('googleLogin') }}"><img src="assets/imgs/template/icons/icon-google.svg" alt="DevJobs"><strong>Sign in with Google</strong></a>
                <div class="divider-text-center"><span>Or continue with</span></div>
              </div>
              <form class="login-register text-start mt-20" wire:submit="submit" onsubmit="submitLogin()">
                @csrf
                <div class="form-group">
                  <label class="form-label" for="name">{{ __('Full Name') }} *</label>
                  <input id="name" type="text" class="form-control @error('form.name') is-invalid @enderror" name="name" value="{{ old('name') }}" wire:model="form.name" required autocomplete="name" placeholder="Enter your full name" autofocus>
                  @error('form.name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label" for="email">Email *</label>
                  <input id="email" type="email" class="form-control @error('form.email') is-invalid @enderror" name="email" value="{{ old('email') }}" wire:model="form.email" required autocomplete="email" placeholder="Enter your email">
                  @error('form.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="password">Password *</label>
                  <input id="password" type="password" class="form-control @error('form.password') is-invalid @enderror" name="password" wire:model="form.password" required autocomplete="new-password"  placeholder="Enter your password">
                    @error('form.password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                
                <div class="login_footer form-group d-flex justify-content-between">
                  <label class="">
                   <span class="text-small-12"> By clicking Register, you agree to the <a class="text-brand-2" href="{{ route('terms') }}#g1" wire:navigate >Terms and Conditions</a> & <a class="text-brand-2" href="{{ route('privacypolicy') }}" wire:navigate >Privacy Policy</a> of DevJobs</span>
                  </label>
                </div>
                <div class="form-group">
                  <button class="btn btn-brand-1 hover-up w-100" type="submit" wire: name="login">Register Now</button>
                </div>
                <div class="text-muted text-center">Already have an account? <a href="{{ route('login') }}" wire:navigate wire:loading.attr="disabled">Sign in</a></div>
              </form>
            </div>
            <div class="img-1 d-none d-lg-block"><img class="shape-1" src="assets/imgs/page/login-register/img-1.svg" alt="DevJobs"></div>
            <div class="img-2"><img src="assets/imgs/page/login-register/img-2.svg" alt="DevJobs"></div>
          </div>
        </div>
    </section>
</div>
