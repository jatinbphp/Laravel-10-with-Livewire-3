<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-CLF2Z69BD6"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-CLF2Z69BD6'); </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N9D53RPC');</script>
    <!-- End Google Tag Manager -->
    <!-- Microsoft Clarity  -->
    <script type="text/javascript"> (function(c,l,a,r,i,t,y){ c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)}; t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i; y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y); })(window, document, "clarity", "script", "jgej9p3bci"); </script>
    <!-- End Microsoft Clarity  -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <!-- <link rel="manifest" href="manifest.json" crossorigin> -->
    <meta name="msapplication-config" content="browserconfig.xml">
    <meta name="keywords" content="DevJobs">
    <meta name="author" content="">
      <!-- <meta name="turbolinks-visit-control" content="reload"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/favicon.png') }}">
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


        @vite(['resources/sass/app.scss'])

              <link rel="preload" as="style" href="{{ asset('assets/css/custom-toast-message.min.css') }}"><link rel="stylesheet"  href="{{ asset('assets/css/custom-toast-message.min.css') }}" >

            <link rel="preload" as="style" href="{{ asset('assets/css/style.min.css?version=4.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css?version=4.1') }}" >
    <link rel="preload" as="style" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
      @if(Route::currentRouteName() == 'job_details') 
        @php
          $title = $devJob->title." - ".$devJob->company_name." - ".$devJob->city." | DevJobs";
        @endphp
      @elseif(Route::currentRouteName() == 'company_details') 
        @php
          $title = $company->name." Careers - Jobs In ".$company->name." | DevJobs";
        @endphp
      @else
        @php
          $title = "DevJobs - Git Your Dream Job Here";
        @endphp
      @endif
    <title>{{ $title }}</title>
    <meta name="description" content="With the most comprehensive listing of developer jobs, we are committed to connecting coding enthusiasts with opportunities that match their skillset and aspirations.">
    
    <meta content="https://www.devjobs.co.il/" property="og:url">
    <meta content="website" property="og:type">
    <meta content="{{ $title }}" property="og:title">
    <meta content="Step into DevJobs - Where developers find dream roles and companies hire top tech talent. Designed for the developer's journey, from exploration to employment." property="og:description">
    <meta content="{{ asset('assets/imgs/devjobs_social.png') }}" property="og:image">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="devjobs.co.il" property="twitter:domain">
    <meta content="https://www.devjobs.co.il/" property="twitter:url">
    <meta content="{{ $title }}" name="twitter:title">
    <meta content="Step into DevJobs - Where developers find dream roles and companies hire top tech talent. Designed for the developer's journey, from exploration to employment." name="twitter:description">
    <meta content="{{ asset('assets/imgs/devjobs_social.png') }}" name="twitter:image">
    <meta name="title" content="{{ $title }}">
    <link rel="canonical" href="https://www.devjobs.co.il">
    @yield('css')
  </head>

  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N9D53RPC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="preloader-active">
      <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
          <div class="text-center"><img height="268" width="357"  src="{{ asset('assets/imgs/template/loading.webp') }}" alt="DevJobs" ></div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="loginRegisterForm" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content apply-job-form">
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body pl-30 pr-30 pt-50">
              <livewire:auth.login />
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalApplyJobForm" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content apply-job-form">
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body pl-30 pr-30 pt-50">
              <livewire:upload-resume />
          </div>
        </div>
      </div>
    </div>
    @php
      $notificationDetail = getNotificationDetail();
    @endphp
    @if($notificationDetail->is_show == 1)
    
      <div class="alert alert-primary alert-dismissible m-0 @if(Route::currentRouteName() != 'dashboard') d-none @endif " id="notificationPopup" role="alert">
        <div class="col-lg-8 col-md-12 mx-auto">
            <p class="text-center" dir="rtl"><strong class="f-18 "> {{ $notificationDetail->main_title }}</strong> <button onclick="closeNotification(true)" type="button"  class="btn btn-primary mr-2" data-bs-dismiss="alert" aria-label="Close">{{ $notificationDetail->button_text }}</button></p>
        </div>
        <!-- <button type="button" onclick="closeNotification()" id="notificationPopupClose" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
      </div>
      <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" dir="rtl">
            <div class="modal-header pb-4">
              <h5 class="modal-title" id="exampleModalLabel">{{ $notificationDetail->popup_title }}</h5>
              <button type="button" class="btn-close rtl" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" onclick="closeNotification()"></button>
            </div>
            <div class="modal-body pt-0 pb-0" >
              {!! $notificationDetail->popup_content !!}
            </div>
            <div class="modal-footer" >
             
              <button onclick="closeNotification(true)" type="button"  class="btn btn-primary mr-2" data-bs-dismiss="alert" aria-label="Close">{{ $notificationDetail->popup_button_text }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    @include('elements.header')
    <main class="main">
       
      
      @yield('content')
    </main>
    @include('elements.footer')
    <script>
      function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) == 0) {
                return c.substring(nameEQ.length, c.length);
            }
        }
        return null;
      }
      
      function isEventListenerRegistered(eventName, handler) {
        var registered = false;
        var eventListeners = window.getEventListeners(window);
        if (eventListeners && eventListeners[eventName]) {
            eventListeners[eventName].forEach(function(listener) {
                if (listener.listener === handler) {
                    registered = true;
                }
            });
        }

        return registered;
      }
        var mediaQuerymobile = window.matchMedia("(max-width: 768.98px)");
        window.success = '';
        window.verified = '';
        window.error = '';
        window.warning = '';
        window.info = '';

        @if (session('verified'))
          window.verified = "Email verified successfully.";
          //showToastMessage("Success","Email verified successfully.");
          @php
            Session::forget('verified');
          @endphp
        @endif
        @if (session('success'))
          console.log("success messageee");
          window.success = "{{  session('success') }}";
          //showToastMessage("Success","{{  session('success') }}");
          
        @endif
        @if (session('error'))
          window.error = "{{  session('error') }}";
          @php
            Session::forget('error');
          @endphp
         // showToastMessage("Error","{{  session('error') }}");
        @endif
        @if (session('warning'))
          window.warning = "{{  session('warning') }}";
          @php
            Session::forget('warning');
          @endphp
          //showToastMessage("Warning","{{  session('warning') }}");
        @endif
        @if (session('info'))
          window.info = "{{  session('info') }}";
          @php
            Session::forget('info');
          @endphp
          //showToastMessage("Info","{{  session('info') }}");
        @endif
    </script>
    <script src="https://cdn.devjobs.co.il/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="https://cdn.devjobs.co.il/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.devjobs.co.il/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="https://cdn.devjobs.co.il/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/waypoints.js"></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/wow.js"></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/magnific-popup.js"></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/perfect-scrollbar.min.js" ></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/select2.min.js"></script>
   
    <script src="https://cdn.devjobs.co.il/js/plugins/scrollup.js"></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/swiper-bundle.min.js" ></script>
    <script src="https://cdn.devjobs.co.il/js/plugins/counterup.js" ></script>
    <script src="https://cdn.devjobs.co.il/js/custom-toast-message.js"></script>
    <script src="https://cdn.devjobs.co.il/js/dropzone.js"  ></script>
    <script src="https://cdn.devjobs.co.il/js/popover/jquery-popover-0.0.3.js" ></script>
    @guest
    <script src="https://apis.google.com/js/platform.js" async defer data-navigate-once></script>
    @endguest
    @if(Route::currentRouteName() == "howitworks" || Route::currentRouteName() == "employers")
      <script async src="https://tally.so/widgets/embed.js"></script>
    @endif
    
    
  
    <script src="{{ asset('assets/js/main.js?v=4.1') }}" data-navigate-once></script>
      
    <script src="{{ asset('assets/js/custom.js?v=4.2') }}" data-navigate-once></script>
 
    <livewire:styles />
    <livewire:scripts />
    <script data-navigate-once>
      $(document).on('livewire:navigated', function() {
        console.log("loaded turbolinks");
        $("#preloader-active").fadeOut("slow");
      });
      $(document).on('ready livewire:navigated', function(event) {
        if (event.type === 'ready') {
          checkNotificationPopup();
        } else {
          setTimeout(function() {
            checkNotificationPopup();
          }, 100);
        }
        
      });
      function checkNotificationPopup() {
        if(getCookie('notificationClosed') == null)
        {
          var notificationPopupElement = document.getElementById("notificationPopup");
          var modal = document.getElementById('popupModal');
         
          if(window.location.pathname == "/") {
            if(modal) {
              window.addEventListener('scroll', handleNotificationScroll);
              modal.addEventListener('hidden.bs.modal', handleModalHidden);
            }
            if(notificationPopupElement) {
              notificationPopupElement.classList.add("show");
              notificationPopupElement.classList.remove("d-none");
            }
          } else {
           
            if(modal) {
              modal.removeEventListener('hidden.bs.modal', handleModalHidden);
              handleModalHidden();
            
            }
            if(notificationPopupElement) {
              notificationPopupElement.classList.remove("show");
              notificationPopupElement.classList.add("d-none");
            }
          }
        }
      }
      function handleNotificationScroll() {
        var scrollPercentage = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        if (scrollPercentage >= 15) {
          $("#popupModal").modal('show');
        }
      }      
      function handleModalHidden() {
        window.removeEventListener('scroll', handleNotificationScroll);
      }
      function showToggleDropDown(e) {
          $(e).toggleClass('show');
          $(e).siblings(".dropdown-menu").toggleClass('show');
      }
      function closeNotification(isNavigate = false) {
        document.cookie = "notificationClosed=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
        window.removeEventListener('scroll', handleNotificationScroll);
        if(isNavigate) {
          Livewire.dispatch('redirectAuth');
        }
      }
    </script>
    
    @yield('js')
  </body>
</html>
