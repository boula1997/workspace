<footer class="main-footer text-center fixed-bottom">
  <strong>Copyright &copy; 2023 <a href="{{ route('home') }}">Blanko Tech</a>.</strong>
  All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>

@include('navIcon')
@include('moveIcon')

<!-- Ensure jQuery loads first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Plugins -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap (Only one version) -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Other Plugins -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- Custom Scripts -->
<script src="{{ asset('js/scripts.bundle.js') }}"></script>
<script src="{{ asset('js/iconpicker-1.5.0.js') }}"></script>
<script src="{{ asset('admin/file-upload/image-input.js') }}"></script>

<!-- Dark Mode Handling -->
<script>
var userEmail = @json(auth()->user()->email ?? 'AM*Wo8owc^7');
if (localStorage.getItem('darkmode') == "true" || userEmail === "nessimboula@gmail.com") {
    $('body').addClass('dark-mode');
} else {
    $('body').removeClass('dark-mode');
}
</script>

<!-- Clipboard Copy -->
<script>
  $(document).on('click', '.clickable-text', function() {
      navigator.clipboard.writeText($(this).attr('content'));
  });
</script>

<!-- Checkbox Auto Click -->
<script>
  $(document).ready(function() {
      if (!$('.targetCheckbox').is(':checked')) {
          $('.targetCheckbox').click();
      }
  });
</script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.4.0/js/dataTables.rowReorder.min.js"></script>

<!-- Eruda Console Debugging -->
<script src="https://cdn.jsdelivr.net/npm/eruda"></script>
<script> eruda.init(); </script>

<!-- Alarm Sound (if needed) -->
@if (boula() || App::environment('local'))
  <script>
      document.addEventListener("DOMContentLoaded", function () {
          let lastPlayedHour = localStorage.getItem('lastPlayedHourFront') || null;
          let alarm = document.getElementById("alarmSound");

          function checkTime() {
              const now = new Date();
              const currentHour = now.getHours();
              const minutes = now.getMinutes();
              const seconds = now.getSeconds();

              if (minutes === 0 && seconds === 0 && lastPlayedHour !== currentHour) {
                  lastPlayedHour = currentHour;
                  localStorage.setItem('lastPlayedHourFront', lastPlayedHour);
                  alarm.volume = 1; 
                  alarm.play().catch(error => console.error("Playback failed:", error));
              }
          }

          setInterval(checkTime, 1000);
      });
  </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
      $('.select2').select2({
          placeholder: "{{ __('general.select') }}", // Adds a placeholder text
          allowClear: true, // Allows users to clear selection
          width: '100%', // Ensures full width for better UI
      });
  });
</script>

@stack('scripts')

</body>
</html>
