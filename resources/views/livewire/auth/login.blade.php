<div wire:init="init">
    <section class="pt-20 login-register">
      @if($activeForm == 'login')
        <div class="container"> 
          <div class="row login-register-cover">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
              <div class="box-loader" id="loginLoader" style="display: none;" wire:ignore>
                <img src="{{ asset('assets/imgs/template/loading.webp') }}" alt="DevJobs" loading="lazy">
              </div>
              <div class="text-center">
                <h2 class="mt-10 mb-30 text-brand-1">Member Login</h2>

                <a class="btn social-login hover-up mb-20 google-login"><img src="{{ asset('assets/imgs/template/icons/icon-google.svg') }}" alt="DevJobs"><strong>Sign in with Google</strong></a>
                <div class="divider-text-center"><span>Or continue with</span></div>
              </div>

              <form class="login-register text-start mt-20" wire:submit="submit"  onsubmit="submitLogin()">

                @error('wrong-details') 
                  <div class="alert alert-danger" role="alert">
                      {{$message}}
                  </div> 
                @enderror
                <div class="form-group">
                  <label class="form-label" for="input-1">Email address *</label>
                  <input class="form-control @error('form.email') is-invalid @enderror" name="email"  wire:model="form.email" id="input-1" type="text" required="" name="email" placeholder="Enter your email"  wire:loading.attr="disabled">
                  @error('form.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label" for="input-4">Password *</label>
                  <input class="form-control @error('form.password') is-invalid @enderror"  wire:model="form.password"  id="input-4" type="password" required="" name="password" placeholder="Enter your password"  wire:loading.attr="disabled">
                  @error('form.password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="login_footer form-group d-flex justify-content-end">
                  
                  @if (Route::has('password.request'))
                    <a class="text-muted cursor-pointer" wire:click="$set('activeForm', 'forgorPassword')"  wire:loading.attr="disabled">Forgot Password</a>
                    @endif
                </div>
                <div class="form-group">
                  <button class="btn btn-brand-1 hover-up w-100" type="submit" name="login"  wire:loading.attr="disabled" >Login</button>
                </div>
                <div class="text-muted text-center">Don't have an Account? <a class="cursor-pointer" wire:click="$set('activeForm', 'register')" wire:loading.attr="disabled">Sign up</a></div>
              </form>
            </div>
            
          </div>
        </div>
      @elseif($activeForm == 'register')
        <div class="container"> 
          <div class="row login-register-cover">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
              <div class="box-loader" id="registerLoader" style="display: none;" wire:ignore>
                <img src="{{ asset('assets/imgs/template/loading.webp') }}" alt="DevJobs">
              </div>
              <div class="text-center">
                <h2 class="mt-10 mb-30 text-brand-1">Start for free Today</h2>
                <a class="btn social-login hover-up mb-20 google-login"><img src="{{ asset('assets/imgs/template/icons/icon-google.svg') }}" alt="DevJobs"><strong>Sign in with Google</strong></a>
                <div class="divider-text-center"><span>Or continue with</span></div>
              </div>
              <form class="login-register text-start mt-20" wire:submit="submitRegister" onsubmit="submitRegister()">
                @csrf
                <div class="form-group">
                  <label class="form-label" for="name">{{ __('Full Name') }} *</label>
                  <input id="name" type="text" class="form-control @error('register.name') is-invalid @enderror" name="name" value="{{ old('name') }}" wire:model="register.name" required autocomplete="name" placeholder="Enter your full name" autofocus>
                  @error('register.name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label" for="email">Email *</label>
                  <input id="email" type="email" class="form-control @error('register.email') is-invalid @enderror" name="email" value="{{ old('email') }}" wire:model="register.email" required autocomplete="email" placeholder="Enter your email">
                  @error('register.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="password">Password *</label>
                  <input id="password" type="password" class="form-control @error('register.password') is-invalid @enderror" name="password" wire:model="register.password" required autocomplete="new-password"  placeholder="Enter your password">
                    @error('register.password')
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
                <div class="text-muted text-center cursor-pointer">Already have an account? <a wire:click="$set('activeForm', 'login')" wire:loading.attr="disabled">Sign in</a></div>
              </form>
            </div>
            
          </div>
        </div>
      
      @else
        <div class="container"> 
          <div class="row login-register-cover">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
              <div class="box-loader" id="forgotPasswordLoader" wire:loading wire:target="submitForgotPassword">
                <img src="{{ asset('assets/imgs/template/loading.webp') }}" alt="DevJobs">
              </div>
              <div class="text-center">                       
                <h2 class="mt-10 mb-30 text-brand-1">Reset Your Password</h2>
                <p class="font-sm text-muted mb-30">
                   Enter email address associated with your account and 
                  we'll send you a link to reset your password
                </p>
              </div>
              <form class="login-register text-start mt-20" wire:submit="submitForgotPassword" >
                
                <div class="form-group">
                  <label class="form-label" for="input-1">Email address *</label>
                  <input class="form-control @error('forgotPassword.email') is-invalid @enderror" id="input-1" type="text" name="email" value="{{ old('email') }}" wire:model="forgotPassword.email" required autocomplete="email">
                  @error('forgotPassword.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <button class="btn btn-brand-1 hover-up w-100" type="submit" name="continue">Continue</button>
                </div>
                <div class="text-muted text-center cursor-pointer">Don't have an Account? <a wire:click="$set('activeForm', 'register')"  wire:loading.attr="disabled">Sign up</a></div>
              </form>
            </div>
          </div>
        </div>
      @endif
    </section>
</div>
