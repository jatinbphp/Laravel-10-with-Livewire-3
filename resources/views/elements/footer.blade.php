<footer class="footer mt-50">
  <div class="container">
   
    <div class="footer-bottom mt-50">
      <div class="row">
        <div class="col-md-4"><span class="font-xs color-text-paragraph">Copyright &copy; {{ date('Y') }}. DevJobs all right reserved</span></div>
        <div class="col-md-4 text-center">
           <div class="footer-logo  text-center d-inline-block"><a class="d-flex" href="{{ route('dashboard') }}" wire:navigate><img height="64" width="363" alt="DevJobs" src="{{ asset('assets/imgs/DevJobsLOGO.svg') }}"></a></div>
        </div>
        <div class="col-md-4 text-md-end text-start">
          <div class="footer-social"><a class="font-xs color-text-paragraph" href="{{ route('privacypolicy') }}" wire:navigate>Privacy Policy</a><a class="font-xs color-text-paragraph " href="{{ route('terms') }}" wire:navigate>Terms &amp; Conditions</a></div>
        </div>
      </div>
    </div>
  </div>
</footer>