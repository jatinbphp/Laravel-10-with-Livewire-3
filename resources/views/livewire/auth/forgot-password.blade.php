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
              <div class="text-center">                       
                <h2 class="mt-10 mb-30 text-brand-1">Reset Your Password</h2>
                <p class="font-sm text-muted mb-30">
                   Enter email address associated with your account and 
                  we'll send you a link to reset your password
                </p>
              </div>
              <form class="login-register text-start mt-20" wire:submit="submit">
                
                <div class="form-group">
                  <label class="form-label" for="input-1">Email address *</label>
                  <input class="form-control @error('form.email') is-invalid @enderror" id="input-1" type="text" name="email" value="{{ old('email') }}" wire:model="form.email" required autocomplete="email">
                  @error('form.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <button class="btn btn-brand-1 hover-up w-100" type="submit" name="continue">Continue</button>
                </div>
                <div class="text-muted text-center">Don't have an Account? <a  href="{{ route('register') }}" wire:navigate wire:loading.attr="disabled">Sign up</a></div>
              </form>
            </div>
            <div class="img-1 d-none d-lg-block"><img class="shape-1" src="../assets/imgs/page/login-register/img-5.svg" alt="JobBox"></div>
            <div class="img-2"><img src="../assets/imgs/page/login-register/img-3.svg" alt="JobBox"></div>
          </div>
        </div>
    </section>
</div>
