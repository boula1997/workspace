    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('bootstrap-5.3.1-dist\js\bootstrap.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    {{-- <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script> --}}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    {{-- <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script> --}}
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
    <!-- CodeMirror -->
    {{-- <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script> --}}
    <!-- DataTables  & Plugins -->
    {{-- <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/scripts.bundle.js') }}"></script> --}}
    <!-- Page specific script -->
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 CSS and JavaScript -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.myTab').hide();
            // Check if the current host is local
            const localHosts = ['localhost', '127.0.0.1'];
            if (localHosts.includes(window.location.hostname)) {
                $('.myTab').show();

            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#querySelect').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>

    <script>
        $('#columnInput').on('change', function() {
            $('.columnName').text($(this).val());
        })
    </script>
    <script>
        // Set the default value of the input field to the current datetime in Cairo time zone
        document.addEventListener("DOMContentLoaded", function() {
            const startTimeInput = document.getElementById("startTimeInput");

            // Get current time in Cairo timezone
            const now = new Date().toLocaleString("en-US", {
                timeZone: "Africa/Cairo"
            });
            const cairoTime = new Date(now);

            // Format the date as 'YYYY-MM-DDTHH:MM' for datetime-local input
            const year = cairoTime.getFullYear();
            const month = String(cairoTime.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const day = String(cairoTime.getDate()).padStart(2, '0');
            const hours = String(cairoTime.getHours()).padStart(2, '0');
            const minutes = String(cairoTime.getMinutes()).padStart(2, '0');

            const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            startTimeInput.value = formattedDateTime;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <div id="startTime" startTime={{ getHourFromDateTime(settingFirst()->startTime) }}></div>
    <div id="startTimeDate" startTimeDate={{ getDateFromDateTime(settingFirst()->startTime) }}></div>

    <script>
        $(document).ready(function(e) {
            $('#querySelect').on('change', function(e) {
                $('#queryCommand').val($('#querySelect').val());
            })
        })
    </script>
    <script>
        function exportTableToExcel(tableID, filename = '') {
            // Get the table element
            var table = document.getElementById(tableID);

            // Clone the table to avoid modifying the original
            var clonedTable = table.cloneNode(true);

            // Specify the columns to exclude (index starts at 0)
            var excludeColumns = [5, 11]; // Exclude "Cost" (index 2), "Fees" (index 5), and "Prepare All" (index 11)

            // Loop through each row and remove the unwanted columns
            for (var i = 0; i < clonedTable.rows.length; i++) {
                for (var j = excludeColumns.length - 1; j >= 0; j--) {
                    clonedTable.rows[i].deleteCell(excludeColumns[j]);
                }
            }

            // Convert the modified table to a worksheet using SheetJS
            var wb = XLSX.utils.table_to_book(clonedTable, {
                sheet: "Sheet 1"
            });

            // Export the worksheet to an Excel file
            XLSX.writeFile(wb, filename ? filename + '.xlsx' : 'accounts.xlsx');
        }
    </script>


    <script>
        $(document).ready(function() {
            // Initially hide the element
            $('#selectTables').hide();

            // Toggle visibility on button click
            $('#selectsButton').on('click', function() {
                // Get the value from the input
                var timeValue = $('#timeInput').val();

                // Update the SQL query with the input value
                $('#selectTables .toggleRelation').each(function() {
                    var updatedQuery = "SELECT * FROM " + $(this).attr('table') +
                        " WHERE (created_at >= NOW() - INTERVAL " + timeValue +
                        " MINUTE) OR (updated_at >= NOW() - INTERVAL " + timeValue +
                        " MINUTE) \\G;";
                    $(this).text(updatedQuery); // Update the text inside the span
                    $(this).attr('content',
                    updatedQuery); // Update the content attribute if necessary
                });

                // Toggle visibility
                $('#selectTables').toggle();
            });
            $('#timeInput').on('input', function() {
                // Get the value from the input
                var timeValue = $('#timeInput').val();

                // Update the SQL query with the input value
                $('#selectTables .toggleRelation').each(function() {
                    var updatedQuery = "SELECT * FROM " + $(this).attr('table') +
                        " WHERE (created_at >= NOW() - INTERVAL " + timeValue +
                        " MINUTE) OR (updated_at >= NOW() - INTERVAL " + timeValue +
                        " MINUTE) \\G;";
                    $(this).text(updatedQuery); // Update the text inside the span
                    $(this).attr('content',
                    updatedQuery); // Update the content attribute if necessary
                });

            });
        });
    </script>

    {{-- <script>
        let femaleVoice = null;
        let stopReading = false; // Flag to stop reading
        let stopTimeout = null; // Timeout to reset stopReading
        let countdownInterval = null; // Interval to update countdown
        let remainingTime = 60 * 60; // 60 minutes in seconds (3600 seconds)

        function setFemaleVoice() {
            const voices = speechSynthesis.getVoices();
            femaleVoice = voices.find(voice => voice.name.includes('Google') && voice.name.includes('Female')) ||
                voices.find(voice => voice.gender === 'female') || voices[0];
            console.log('Female voice set:', femaleVoice);
        }

        function readText(text) {
            if (stopReading) {
                console.log('Reading is currently stopped.');
                return;
            }
            const utterance = new SpeechSynthesisUtterance(text);
            if (femaleVoice) {
                utterance.voice = femaleVoice;
            }
            // speechSynthesis.speak(utterance);
            console.log('Reading text:', text);
        }

        function readAllTitles() {
            if (stopReading) {
                console.log('Reading is currently stopped.');
                return;
            }
            const titles = document.querySelectorAll('td[data-title]');
            titles.forEach(td => {
                readText(td.getAttribute('data-title'));
            });
            console.log('All titles read.');
        }

        function readRandomTask() {
            if (stopReading) {
                console.log('Reading is currently stopped.');
                return;
            }
            const titles = document.querySelectorAll('td[data-title]');
            if (titles.length > 0) {
                const randomIndex = Math.floor(Math.random() * titles.length);
                const randomTask = titles[randomIndex].getAttribute('data-title');
                readText(randomTask);
                console.log('Random task read:', randomTask);
            } else {
                console.log('No tasks found.');
            }
        }

        function updateButtonCountdown() {
            const button = document.getElementById('stopReadingButton');
            if (remainingTime > 0) {
                remainingTime--;
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                button.textContent = `Reading resumes in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            } else {
                clearInterval(countdownInterval);
                button.textContent = 'Stop Reading for 60 Minutes';
            }
        }

        // function stopReadingFor60Minutes() {
        //     stopReading = true;
        //     remainingTime = 60 * 60; // Reset remaining time to 60 minutes
        //     clearTimeout(stopTimeout);
        //     clearInterval(countdownInterval);

        //     stopTimeout = setTimeout(() => {
        //         stopReading = false;
        //         console.log('Reading resumed after 60 minutes.');
        //     }, 60 * 60 * 1000); // 60 minutes in milliseconds

        //     countdownInterval = setInterval(updateButtonCountdown, 1000); // Update every second
        //     console.log('Reading stopped for 60 minutes.');
        // }

        document.addEventListener('DOMContentLoaded', (event) => {
            console.log('DOM fully loaded and parsed.');
            speechSynthesis.onvoiceschanged = setFemaleVoice;
            setFemaleVoice();
        });

        // Read all titles when the button is clicked
        // document.getElementById('readAllTitles').addEventListener('click', readAllTitles);

        // Stop reading for 60 minutes when the button is clicked
        // document.getElementById('stopReadingButton').addEventListener('click', stopReadingFor60Minutes);

        // Toggle columns visibility
        document.getElementById('toggleColumns').addEventListener('click', function() {
            var columns = document.querySelectorAll('.toggle-column');
            columns.forEach(function(column) {
                column.style.display = column.style.display === 'none' ? '' : 'none';
            });
        });

        // Run readRandomTask every 30 seconds
        setInterval(readRandomTask, 30 * 1000);
        console.log('Interval set to read a random task every 30 seconds.');
    </script> --}}


    <script>
        $(document).ready(function() {
            function fetchTitles() {
                $.ajax({
                    url: '/active-websites-titles',
                    method: 'GET',
                    success: function(data) {
                        console.log(data);

                        var titlesDiv = $('#websites-titles');
                        titlesDiv.empty(); // Clear the div before appending

                        if (data.length > 0) {
                            var titlesText = '';
                            $.each(data, function(index, title) {
                                titlesDiv.append('<p>' + title + '</p>');
                                titlesText += title + '. ';
                            });
                            // Use TTS to read the titles
                            readTitles(titlesText);
                        } else {
                            titlesDiv.append('<p>No active websites found.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching titles:', error);
                    }
                });
            }

            function readTitles(text) {
                var speech = new SpeechSynthesisUtterance(text);
                speech.lang = 'en-US'; // Set language, adjust if needed
                // window.speechSynthesis.speak(speech);
            }

            // Fetch and read titles immediately on page load
            fetchTitles();

            // Set interval to fetch and read titles every 15 minutes (900,000 milliseconds)
            setInterval(fetchTitles, 900000);
        });
    </script>






    <script>
        let isMuted = false;

        // Check if the current tab is a Google Meet or Zoom tab
        function checkMeetingTab() {
            let meetingTabActive = false;
            if (document.visibilityState === 'hidden') {
                let openTabs = window.open('', '_self');
                let url = openTabs.location.href;
                if (url.includes('meet.google.com') || url.includes('zoom.us')) {
                    meetingTabActive = true;
                }
            }
            return meetingTabActive;
        }

        // Listen for visibility changes
        document.addEventListener('visibilitychange', function() {
            isMuted = checkMeetingTab();
        });

        function toastNow(value = 0) {
            let url = "{{ route('websites.important') }}"
            $.ajax({
                type: "GET",
                url: url,
                datatype: 'JSON',
                success: function(data) {
                    console.log(data);
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "{{ app()->getLocale() == 'ar' ? 'toast-top-right' : 'toast-top-right' }}",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "900",
                        "hideDuration": "2000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    let message = value === 0 ? data.success : value;

                    if (data.status == 1) {
                        toastr.warning(message);
                    } else if (data.status == 2) {
                        toastr.success(message);
                    } else {
                        toastr.error(message);
                    }
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }
    </script>


    <script>
        function initToggles() {
            // Toggle Task
            $('.toggleTask').off('click').on('click', function() {
                let id = $(this).attr('id');
                let url = "{{ route('toggleCommited', [':id']) }}".replace(':id', id);
                let $this = $(this);

                $.ajax({
                    type: "GET",
                    url: url,
                    datatype: 'JSON',
                    success: function(data) {
                        if (data.status == 0) {
                            $this.removeClass('text-warning fw-bold');
                            $('#title' + id).removeClass('text-warning').addClass('text-danger').text(
                                'No');
                        } else {
                            $('#title' + id).removeClass('text-danger').addClass('text-warning').text(
                                'Yes');
                            $this.addClass('text-warning fw-bold');
                        }
                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            });

            // Toggle Active
            $('.toggleactive').off('click').on('click', function() {
                let id = $(this).attr('id');
                let url = "{{ route('toggleactive', [':id']) }}".replace(':id', id);
                let $this = $(this);

                $.ajax({
                    type: "GET",
                    url: url,
                    datatype: 'JSON',
                    success: function(data) {
                        if (data.status == 0) {
                            $this.removeClass('text-success').addClass('text-danger').text('No');
                        } else {
                            $this.removeClass('text-danger').addClass('text-success').text('Yes');
                        }
                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            });

            // Toggle Ask
            $('.toggleask').off('click').on('click', function() {
                let id = $(this).attr('id');
                let url = "{{ route('toggleask', [':id']) }}".replace(':id', id);
                let $this = $(this);

                $.ajax({
                    type: "GET",
                    url: url,
                    datatype: 'JSON',
                    success: function(data) {
                        if (data.status == 0) {
                            $this.removeClass('text-success').addClass('text-danger').text('No');
                        } else {
                            $this.removeClass('text-danger').addClass('text-success').text('Yes');
                        }
                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            });

            // Toggle Auto
            $('.toggleauto').off('click').on('click', function() {
                let id = $(this).attr('id');
                let url = "{{ route('toggleauto', [':id']) }}".replace(':id', id);
                let $this = $(this);

                $.ajax({
                    type: "GET",
                    url: url,
                    datatype: 'JSON',
                    success: function(data) {
                        if (data.status == 0) {
                            $this.removeClass('text-success').addClass('text-danger').text('No');
                        } else {
                            $this.removeClass('text-danger').addClass('text-success').text('Yes');
                        }
                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            });
        }
    </script>


    {{-- <script>
        document.addEventListener('livewire:load', function() {
            initToggles();
        });

        Livewire.on('updated', function() {
            initToggles();
        });
    </script> --}}


    <script>
        initToggles();
        $('.togglePostDeal').on('click', function() {
            let id = $(this).attr('id');
            let url = "{{ route('post.deal', [':id']) }}".replace(':id', id);
            let $this = $(this); // Store a reference to the clicked element

            $.ajax({
                type: "GET",
                url: url,
                datatype: 'JSON',
                success: function(data) {
                    if (data.status == 0) {
                        $this.removeClass('text-success').addClass('text-danger').text('No');
                    } else {
                        $this.removeClass('text-danger').addClass('text-success').text('Yes');
                    }
                    toastNow();
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        });
    </script>
    <script>
        $('.togglePostShow').on('click', function() {
            let id = $(this).attr('id');
            let url = "{{ route('post.show', [':id']) }}".replace(':id', id);
            let $this = $(this); // Store a reference to the clicked element

            $.ajax({
                type: "GET",
                url: url,
                datatype: 'JSON',
                success: function(data) {
                    if (data.status == 0) {
                        $this.removeClass('text-success').addClass('text-danger').text('No');
                    } else {
                        $this.removeClass('text-danger').addClass('text-success').text('Yes');
                    }
                    toastNow();
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        });
    </script>

    <script>
        $('.toggleBoulaDeal').on('click', function() {
            let id = $(this).attr('id');
            let url = "{{ route('boula.deal', [':id']) }}".replace(':id', id);
            let $this = $(this); // Store a reference to the clicked element

            $.ajax({
                type: "GET",
                url: url,
                datatype: 'JSON',
                success: function(data) {
                    if (data.status == 0) {
                        $this.removeClass('text-success').addClass('text-danger').text('No');
                    } else {
                        $this.removeClass('text-danger').addClass('text-success').text('Yes');
                    }
                    toastNow();
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            toastNow();
            $('.employee-cell').on('click', function() {
                var serverId = $(this).data('server-id');
                var cell = $(this);

                $.ajax({
                    url: '{{ route('cycle-employee') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        server_id: serverId
                    },
                    success: function(response) {
                        if (response.success) {
                            cell.text(response.new_employee);
                        } else {
                            alert('Failed to update employee.');
                        }
                    },
                    error: function() {
                        alert('An error occurred.');
                    }
                });
            });
        });
    </script>


    <script>
        $(document).on('click', '.fa-copy', function() {
            $('#postModal' + $(this).attr('websiteId')).modal('show');
        });
    </script>
    <script>
        $(document).on('click', '.reference', function() {
            $('#referenceModal' + $(this).attr('id')).modal('show');
        });
    </script>
    <script>
        $('#startTimeCheck').hide();

        $(document).ready(function() {
            var startTime = parseInt($('#startTime').attr('startTime'));
            var startTimeDate = $('#startTimeDate').attr('startTimeDate');
            var now = new Date();
            var year = now.getFullYear();
            var month = (now.getMonth() + 1).toString().padStart(2, '0');
            var day = now.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;
            var currentHour = now.getHours();

            // Calculate endHour with wrap around
            var endHour = (startTime + 8) % 24;

            var isWithinWorkingHours = false;

            // For the same day
            if (startTimeDate === formattedDate) {
                if (startTime <= endHour) {
                    if (currentHour >= startTime && currentHour < endHour) {
                        isWithinWorkingHours = true;
                    }
                } else {
                    if (currentHour >= startTime || currentHour < endHour) {
                        isWithinWorkingHours = true;
                    }
                }
            } else {
                // For the previous day
                if (startTime <= endHour) {
                    if (currentHour < endHour) {
                        isWithinWorkingHours = false;
                        $('#surveyModal').modal('show');
                    }
                } else {
                    if (currentHour < endHour || currentHour >= startTime) {

                        isWithinWorkingHours = true;
                    }
                }
            }

            // For debugging purposes, display the calculated times and conditions
            console.log('startTime:', startTime);
            console.log('endHour:', endHour);
            console.log('currentHour:', currentHour);
            console.log('startTimeDate:', startTimeDate);
            console.log('formattedDate:', formattedDate);
            console.log('isWithinWorkingHours:', isWithinWorkingHours);

            if (!isWithinWorkingHours) {
                alert("You are accessing this site outside of working hours (" + startTime + ":00 - " + endHour +
                    ":00).");
                alert("Please be productive today :)");
                setTimeout(() => {
                    $('#surveyModal').modal('show');
                    $('input[name="startYourWork"]').click();
                }, 3000);
            }
        });








        $(document).ready(function() {
            $('#allWebsites').hide();
            $('#allRefrences').hide();
            $('#allRoutes').hide();
            showSelectedActionInputs();
            $('#replaceButton').click(function() {
                // Retrieve search and replace terms from input fields
                var searchTerms = $('#searchTerm').val().split(',');
                var replaceTerms = $('#replaceTerm').val().split(',');

                // Ensure equal number of search and replace terms
                if (searchTerms.length !== replaceTerms.length) {
                    alert('Number of search terms must match number of replace terms.');
                    return;
                }

                // Perform replacement for each pair of search and replace terms
                for (var i = 0; i < searchTerms.length; i++) {
                    var search = searchTerms[i].trim();
                    var replace = replaceTerms[i].trim();

                    // Perform replacement directly in jQuery
                    var content = $('#contentToReplace').html();
                    content = content.replace(new RegExp(search, 'g'), replace);
                    $('#contentToReplace').html(content);
                }
            });

        });

        $(document).ready(function() {
            $('#websites').addClass('d-none');
            $('.resultContent').each(function() {
                var originalContent = $(this).text();
                var content = originalContent;

                var arrayData = $(this).siblings('.hilightResult').attr('array');
                var searchWords = JSON.parse(arrayData);

                // Remove existing highlights
                $(this).find('.highlighted').each(function() {
                    $(this).replaceWith($(this).text());
                });

                // Iterate over each search word and highlight it
                searchWords.forEach(function(word) {
                    content = highlightAll(content, word);
                });

                $(this).html(content);
            });
        });



        $(document).on('submit', '#startTimeForm', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var startTime = $('#startTimeInput').val(); // Get the value of the input field
            // Make a POST AJAX request to update the start time
            $.ajax({
                url: '{{ route('update.datetime') }}', // Replace 'your_update_start_time_endpoint' with your actual endpoint URL
                type: 'POST',
                data: {
                    startTime: startTime,
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel CSRF protection
                },
                success: function(response) {
                    toastNow();
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                    // Optionally, you can display an error message to the user
                }
            });
        });

        $('#startTimeInput').on('change', function(e) {
            $('#startTimeButton').click();
        })




        function highlightAll(content, word) {
            var escapedWord = escapeHtml(word); // Escape HTML entities
            var regex = new RegExp(escapedWord.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'gi');
            return content.replace(regex, '<span class="highlighted">$&</span>');
        }

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
            };
            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }

        function showSelectedActionInputs() {
            if (localStorage.getItem('selectAction') == 'create new module(or Open newly added module)') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                            else
                                $(this).removeAttr('checked');
                        });
                $('input[name="name"').show().attr('placeholder', 'current module name');
                $('input[name="rname"').show().attr('placeholder', 'need to create module name');
                $('#flaginput').show().attr('placeholder', 'Flag');
                $('#stack').show().attr('placeholder', 'Select stack');
                $('input[name="flag"').hide().attr('required', false);
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('input[name="attribute"').show().attr('placeholder', 'Add attributes');
                $('input[name="dbname"').show().attr('placeholder', 'Insert database name');
                $('input[name="tablename"').show().attr('placeholder', 'ex: tablename1,tablename2');

                $('input[name="module"').show().attr('placeholder', 'need to create module name');
                $('input[name="type"').show().attr('placeholder', 'Select attributes types');
                $('#stack').show().attr('placeholder', 'Enter stack');



                let bar3 = false;
                if (bar3) {

                    $('#refrencePlural').attr('checked', true);
                    $('input[name="plural"').show().attr('placeholder', 'Enter plural');
                } else {

                    $('#refrencePlural').attr('checked', false);
                    $('input[name="plural"').hide().attr('required', false);
                }
            } else if (localStorage.getItem('selectAction') == 'Delete multible module') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="name"').show().attr('placeholder', 'Enter name');
                $('#flaginput').show().attr('placeholder', 'Enter flag');
                $('#stack').show().attr('placeholder', 'Enter stack');
                $('input[name="flag"').hide().attr('required', false);
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');
                $('#searchRefrences').attr('checked', false);

            } else if (localStorage.getItem('selectAction') == 'Rename module') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="name"').show().attr('placeholder', 'Enter name');
                $('#flaginput').show().attr('placeholder', 'Enter flaginput');
                $('#stack').show().attr('placeholder', 'Enter stack');
                $('input[name="flag"').hide().attr('required', false);
                $('input[name="rname"').show().attr('placeholder', 'Enter rname');
                $('input[name="attribute"').show().attr('placeholder', 'Enter attribute');
                $('input[name="dbname"').show().attr('placeholder', 'Enter dbname');

                $('input[name="module"').show().attr('placeholder', 'Enter module');
                $('input[name="type"').show().attr('placeholder', 'Enter type');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');



                let bar4 = false;
                if (bar4) {

                    $('#refrencePlural').attr('checked', true);
                    $('input[name="plural"').show().attr('placeholder', 'Enter plural');
                } else {

                    $('#refrencePlural').attr('checked', false);
                    $('input[name="plural"').hide().attr('required', false);
                }
            } else if (localStorage.getItem('selectAction') == 'Open multible modules') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="name"').show().attr('placeholder', 'Enter name');
                $('#flaginput').show().attr('placeholder', 'Enter flag');
                $('input[name="flag"').hide().attr('required', false);
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('input[name="attribute"').show().attr('placeholder', 'Enter attribute');
                $('input[name="dbname"').show().attr('placeholder', 'Enter dbname');

                $('input[name="module"').show().attr('placeholder', 'Enter module');
                $('input[name="type"').show().attr('placeholder', 'Enter type');
                $('#textarea').hide().attr('required', false);
                $('#stack').show().attr('placeholder', 'Enter stack');


            } else if (localStorage.getItem('selectAction') == 'Reblace word in module') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('#flaginput').show().attr('placeholder', 'Enter flaginput');
                $('input[name="flag"').hide().attr('required', false);
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('input[name="name"').show().attr('placeholder', 'Enter name');
                $('input[name="word"').show().attr('placeholder', 'Enter word');
                $('input[name="replaceWord"').show().attr('placeholder', 'Enter replaceWord');

            } else if (localStorage.getItem('selectAction') == 'Get files with size bigger than') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="size"').show().attr('placeholder', 'Enter size');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('#flaginput').hide().attr('required', false);
                $('#stack').hide().attr('required', false);
            } else if (localStorage.getItem('selectAction') == 'copy multible modules using repo') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="name"').show().attr('placeholder', 'Enter name');
                $('#flaginput').show().attr('placeholder', 'Enter flag');
                $('input[name="flag"').hide().attr('required', false);
                $('input[name="repolink"').show().attr('placeholder', 'Enter repo link');
                $('input[name="projectrepolink"').show().attr('placeholder',
                    'Enter project repo link');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

            } else if (localStorage.getItem('selectAction') == 'translate all attributes') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'Enter dbname');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem('selectAction') == 'Search all attributes at once' || localStorage.getItem(
                    'selectAction') ==
                'search project modules' || localStorage.getItem('selectAction') == 'Show or Delete project images' ||
                localStorage.getItem('selectAction') ==
                'desc database'
            ) {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'Enter db name');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');
                $('#flaginput').hide().attr('required', false);

            } else if (localStorage.getItem('selectAction') == 'Prebare multible modules to work on') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="name"').show().attr('placeholder', 'Enter name');
                $('#flaginput').show().attr('placeholder', 'Enter flaginput');
                $('input[name="flag"').hide().attr('required', false);
                $('input[name="dbname"').show().attr('placeholder', 'Enter dbname');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');


            } else if (localStorage.getItem('selectAction') == 'translate untranslated words' || localStorage.getItem(
                    'selectAction') == 'Add new template link' || localStorage.getItem(
                    'selectAction') == 'Add new googlead link') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'Enter link');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem('selectAction') == 'translate untranslated words' || localStorage.getItem(
                    'selectAction') == 'React post') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'enter base url');
                $('input[name="templateName"').show().attr('placeholder', 'insert component name');
                $('input[name="projectrepolink"').show().attr('placeholder',
                    'insert attribute name');
                $('input[name="word"').show().attr('placeholder', 'enter endpoint');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                if (localStorage.getItem('selectAction') ==
                    'React post') {
                    $('input[name="attribute"').show().attr('placeholder', 'add attributes');
                    $('input[name="dbname"').show().attr('placeholder', 'insert database name');

                    $('input[name="module"').show().attr('placeholder', 'need to create module');
                    $('input[name="type"').show().attr('placeholder', 'add attributes types');
                    $('#textarea').hide().attr('required', false);
                    $('#stack').show().attr('placeholder', 'Select stack');
                }
                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem('selectAction') == 'translate untranslated words' || localStorage.getItem(
                    'selectAction') == 'React get') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'enter base url');
                $('input[name="templateName"').show().attr('placeholder', 'insert component name');
                $('input[name="word"').show().attr('placeholder', 'enter endpoint');
                $('#textarea').hide().attr('required', false);
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');
                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem(
                    'selectAction') == 'Ajax get') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'url');
                $('input[name="module"').show().attr('placeholder', 'attribute name');
                $('#textarea').hide().attr('required', false);

                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');
                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem(
                    'selectAction') == 'Ajax post') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'insert form id');
                $('input[name="module"').show().attr('placeholder', 'route name');
                $('#textarea').hide().attr('required', false);


                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');
                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem('selectAction') == 'checkout multible module') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="name"').show().attr('placeholder', 'Enter repo link');
                $('#flaginput').show().attr('placeholder', 'Enter flag');
                $('input[name="flag"').hide().attr('required', false);
                $('input[name="commit"').show().attr('placeholder', 'Enter commit');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');


            } else if (localStorage.getItem('selectAction') == 'Open Shared Module Files') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('input[name="dbname"').show().attr('placeholder', 'Enter dbname');
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('#flaginput').hide().attr('required', false);
            } else if (localStorage.getItem('selectAction') == 'add script' || localStorage.getItem('selectAction') ==
                'auto attributes' || localStorage.getItem('selectAction') ==
                'get multible scripts' || localStorage.getItem('selectAction') ==
                'add module' || localStorage.getItem('selectAction') ==
                'get multible modules') {

                if (localStorage.getItem('selectAction') ==
                    'add module' || localStorage.getItem('selectAction') ==
                    'get multible modules') {
                    $('#projectContent').attr('checked', true);
                   $('#textarea').show().attr('placeholder', 'ex:keyword1,keyword2,keyword3');

                } else {

                    $('#projectContent').attr('checked', false);
                }

                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                        $('#textarea').show().attr('placeholder', 'ex:keyword1,keyword2,keyword3');
                $('#stack').hide().attr('required', false);

                if (localStorage.getItem('selectAction') ==
                    'auto attributes') {
                    $('input[name="attribute"').show().attr('placeholder', 'add attributes');
                    $('input[name="dbname"').show().attr('placeholder', 'insert database name');
                    $('input[name="tablename"').show().attr('placeholder', 'ex: tablename1,tablename2');

                    $('input[name="module"').show().attr('placeholder', 'need to create module');
                    $('input[name="type"').show().attr('placeholder', 'add attributes types');
                    $('#textarea').hide().attr('required', false);
                    $('#stack').show().attr('placeholder', 'Select stack');
                }

                $('#flaginput').hide().attr('required', false);
                $('#websites').addClass('d-none');


            } else if (localStorage.getItem('selectAction') == 'Servers Hostings and git default' || localStorage.getItem(
                    'selectAction') == 'Image Workspace' || localStorage.getItem('selectAction') == 'flags manager' ||
                localStorage.getItem('selectAction') == 'Get Stats') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');
                $('#flaginput').hide().attr('required', false);
                $('#stack').hide().attr('required', false);

            } else if (localStorage.getItem('selectAction') == 'Select the required action') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('#textarea').hide().attr('required', false);
                $('#websites').addClass('d-none');

                $('#flaginput').hide().attr('required', false);
                $('#stack').hide().attr('required', false);

            } else if (localStorage.getItem('selectAction') == 'Open Websites') {
                $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                    .each(
                        function() {
                            if ($(this).attr('type') !== 'checkbox')
                                $(this).hide().attr('required', false);
                        });
                $('#textarea').hide().attr('required', false);
                $('#flaginput').hide().attr('required', false);
                $('#stack').hide().attr('required', false);
                $('#websites').removeClass('d-none')

            }
        }
        $(document).ready(function(e) {
            $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                .each(
                    function() {
                        $(this).bind("input", function(event) {
                            if ($(this).attr('name') == 'queryCommand')
                                localStorage.setItem($(this).attr('name') + 'automation', $(this).val());
                        });
                        if (localStorage.getItem('queryCommandautomation') !== null && $(this).attr('name') ==
                            'queryCommand')
                            $(this).val(localStorage.getItem('queryCommandautomation'));
                    });

            $('option').each(function() {
                if ($(this).val() == localStorage.getItem('selectedExtension'))
                    $(this).attr('selected', true);
            });
            $('#extension').on('change', function() {
                localStorage.setItem('selectedExtension', $('#extension').find(':selected').val())
            });
            $('#textarea').hide().attr('required', false);
            $('#websites').addClass('d-none');

            $('#flaginput').hide().attr('required', false);
            $('#stack').hide().attr('required', false);
            if ($('#result').text().length < 800) {

                $('#formBody').show().attr('placeholder', 'Enter formBody');
                $('#showForm').hide().attr('required', false);
            } else {

                $('#formBody').hide().attr('required', false);
                $('#showForm').show().attr('placeholder', 'Enter showForm');
            }

            $('input[name="lastTimeDate"]').hide().attr('required', false);
            $('input[name="startTimeInput"]').hide().attr('required', false);
            $('#showForm').on('click', function(e) {
                $('input[name="lastTimeDate"]').hide().attr('required', false);
                $('input[name="startTimeInput"]').hide().attr('required', false);
                $('#formBody').show().attr('placeholder', 'Enter formBody');
                $(this).hide().attr('required', false);
                $('#result').hide().attr('required', false);

                showSelectedActionInputs();

            });




            $(".d-flex p").each(function() {
                let clickCount = 0;
                let singleClickTimer;

                $(this).on("click", function(event) {
                    clickCount++;

                    if (clickCount === 1) {
                        singleClickTimer = setTimeout(() => {
                            if (clickCount === 1) {
                                clickCount = 0;
                                let id = $(this).attr('id');
                                let url = "{{ route('website.toggle', [':id']) }}".replace(
                                    ':id', id);
                                handleEvent(id, url, 1); // Pass 1 for single click
                            } else if (clickCount === 2) {
                                clickCount = 0;
                                let id = $(this).attr('id');
                                let url = "{{ route('website.dbltoggle', [':id']) }}"
                                    .replace(':id', id);
                                handleEvent(id, url, 2); // Pass 2 for double click
                            }
                        }, 400); // Adjust delay as needed (milliseconds)
                    } else if (clickCount === 3) {
                        clearTimeout(singleClickTimer);
                        clickCount = 0;
                        let id = $(this).attr('id');
                        let url = "{{ route('website.trpltoggle', [':id']) }}".replace(':id', id);
                        handleEvent(id, url, 3); // Pass 3 for triple click
                    }
                });

                function handleEvent(id, url, eventType) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        datatype: 'JSON',
                        success: function(data) {
                            if (eventType === 1) {
                                if (data['status'] == 1) {
                                    $('#' + id).removeClass('bg-secondary bg-success bg-danger')
                                        .addClass('bg-warning');
                                } else {
                                    $('#' + id).removeClass('bg-warning bg-success bg-danger')
                                        .addClass('bg-secondary');
                                }
                            } else if (eventType === 2) {
                                if (data['status'] == 2) {
                                    $('#' + id).removeClass('bg-secondary bg-warning bg-danger')
                                        .addClass('bg-success');
                                } else {
                                    $('#' + id).removeClass('bg-success bg-warning bg-danger')
                                        .addClass('bg-secondary');
                                }
                            } else if (eventType === 3) {
                                if (data['status'] == 3) {
                                    $('#' + id).removeClass(
                                        'bg-secondary bg-warning bg-success').addClass(
                                        'bg-danger');
                                } else {
                                    $('#' + id).removeClass('bg-danger bg-warning bg-success')
                                        .addClass('bg-secondary');
                                }
                            }
                            toastNow();
                        },
                        error: function(reject) {
                            console.log(reject);
                        }
                    });
                }
            });





            $('#removeColors').on('click', function(e) {
                e.preventDefault();
                $(".d-flex p").each(function() {
                    if ($(this).hasClass('bg-warning') || $(this).hasClass('bg-success')) {
                        $(this).click();
                    }
                });

            });







            // setTimeout(function() {
            //     $(".bg-secondary").each(function() {
            //         $(this).addClass('bg-warning');
            //         $(this).removeClass('bg-secondary');
            //     });
            // }, 1000);



            // function toggle() {
            //     $(".bg-warning").each(function() {
            //         if ($(this).hasClass('bg-white'))
            //             $(this).removeClass("bg-white");
            //         else
            //             $(this).addClass("bg-white");
            //     });
            // }
            // setInterval(toggle, 500);





            $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                .each(
                    function() {
                        if ($(this).attr('type') !== 'checkbox')
                            $(this).hide().attr('required', false);
                    });


            $('#selectAction').on('change', function(e) {
                let action = $('#selectAction').find(":selected").text();
                localStorage.setItem('selectAction', action);
                showSelectedActionInputs();
            });

            $('input[name="showWebsites"]').on('change', function(e) {
                $('#amDone').hide();

                if ($(this).is(':checked')) {
                    $('#allWebsites').show();

                } else {

                    $('#allWebsites').hide();
                }
            });
            $('input[name="showReferences"]').on('change', function(e) {

                if ($(this).is(':checked')) {
                    $('#allRefrences').show();
                } else {
                    $('#allRefrences').hide();
                }
            });
            $('input[name="showRoutes"]').on('change', function(e) {

                if ($(this).is(':checked')) {
                    $('#allRoutes').show();
                } else {
                    $('#allRoutes').hide();
                }
            });
            // $('input[name="showTasks"]').on('change', function(e) {
            //     let question = confirm('Reload to update?');
            //     if (question) {
            //         window.location.reload();
            //     }

            //     if ($(this).is(':checked')) {
            // $('#tasksModal').modal('show');
            //     } else {
            //         $('#tasksModal').modal('hide');
            //     }
            // });

            // Listen for the modal hide event
            $('#tasksModal').on('hide.bs.modal', function() {
                $('input[name="showTasks"]').prop('checked', false);
            });

            $('input[name="startYourWork"]').on('change', function(e) {
                if ($(this).is(':checked')) {
                    $('#amDone').show();
                    $('#allWebsites').show();
                    $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                        .each(
                            function() {
                                if ($(this).attr('type') !== 'checkbox')
                                    $(this).hide().attr('required', false);
                            });

                    $('textarea').hide().attr('required', false);

                } else {

                    $('#allWebsites').hide();
                    $('#startTimeInput').hide();
                    $('#startTimeCheck').hide();
                    showSelectedActionInputs();
                }
            });

            $('#amDone').on('click', function() {
                $('#startTimeCheck').show();
                $('#startTimeInput').show();
                $('#allWebsites').hide();
            });

            $('input[name="showSurvey"]').on('change', function(e) {
                if ($(this).is(':checked')) {
                    $(this).attr('checked', false);
                    $('#surveyModal').modal('show');
                } else {
                    $(this).attr('checked', false);
                    $('#surveyModal').modal('hide');
                }
            });

            $('input[name="searchRefrences"]').on('change', function(e) {
                if ($(this).is(':checked')) {
                    $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                        .each(
                            function() {
                                if ($(this).attr('type') !== 'checkbox')
                                    $(this).hide().attr('required', false);
                            });
                    $('#textarea').show().attr('placeholder', 'Enter textarea');
                    $('#flaginput').hide().attr('required', false);
                    $('#stack').hide().attr('required', false);
                    $('#websites').addClass('d-none');
                    localStorage.setItem('wasSelected', $('#selectAction').find(":selected").val());
                    $('option').each(function() {
                        if ($(this).val() == '16') {
                            if ($(this).text() == 'get multible scripts') {
                                $(this).attr('selected', true);
                                $('#textarea').show().attr('placeholder', 'ex:keyword1,keyword2,keyword3');
                            }
                        }
                    });
                } else {

                    $('#textarea').hide().attr('required', false);
                    $('#websites').addClass('d-none');
                    $('#flaginput').hide().attr('required', false);
                    $('#stack').hide().attr('required', false);

                    // showSelectedActionInputs();

                    $('option').each(function() {
                        if ($(this).val() == localStorage.getItem('wasSelected')) {
                            $('#selectAction').find(":selected").removeAttr('selected');
                            $(this).addAttr('selected');
                        }
                    });


                }
            });
            $('input[name="replace"]').on('change', function(e) {
                if ($(this).is(':checked')) {
                    $('input[name="templateName"').hide().attr('required', false);

                    let bar2 = false;
                    if (bar2) {
                        $('#linkPHP').attr('checked', true);
                        $('input[name="templateName"').show().attr('placeholder',
                            'Enter templateName');

                    } else {
                        $('#linkPHP').attr('checked', false);
                        $('input[name="templateName"').hide().attr('required', false);
                    }

                    $('input[name="newPaths"').show().attr('placeholder',
                        'Enter newPaths');
                    $('input[name="flag"').show().attr('placeholder', 'Enter flag');
                    $('#textarea').hide().attr('required', false);
                    $('#websites').addClass('d-none');

                    $('#flaginput').hide().attr('required', false);
                    $('#stack').hide().attr('required', false);
                    $('input[name="newPaths"').removeAttr('disabled');
                    $('#flaginput').removeAttr('disabled');
                    $('#stack').removeAttr('disabled');
                    $('input[name="templateName"').removeAttr('disabled');
                    $("input:not([name='start']):not([name='search']):not([name='start']):not([name='replaceTerm']):not([name='queryCommand']):not([name='showScripts']):not(.noHide)")
                        .each(function() {
                            if ($(this).attr('type') !== 'checkbox' && $(this).attr('name') !==
                                "newPaths" && $(this).attr('name') !==
                                "flag" && $(this).attr('name') !==
                                "templateName")
                                $(this).hide().attr('required', false);
                        });
                } else {
                    $('input[name="templateName"').hide().attr('required', false);
                    $('input[name="newPaths"').hide().attr('required', false);
                    $('input[name="newPaths"').attr('disabled', true);
                    $('input[name="flag"').hide().attr('required', false);
                    $('#flaginput').hide().attr('required', false);
                    $('#flaginput').attr('disabled', true);
                    $('#stack').hide().attr('required', false);
                    $('#stack').attr('disabled', true);
                    $('input[name="templateName"').hide().attr('required', false);
                    $('input[name="templateName"').attr('disabled', true);
                    $('#linkPHP').attr('checked', false);
                    $('#overwrite').attr('checked', false);

                    // add it here
                    showSelectedActionInputs();
                    // add it here
                }
            });
            $('input[name="refrence"]').on('change', function(e) {
                if ($(this).is(':checked')) {
                    $('input[name="plural"').show().attr('placeholder',
                        'Enter plural');
                } else {
                    $('input[name="plural"').hide().attr('required', false);
                }
            });
            $('input[name="queryCommand"').show().attr('placeholder', 'Enter queryCommand');
            $('input[name="files[]"').show().attr('placeholder', 'Enter files');




        });
    </script>

    <script src="{{ asset('bootstrap-5.3.1-dist\js\bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- JavaScript to trigger modal on page load -->
    <script>
        $(document).on('submit', '#tasksForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updateTasks') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastNow();
                        window.location.reload();
                    } else {
                        $('#successMsg').text('');
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').text(value);
                        });
                    }
                }
            });
        });
    </script>



    <script>
        $(document).on('submit', '#sampleForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('samples.script') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastNow();
                    } else {
                        $('#successMsg').text('');
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').text(value);
                        });
                    }
                }
            });
        });
    </script>







    <script>
        $(document).on('submit', '#postForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('posts.tasks') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastNow();
                    } else {
                        $('#successMsg').text('');
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').text(value);
                        });
                    }
                }
            });
        });
    </script>
    <script>
        $(document).on('submit', '#referenceForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('references.tasks') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastNow();
                    } else {
                        $('#successMsg').text('');
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').text(value);
                        });
                    }
                }
            });
        });
    </script>
    <script>
        $(document).on('submit', '#referenceForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('references.tasks') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastNow();
                    } else {
                        $('#successMsg').text('');
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').text(value);
                        });
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.script').each(function() {
                $(this).hide();
            })

            $('#showDeletes').on('click', function() {
                if ($(this).text() == 'Show Deletes') {
                    $(this).text('Hide Deletes')
                    $('.script').each(function() {
                        $(this).show();
                    })
                } else {
                    $(this).text('Show Deletes')
                    $('.script').each(function() {
                        $(this).hide();
                    })

                }
            })
        })
        $(document).on('submit', '#queryForm', function(e) {
            e.preventDefault();
            $('#allResults').removeClass('d-none');
            $('#allResults').text('Show All');
            $('#refresh').removeClass('d-none');
            $('#addFormStyle').attr('style', 'margin-left: 900px !important;');
            $('#jsonResult').empty();
            let formData = new FormData(this);
            console.log(formData)
            localStorage.setItem('query', $('input[name="queryCommand"]').val());
            let db = $("#dbname").attr('dbname');
            let table = $('#table').attr('table');
            let url = "{{ route('db.data', [':db', ':table', ':query']) }}";
            url = url.replace(':db', db);
            url = url.replace(':table', table);
            url = url.replace(':query', localStorage.getItem('query'));
            localStorage.setItem('url', url);
            $.ajax({
                type: 'POST',
                url: "{{ route('query.exec') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    response.data.forEach(boula => {
                        console.log('boula', response);
                        $('#jsonResult').append(
                            `<button class='w-25 btn btn-outline-secondary showRow exec' id='btn${boula.id}'>show ${boula.id}</button>`
                        );

                        if ('btn' + boula.id == localStorage.getItem(
                                'openedQueryId'))
                            $('#jsonResult').append(
                                `<div class="col-md-3" id="id${boula.id}">`
                            );
                        else
                            $('#jsonResult').append(
                                `<div class="col-md-3 d-none" id="id${boula.id}">`
                            );
                        Object.entries(boula).forEach(element => {
                            $(`#id${boula.id}`).append(
                                $("<p>").text(JSON.stringify(
                                    element
                                )) // Set text content to avoid HTML parsing
                            );
                        });

                        $('#jsonResult').append("<hr>");
                    });
                    toastNow(response.success);
                    $('#querySelect').prepend(
                        `<option value="${response.query}">${response.query}</option`)

                },
                error: function(response) {
                    toastNow(response.error);

                }
            });
        });
    </script>


    <script>
        $(document).ready(function(e) {
            let today = $('#data').attr('today');
            let tomorrow = $('#data').attr('tomorrow');

            // Prevent modal from closing when clicking "Yes" or "No" buttons
            $('#yes, #no').on('click', function(e) {
                e.preventDefault();


                // Custom logic for Yes button
                if ($(this).attr('id') === 'yes') {
                    $('input[name="showSurvey"]').removeAttr('checked');
                    localStorage.setItem('tomorrow', tomorrow);
                    $('#showSurvey').click();
                    // Close the modal
                    $('#surveyModal').modal('hide');
                }

                // Custom logic for No button
                if ($(this).attr('id') === 'no') {
                    e.stopPropagation();
                    $('input[name="showSurvey"]').removeAttr('checked');
                    localStorage.setItem('tomorrow', tomorrow);
                    $('input[name="lastTimeDate"]').show().attr('placeholder',
                        'Enter lastTimeDate');
                    $('#showSurvey').click();

                    // Keep the modal open
                    $('#surveyModal').modal('show');
                }

                var targetDate = "{{ settings()->home4g }}"; // Ensure this is in 'YYYY-MM-DD' format

                $(document).ready(function () {
                function getRemainingDays(targetDate) {
                    var target = new Date(targetDate);
                    var today = new Date();
                    today.setHours(0, 0, 0, 0); // Reset time to avoid time differences

                    var timeDiff = target.getTime() - today.getTime();
                    var daysRemaining = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

                    return daysRemaining >= 0 ? daysRemaining : 0; // Ensure no negative values
                }

                var remainingDays = getRemainingDays(targetDate);
                console.log("Remaining days: " + remainingDays);
                alert(remainingDays + " days remaining");
                });

            });





            $('#lastTimeDate').on('change', function(e) {
                e.preventDefault();
                $('#surveyModal').modal('hide');
                // localStorage.setItem('last_time', $(this).val());
                let url = "{{ route('last.update', [':date']) }}"
                url = url.replace(':date', $(this).val());
                $.ajax({
                    type: "Get",
                    url: url,
                    datatype: 'JSON',
                    success: function(data) {
                        toastNow();
                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });

            });

            // $('#time').text(localStorage.getItem('last_time'));
            //    alert(localStorage.getItem('tomorrow'))
            if (today >= localStorage.getItem('tomorrow') || localStorage.getItem('tomorrow') == null) {
                $('#surveyModal').modal('show');

            }
        });
    </script>



    <script>
        $(document).ready(function() {
            var hrefs = [];
            $('.resultLink').each(function() {
                hrefs.push($(this).text());
            });

            console.log(hrefs);


            $('#openDashboard').on('click', function(e) {
                e.preventDefault();
                for (var i in hrefs) {
                    if (hrefs[i].includes('dashboard'))
                        window.open('' + hrefs[i] + '');
                }
            });
            $('#yousab').on('click', function(e) {
                e.preventDefault();
                window.open('accountant');
            });
            $('#tasks').on('click', function(e) {
                e.preventDefault();
                window.open('https://yousab-tech.com/elmotahda/public/en/dashboard');
                window.open('https://yousab-tech.com/webapp/public/en/dashboard');
            });
            $('#motahda').on('click', function(e) {
                e.preventDefault();
                window.open('accountantMotahda');
            });
            $('#second').on('click', function(e) {
                e.preventDefault();
                window.open('second');
            });
            $('#home').on('click', function(e) {
                e.preventDefault();
                window.open('actions');
            });
            $('#auto').on('click', function(e) {
                e.preventDefault();
                window.open('auto');
            });
            $('#notes').on('click', function(e) {
                e.preventDefault();
                window.open('notes');
            });
            $('#issues').on('click', function(e) {
                e.preventDefault();
                window.open('issues');
            });

            $('#close').on('click', function(e) {
                e.preventDefault();
                navigator.clipboard.writeText(
                    'taskkill /F /FI "USERNAME ne NT AUTHORITY\SYSTEM" /FI "STATUS eq RUNNING"\n' +
                    'cls'
                );

                toastNow();
            });

            $('#googlead').on('click', function(e) {
                e.preventDefault();
                window.open(
                    'https://youtube.com/playlist?list=PLxe78bIBB8nW-xMUSm-9piWRlRpBSeIRe&si=PoaUQt7P8vjavmSN'
                );
                toastNow();
            });
            $('#routes').on('click', function(e) {
                e.preventDefault();
                window.open(
                    'http://127.0.0.1:8000/routes'
                );
                toastNow();
            });
            $('#dashboard').on('click', function(e) {
                e.preventDefault();
                window.location.href = 'https://yousab-tech.com/workspace/public/en/dashboard/tasks';
                toastNow();
            });

            $('#temblates').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('templates') }}', // Replace with your API endpoint
                    method: 'GET',
                    success: function(response) {
                        // Assuming the response contains a list of templates
                        var templates = response.data;

                        // Loop through templates
                        templates.forEach(function(template) {
                            console.log(template);
                            // You can use template.link or template.id etc. here as needed

                            // Example of opening a link (template.link)
                            window.open(template.link);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching templates:', error);
                    }
                });
            });
            $('#googleads').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('googleads') }}', // Replace with your API endpoint
                    method: 'GET',
                    success: function(response) {
                        // Assuming the response contains a list of templates
                        var googleads = response.data;

                        // Loop through googleads
                        googleads.forEach(function(googlead) {
                            console.log(googlead);
                            // You can use googlead.link or googlead.id etc. here as needed

                            // Example of opening a link (googlead.link)
                            window.open(googlead.link);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching googleads:', error);
                    }
                });
            });
            $('#autor').on('click', function(e) {
                e.preventDefault();

                window.open('https://yousab-tech.com/workspace/public');
                toastNow();

            });

            $('#facebookads').on('click', function(e) {
                e.preventDefault();
                window.open('https://youtu.be/e8ynOIVlTsc?si=jb-qtp5VPKXJ7YzJ');
                toastNow();
            });
            $('#seo').on('click', function(e) {
                e.preventDefault();
                window.open(
                    'https://youtube.com/playlist?list=PLAOJNfhkbzlW4SVFtg91kYzgTJ0KFI5uN&si=mF5xcv3KRDXhN0Ni'
                );
                toastNow();
            });

            $('#meet').on('click', function(e) {
                e.preventDefault();
                window.open('https://us04web.zoom.us/');
                window.open('https://meet.google.com/');
            });
            $('#DBCredentials').on('click', function(e) {
                e.preventDefault();
                window.open('db/credentials');
            });


            $('#phpMyAdmin').on('click', function(e) {
                e.preventDefault();
                navigator.clipboard.writeText(
                    'cd /d E:/xampp/mysql/bin\n' +
                    'mysqldump -u root -p --no-create-info --complete-insert --ignore-table=automation.migrations automation > "E:/xampp/htdocs/automation/exported_databases/automation.sql"\n' +
                    '\n' +
                    'cd /d E:/xampp/htdocs/automation\n' +
                    'git add .\n' +
                    'git commit -m "commit" \n' +
                    'git pull origin main \n' +
                    'git push origin main \n' +
                    'exit \n' +
                    'cls'
                );

                toastNow();


            });
            $('#backup').on('click', function(e) {
                e.preventDefault();
                navigator.clipboard.writeText(
                    'mysqldump -u yousabte_workspace -p --complete-insert yousabte_workspace > yousabte_workspace_export.sql\n' +
                    '\n' +
                    'kD[asKgc%ydC'
                );
                toastNow();
            });


            $('#updateDB').on('click', function(e) {
                e.preventDefault();
                navigator.clipboard.writeText(
                    'php artisan migrate:fresh \n' +
                    'mysql -u yousabte_automation -p yousabte_automation  < public/exported_databases/automation.sql \n' +
                    'o$01Yqf{R;s6 \n'
                );

                toastNow();

            });

            $('#updatedTables').on('click', function(e) {
                e.preventDefault();
                window.open('run-query?dbname=automation&username=root&password=&interval=10');
                toastNow();

            });


            $('#servers').on('click', function(e) {
                e.preventDefault();
                window.open('servers');

            });
            $('#finishedServers').on('click', function(e) {
                e.preventDefault();
                window.open('servers/finished');

            });
            $('#openAPI').on('click', function(e) {
                e.preventDefault();
                for (var i in hrefs) {
                    if (hrefs[i].includes('api'))
                        window.open('' + hrefs[i] + '');
                }
            });
            $('#openFront').on('click', function(e) {
                e.preventDefault();
                for (var i in hrefs) {
                    if (!hrefs[i].includes('api') && !hrefs[i].includes('dashboard'))
                        window.open('' + hrefs[i] + '');
                }
            });
            $('#showLinks').on('click', function(e) {
                e.preventDefault();
                if ($('#links').hasClass('d-none')) {

                    $('#links').removeClass('d-none');
                    $(this).text('Hide links');
                } else {
                    $(this).text('Show links');

                    $('#links').addClass('d-none');
                }
            });



            $(document).on('click', '.showRow', function() {
                $('#allResults').text('Show All');
                $('#allResults').removeClass('d-none');
                $('#refresh').removeClass('d-none');
                // $(this).scrollIntoView({ behavior: 'smooth', block: 'start' });
                $('.showRow').next().addClass('d-none');
                $(this).next().removeClass('d-none');
                $('html, body').animate({
                    scrollTop: $(this).next().offset().top - 50
                }, 1000);

                $('#jsonResult').empty();
                let db = $("#dbname").attr('dbname');
                let table = $(this).attr('table');
                let url = "{{ route('db.data', [':db', ':table', ':query']) }}";
                let status = false;

                if ($(this).hasClass('exec'))
                    status = true;

                $.ajax({
                    type: "Get",
                    url: localStorage.getItem('url'),
                    datatype: 'JSON',
                    success: function(data) {
                        console.log(data);


                        if (status) {
                            data.queryData.forEach(boula => {

                                alert($('#table').closest('.count'));
                                console.log('boula', boula);
                                $('#jsonResult').append(
                                    `<button class='w-25 btn btn-outline-secondary showRow exec' id='btn${boula.id}'>show ${boula.id}</button>`
                                );

                                if ('btn' + boula.id == localStorage.getItem(
                                        'openedQueryId'))
                                    $('#jsonResult').append(
                                        `<div class="col-md-3" id="id${boula.id}">`
                                    );
                                else
                                    $('#jsonResult').append(
                                        `<div class="col-md-3 d-none" id="id${boula.id}">`
                                    );
                                Object.entries(boula).forEach(element => {
                                    $(`#id${boula.id}`).append(
                                        $("<p>").text(JSON.stringify(
                                            element
                                        )) // Set text content to avoid HTML parsing
                                    );
                                });
                                $('#jsonResult').append("<hr>");
                            });
                        } else {

                            data.data.forEach(boula => {
                                console.log('boula', boula);
                                $('#jsonResult').append(
                                    `<button class='w-25 btn btn-outline-secondary showRow' id='btn${boula.id}'>show ${boula.id}</button>`
                                );

                                if ('btn' + boula.id == localStorage.getItem(
                                        'openedQueryId'))
                                    $('#jsonResult').append(
                                        `<div class="col-md-3" id="id${boula.id}">`
                                    );
                                else
                                    $('#jsonResult').append(
                                        `<div class="col-md-3 d-none" id="id${boula.id}">`
                                    );
                                Object.entries(boula).forEach(element => {
                                    $(`#id${boula.id}`).append(
                                        $("<p>").text(JSON.stringify(
                                            element
                                        )) // Set text content to avoid HTML parsing
                                    );
                                });
                                $('#jsonResult').append("<hr>");
                            });
                        }


                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });

                localStorage.setItem('openedQueryId', $(this).attr('id'));
                if ($(this).next().hasClass('d-none')) {
                    $(".showRow").each(function() {
                        $(this).next().addClass('d-none');
                    });
                    $(this).next().removeClass('d-none');
                }
            });


            $('#allResults').on('click', function() {
                if ($(this).text() == 'Show All') {
                    $(this).text('Hide All')
                    $(".showRow").each(function() {
                        $(this).next().removeClass('d-none');
                    });
                } else {
                    $(this).text('Show All');
                    $(".showRow").each(function() {
                        $(this).next().addClass('d-none');
                    });

                }
            });
            $('#resetDB').on('click', function() {
                $('#addFormStyle').removeAttr('style');
                $('#allResults').addClass('d-none');
                $('#refresh').addClass('d-none');


                $(".toggleRelation").each(function() {
                    $(this).next().addClass('d-none');

                });
                $(".letter").each(function() {
                    $(this).next().addClass('d-none');

                });

                $('#jsonResult').empty();
            });
            $(".letter").each(function() {
                $(this).bind("click", function(event) {
                    $('#allResults').text('Show All');
                    //$(".letter").each(function() {
                    //   $(this).next().addClass('d-none');

                    // });

                    $('#jsonResult').empty();
                    if ($(this).next().hasClass('d-none')) {
                        // $(".letter").next().addClass('d-none');
                        $(this).next().removeClass('d-none');
                    } else {
                        $(this).next().addClass('d-none');
                    }
                });
            });


            $('#refresh').on("click", function(event) {


                $('#allResults').text('Show All');
                $('#allResults').removeClass('d-none');
                $('#refresh').removeClass('d-none');
                $(this).next().removeClass('d-none');
                $('#jsonResult').empty();
                let db = $("#dbname").attr('dbname');
                let table = $(this).attr('table');
                let url = "{{ route('db.data', [':db', ':table', ':query']) }}";

                $.ajax({
                    type: "Get",
                    url: localStorage.getItem('url', url),
                    datatype: 'JSON',
                    success: function(data) {
                        console.log(data);
                        data.data.forEach(boula => {
                            console.log('boula', boula);
                            $('#jsonResult').append(
                                `<button class='w-25 btn btn-outline-secondary showRow' id='btn${boula.id}'>show ${boula.id}</button>`

                            );
                            if ('btn' + boula.id == localStorage.getItem(
                                    'openedQueryId'))
                                $('#jsonResult').append(
                                    `<div class="col-md-3" id="id${boula.id}">`
                                );
                            else
                                $('#jsonResult').append(
                                    `<div class="col-md-3 d-none" id="id${boula.id}">`
                                );
                            Object.entries(boula).forEach(element => {
                                $(`#id${boula.id}`).append(
                                    $("<p>").text(JSON.stringify(
                                        element
                                    )) // Set text content to avoid HTML parsing
                                );
                            });
                            $('#jsonResult').append("<hr>");
                        });

                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            });

            $(".toggleRelation").each(function() {
                $(this).bind("click", function(event) {
                    $('#allResults').text('Show All');
                    localStorage.removeItem('query');
                    $('#addFormStyle').attr('style', 'margin-left: 900px !important;');
                    $('#allResults').removeClass('d-none');
                    $('#refresh').removeClass('d-none');
                    $(this).next().removeClass('d-none');
                    $('#jsonResult').empty();
                    let db = $("#dbname").attr('dbname');
                    let table = $(this).attr('table');
                    let count = $(this).closest('.count');
                    let url = "{{ route('db.data', [':db', ':table', ':query']) }}"
                    url = url.replace(':db', db);
                    url = url.replace(':table', table);
                    url = url.replace(':query', localStorage.getItem('query'));
                    localStorage.setItem('url', url);

                    $.ajax({
                        type: "Get",
                        url: url,
                        datatype: 'JSON',
                        success: function(data) {
                            $('#' + table).text('(' + data.count + ')');
                            $('#queryCommand').text(data.insertString);


                            //  let keys=Object.keys(data.data[0]);
                            data.data.forEach(boula => {
                                console.log('boula', boula);
                                $('#jsonResult').append(
                                    `<button class='w-25 btn btn-outline-secondary showRow' id='btn${boula.id}'>show ${boula.id}</button>`
                                );
                                if ('btn' + boula.id == localStorage.getItem(
                                        'openedQueryId'))
                                    $('#jsonResult').append(
                                        `<div class="col-md-3" id="id${boula.id}">`
                                    );
                                else
                                    $('#jsonResult').append(
                                        `<div class="col-md-3 d-none" id="id${boula.id}">`
                                    );
                                Object.entries(boula).forEach(element => {
                                    $(`#id${boula.id}`).append(
                                        $("<p>").text(JSON
                                            .stringify(element)
                                        ) // Set text content to avoid HTML parsing
                                    );
                                });
                                $('#jsonResult').append("<hr>");
                            });

                        },
                        error: function(reject) {
                            console.log(reject);
                        }
                    });
                });
            });

            $('#print').hide().attr('required', false);
            $('#btnPrint').on('click', function(e) {
                $('#print').show().attr('placeholder', 'Enter print');
                $(this).hide().attr('required', false);
                $('#reultContent1').hide().attr('required', false);
                $('#reultContent2').hide().attr('required', false);
            });
            $('#print').on('input', function(e) {
                $(this).addAttr('readonly');
            });



            $("form").each(function() {
                $(this).bind("submit", function(event) {
                    if ($(this).hasClass('flag')) {
                        event.preventDefault();
                        let formData = new FormData(this);
                        var id = $(this).attr('id');
                        let url = "{{ route('actions.destroy', ':id') }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: (response) => {
                                $(this).remove();

                                toastNow();


                            },
                            error: function(response) {

                            }
                        });


                    } else if ($(this).hasClass('script')) {
                        event.preventDefault();
                        let formData = new FormData(this);
                        var id = $(this).attr('id');
                        let url = "{{ route('delete.scripts', ':id') }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: (response) => {
                                $(this).prev().remove();
                                $(this).remove();

                                toastNow();


                            },
                            error: function(response) {

                            }
                        });


                    } else if ($(this).hasClass('module')) {
                        event.preventDefault();
                        let formData = new FormData(this);
                        var id = $(this).attr('id');
                        let url = "{{ route('remove.projects', ':id') }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: (response) => {
                                $(this).prev().remove();
                                $(this).remove();

                                toastNow();


                            },
                            error: function(response) {

                            }
                        });


                    }

                });

            });

            $("option").each(function(e) {
                if ($(this).text() == localStorage.getItem('selectAction'))
                    $(this).attr('selected', true);
            });

            showSelectedActionInputs();


        });
    </script>



    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result +
                                "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\">Remove image</span>" +
                                "</span>").insertAfter("#files");
                            $(".remove").click(function() {
                                $(this).parent(".pip").remove();
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });
    </script>

    <script>
        $('img').on('click', function(e) {
            navigator.clipboard.writeText($(this).attr('alt'));
            toastNow();

        })
    </script>



    <script>
        $(document).ready(function() {
            // Attach click event handler to all next siblings of checkbox inputs
            $(':checkbox').each(function() {
                // Store reference to the current checkbox
                var checkbox = $(this);
                // Attach click event handler to the next sibling
                checkbox.next().click(function() {
                    // Toggle the checked state of the checkbox when the next sibling is clicked
                    checkbox.click();
                });
            });
        });
    </script>


    <script>
        // $(document).ready(function(){
        //     // Attach a click event handler to all buttons
        //     $('button').click(function(){
        //         // Send AJAX request to the route for logging clicks
        //         $.ajax({
        //             url: "{{ route('times.create') }}",
        //             type: "POST",
        //             dataType: "json",
        //             data: {
        //                 _token: "{{ csrf_token() }}"
        //             },
        //             success: function(response) {
        //                 console.log(response);
        //             },
        //             error: function(xhr) {
        //                 console.log(xhr.responseText);
        //             }
        //         });
        //     });
        // });
    </script>









    <script>
        $('.browse').on('click', function(e) {
            e.preventDefault();
            navigator.clipboard.writeText($(this).attr('content'));
            toastNow();

        });
    </script>


    <script>
        $(document).ready(function() {


            $(document).on('submit', '#issueForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'post',
                    url: "{{ route('issues.update') }}",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastNow();

                        } else {
                            $('#successMsg').text('');
                            $.each(response.errors, function(key, value) {
                                $('#' + key + 'Error').text(value);
                            });
                        }
                    }
                });
            });
        });
    </script>




    <script>
        $(document).ready(function() {
            $(document).on('submit', '#serverForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'post',
                    url: "{{ route('servers.update') }}",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastNow();

                        } else {
                            $('#successMsg').text('');
                            $.each(response.errors, function(key, value) {
                                $('#' + key + 'Error').text(value);
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            // Summernote
            $('.summernote').summernote({
                height: 300, // set the height of the editor
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // CodeMirror
            // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            //     mode: "htmlmixed",
            //     theme: "monokai"
            // });
        });
    </script>


    <script>
        $('.copyServer').on('click', function(e) {
            navigator.clipboard.writeText($(this).attr('content'));
            toastNow();

        });
    </script>


    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "paging": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        $(document).on('click', '.clickable-text', function(e) {
            navigator.clipboard.writeText($(this).attr('content'));
            toastNow();

        });
    </script>
    <script>
        $(document).on('click', '.clickable-text-db', function(e) {
            let content = $(this).attr('content'); // Retrieve the 'content' attribute

            // Check if content is valid before proceeding
            if (content) {
                // Split the content by underscores
                let parts = content.split('_');

                // Take only the first two parts
                let firstTwoParts = parts.slice(0, 2);

                // Join the first two parts with '.*' to match any characters in between
                let modifiedPattern = firstTwoParts.join('.*');

                // Create dynamic plural and singular forms
                let singularForm = modifiedPattern.replace(/ies$/, '').replace(/es$/,
                        '') // For words ending in 'ies'
                    .replace(/s$/, ''); // Remove the last 's' for general pluralization

                let searchPattern = `${singularForm}`; // Match both singular and plural

                // Build the 'dir' command to include files matching the pattern, excluding vendor
                let findCommand =
                    `dir /S /B | findstr /R /I "${searchPattern}.*\\.php" | findstr /V /I "\\vendor\\\\"`;

                // Copy the 'dir' command to the clipboard
                navigator.clipboard.writeText(content).then(() => {
                    toastNow(); // Trigger the notification after copying
                });
            } else {
                console.error('Content attribute is missing or undefined.');
            }
        });
    </script>












    <script>
        $(document).ready(function() {



            // Initial update with default values or values from localStorage
            var lastAttributeInput = localStorage.getItem('lastAttributeInput');
            var lastModuleInput = localStorage.getItem('lastModuleInput');
            $('#attributeInput').val(lastAttributeInput || 'attribute');
            $('#moduleInput').val(lastModuleInput || 'module');
            updateContentAttributes();

            // Function to update the content attributes
            function updateContentAttributes() {
                var attributeValue = $('#attributeInput').val();
                var moduleValue = $('#moduleInput').val();

                $(".clickable-text").each(function() {
                    var newContent = $(this).attr("content").replace(new RegExp("attribute", 'gi'),
                        attributeValue).replace(new RegExp("module", 'gi'), moduleValue);
                    $(this).attr("content", newContent);
                });
            }

            function updateContentAttributes2() {
                var attributeValue = $('#attributeInput').val();
                var moduleValue = $('#moduleInput').val();

                $(".clickable-text").each(function() {
                    var newContent = $(this).attr("content").replace(new RegExp(localStorage.getItem(
                            'lastAttributeInput'), 'gi'),
                        attributeValue).replace(new RegExp(localStorage.getItem('lastModuleInput'),
                        'gi'), moduleValue);
                    $(this).attr("content", newContent);
                });
            }

            // Function to handle input changes and save to localStorage
            $('#attributeInput').on('change', function() {
                updateContentAttributes2();
                localStorage.setItem('lastAttributeInput', $(this).val());
            });

            $('#moduleInput').on('change', function() {
                updateContentAttributes2();
                localStorage.setItem('lastModuleInput', $(this).val());
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to replace "reresources" with "resources" and "rerc" with "src"
            function replaceStrings() {
                // Replace in attribute values (e.g., src, href, data-* attributes)
                $('*[rerc], *[reresources]').each(function() {
                    $.each(this.attributes, function() {
                        if (this.specified) {
                            this.value = this.value.replace(/reresources/g, 'resources')
                                .replace(
                                    /rerc/g, 'src');
                        }
                    });
                });

                // Replace in all text nodes
                $('*').contents().filter(function() {
                    return this.nodeType === Node.TEXT_NODE;
                }).each(function() {
                    this.nodeValue = this.nodeValue.replace(/reresources/g, 'resources').replace(
                        /rerc/g,
                        'src');
                });
            }

            // Run the replace function
            replaceStrings();
        });
    </script>


<script>
    $(document).on('change', '#tablename', function() {
        let dbname = $('#db_name').val();
        let tablename = $('#tablename').val();

        if (dbname && tablename) {
            $.ajax({
                url: '{{route("getTableColumns")}}', // Adjust this route according to your setup
                method: 'POST',
                data: {
                    dbname: dbname,
                    tablename: tablename,
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    if (response.columns && response.dataTypes) {
                        $('#attributes').val(response.columns);
                        $('#attrtypes').val(response.dataTypes);
                        // console.log('Columns:', response.columns);
                        // console.log('Data Types:', response.dataTypes);
                        // // You can handle these strings as needed
                    }
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr.responseJSON?.error);
                }
            });
        } else {
            console.error('Database name and table name must be provided');
        }
    });
</script>





@if (boula() || App::environment('local'))
    <audio id="alarmSound" src="{{ asset('alarm.mp3') }}" preload="auto"></audio>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
          let alarm = document.getElementById("alarmSound");
          let lastPlayedHour = null; // Store last played hour to prevent re-triggering
          
          function checkTime() {
              const now = new Date();
              const currentHour = now.getHours();
              const minutes = now.getMinutes();
              const seconds = now.getSeconds();

              // Play alarm only at the start of an hour and prevent multiple triggers
              if (minutes === 0 && seconds === 0 && lastPlayedHour !== currentHour) {
                  lastPlayedHour = currentHour; // Update last played hour
                  localStorage.setItem('lastPlayedHourAdmin',lastPlayedHour);
                  alarm.volume = 1; 
                  alarm.play().catch(error => console.error("Playback failed:", error));
                  localStorage.setItem("failed", error);

              }
          }

          setInterval(checkTime, 1000); // Check every second
      });
  </script>
@endif



    @stack('js')
