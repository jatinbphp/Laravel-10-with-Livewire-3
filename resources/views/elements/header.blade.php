<header class="header sticky-bar">
  <div class="container">
    <div class="main-header">
      <div class="header-left">
        <div class="header-logo"><a class="d-flex" href="{{ route('dashboard') }}" wire:navigate><img alt="DevJobs" height="64" width="363" src="{{ asset('assets/imgs/DevJobsLOGO.svg') }}"></a></div>
      </div>
      <div class="header-nav">
        <nav class="nav-main-menu">
          <ul class="main-menu">
            <!-- <li class="has-children"><a class="active" href="{{ route('dashboard') }}">Home</a>
              <ul class="sub-menu">
                <li><a href="{{ route('dashboard') }}">Home 1</a></li>
                <li><a href="index-2.html">Home 2</a></li>
                <li><a href="index-3.html">Home 3</a></li>
                <li><a href="index-4.html">Home 4</a></li>
                <li><a href="index-5.html">Home 5</a></li>
                <li><a href="index-6.html">Home 6</a></li>
              </ul>
            </li> -->
            <li class=""><a @if(Route::currentRouteName() == "jobs_grid") class="active" @endif href="{{ route('jobs_grid') }}" wire:navigate>Find a Job</a></li>
            <li class=""><a @if(Route::currentRouteName() == "companies") class="active" @endif href="{{ route('companies') }}" wire:navigate>Companies</a></li>
            <li class=""><a @if(Route::currentRouteName() == "developers") class="active" @endif href="{{ route('developers') }}" wire:navigate>Developers</a></li>
            <!-- <li class=""><a href="{{ route('about') }}" wire:navigate>About</a></li> -->
            <li class="dashboard"><a @if(Route::currentRouteName() == "employers") class="active" @endif href="{{ route('employers') }}" wire:navigate >Employers</a></li>
          </ul>
        </nav>
        <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
      </div>
      <div class="header-right">
        <livewire:auth.profile-menu />
        
      </div>
    </div>
  </div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
  <div class="mobile-header-wrapper-inner">
    <div class="mobile-header-content-area">
      <div class="perfect-scroll">
        <!-- <div class="mobile-search mobile-header-border mb-30">
          <form action="#">
            <input type="text" placeholder="Search…"><i class="fi-rr-search"></i>
          </form>
        </div> -->
        <div class="mobile-menu-wrap mobile-header-border">
          <!-- mobile menu start-->
          <nav>
            <ul class="mobile-menu font-heading">
              <li class=""><a href="{{ route('jobs_grid') }}" wire:navigate>Find a Job</a></li>
              <li class=""><a href="{{ route('companies') }}" wire:navigate>Companies</a></li>
              <li class=""><a href="{{ route('developers') }}" wire:navigate>Developers</a></li>
              <!-- <li class=""><a href="{{ route('about') }}" wire:navigate>About</a></li> -->
              <li class="dashboard1"><a href="{{ route('employers') }}" wire:navigate>Employers</a></li>
            </ul>
          </nav>
        </div>
        <div class="mobile-account">
          <h6 class="mb-10">Your Account</h6>
          <ul class="mobile-menu font-heading">
            
            <livewire:auth.profile-menu />
          </ul>
        </div>
        <div class="site-copyright">Copyright 2022 &copy; JobBox. <br>Designed by AliThemes.</div>
      </div>
    </div>
  </div>
</div>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
  <div class="mobile-header-wrapper-inner">
    <div class="mobile-header-content-area">
      <div class="perfect-scroll">
        <!-- <div class="mobile-search mobile-header-border mb-30">
          <form action="#">
            <input type="text" placeholder="Search…"><i class="fi-rr-search"></i>
          </form>
        </div> -->
        <div class="mobile-menu-wrap mobile-header-border">
          <!-- mobile menu start-->
          <nav>
            <ul class="mobile-menu font-heading">
              <li class=""><a href="{{ route('jobs_grid') }}" wire:navigate>Find a Job</a></li>
              <li class=""><a href="{{ route('companies') }}" wire:navigate>Companies</a></li>
              <li class=""><a href="{{ route('developers') }}" wire:navigate>Developers</a></li>
              <!-- <li class=""><a href="{{ route('about') }}" wire:navigate>About</a></li> -->
              <li class="dashboard1"><a href="{{ route('employers') }}" wire:navigate>Employers</a></li>
            </ul>
          </nav>
        </div>
        <div class="mobile-account">
          <h6 class="mb-10">Your Account</h6>
          <ul class="mobile-menu font-heading">
            
            <livewire:auth.profile-menu />
          </ul>
        </div>
        <div class="site-copyright">Copyright &copy; {{ date('Y') }} DevJobs<br>All right reserved.</div>
      </div>
    </div>
  </div>
</div>