<footer class="main-footer text-center fixed-bottom">
    <strong>Copyright &copy; 2023 <a href="{{ route('home') }}">Yousab Tech</a>.</strong>
    All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- ./wrapper -->

<script src="{{ asset('bootstrap-5.3.1-dist\js\bootstrap.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- CodeMirror -->
<script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
<script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
<script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
<script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
<!-- DataTables  & Plugins -->
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
<script src="{{ asset('js/scripts.bundle.js') }}"></script>
{{-- <script src="{{asset('js/iconpicker-1.5.0.json')}}"></script> --}}
<script src="{{ asset('js/iconpicker-1.5.0.js') }}"></script>
<script src="{{ asset('admin/file-upload/image-input.js') }}"></script>
<!-- Page specific script -->
{{-- <script>
    $(document).ready(function() {
      $('select').each(function() {
        var $select = $(this);
        var $searchInput = $('<input type="text" class="select-search" placeholder="Search...">');
        var $optionsContainer = $('<div class="select-options"></div>').appendTo($select.parent());
    
        // Create options in the options container
        $select.find('option').each(function() {
          var $option = $('<div class="option-item"></div>')
            .text($(this).text())
            .data('value', $(this).val());
          $optionsContainer.append($option);
        });
    
        // Hide the original select
        $select.hide();   $optionsContainer.hide();
    
        // When the search input is focused, show the options container
        $searchInput.on('click', function() {
          $optionsContainer.show();
          $optionsContainer.find('.option-item').show(); // Show all options initially
    
          // Ensure selected item is at the top of the options list
          var selectedValue = $select.val();
          if (selectedValue) {
            $optionsContainer.find('.option-item').each(function() {
              if ($(this).data('value') === selectedValue) {
                $(this).prependTo($optionsContainer); // Move selected item to the top
              }
            });
          }
        });
    
        // Filter options based on search input
        $searchInput.on('input', function() {
          var searchTerm = $(this).val().toLowerCase();
          $optionsContainer.find('.option-item').each(function() {
            var optionText = $(this).text().toLowerCase();
            if (optionText.includes(searchTerm)) {
              $(this).show();
            } else {
              $(this).hide();
            }
          });
        });
    
        // Handle option selection
        $optionsContainer.on('click', '.option-item', function() {
          var selectedValue = $(this).data('value');
          $select.val(selectedValue).change(); // Update the original select
          $searchInput.val($(this).text()); // Update the search input
          $optionsContainer.hide(); // Hide the options container
        });
    
        // Hide the options container when clicking outside
        $(document).on('click', function(e) {
          if (!$(e.target).closest('.select-search, .select-options').length) {
            $optionsContainer.hide();
          }
        });
    
        // Append the search input to the select's parent element
        $select.before($searchInput);
      });
    });
    </script> --}}
@stack('scripts')

<script>
    $(document).ready(function() {
        // alert(500);
        // Simulate a click on the checkbox once the page is loaded
        console.log('you are right');
        if (!$('.targetCheckbox').is(':checked'))
            $('.targetCheckbox').click();
    });
</script>
</body>

</html>
