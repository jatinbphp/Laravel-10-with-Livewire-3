<script type="text/javascript"  data-navigate-track>
      
      $(document).on('ready turbolinks:load livewire:navigated', function() {
        @if (session('verified'))

          showToastMessage("Success","Email verified successfully.");

        @endif
        @if (session('success'))

        console.log("call thiiiis");
          showToastMessage("Success","{{  session('success') }}");
          @php
             Session::forget('success');
          @endphp
        @endif
        @if (session('error'))
          showToastMessage("Error","{{  session('error') }}");
        @endif
        @if (session('warning'))
          showToastMessage("Warning","{{  session('warning') }}");
        @endif
        @if (session('info'))
          showToastMessage("Info","{{  session('info') }}");
        @endif
      });
    </script>