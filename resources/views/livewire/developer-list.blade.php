<div class="developer-page">
  <section class="section-box-2">
    <div class="container">
      <div class="banner-hero banner-company pb-3">
        <div class="block-banner text-center">
          <h3 class="wow animate__animated animate__fadeInUp">Welcome, Code Warriors!</h3>
        </div>
        <div class="mt-20 text-center">
            <p class="font-md color-text-paragraph mt-2">You’ve honed your skills, now let the right opportunities come to you – discreetly. Upload your resume and showcase your capabilities, all while keeping your identity under wraps.</p>
            <p class="font-md color-text-paragraph mt-2">Interested employers will reach out, and the power to unveil your identity rests solely in your hands.</p>

            <div class="mt-3">
              @auth
                <a class="join-waiting-list btn btn-brand-1" href="{{ route('account') }}" wire:navigate>Create Anonymous Developer Profile</a>
              @else
                <a class="join-waiting-list btn btn-brand-1 login-popup-window" >Create Anonymous Developer Profile</a>
              @endauth
            </div>

            <p class="font-sm color-text-paragraph mt-2 font-italic">To learn more how it works, <a href="{{ route('howitworks') }}" target="_blank">Click Here</a>
          </div>
      </div>
    </div>
  </section>
  <section class="section-box mt-30">
    <div class="container">           
      <div class="row flex-row">
         <div class="content-page">
            <div class="row" id="developersGrid" >
                @foreach ($developers as $developer)
                    @include('elements.developergrid')
                @endforeach
            </div>
        </div>
        <div  wire:loading.remove>
            {{ $developers->links('vendor.livewire.custom-bootstrap') }}
        </div>
      </div>
    </div>
  </section>
</div>
