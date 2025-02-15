    @extends('admin.layouts.master')

    @section('content')
        <style>
            .fullscreen-mode .sidebar,
            .fullscreen-mode .navbar,
            .fullscreen-mode .card-header .btn,
            .fullscreen-mode .content-wrapper .thisForm>*:not(.container) {
                display: none !important;
            }
        </style>




            <!-- Content Wrapper. Contains task content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <div class="container p-3">
                    <section class="content pt-2">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-12">
                                    <!-- general form elements -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-start">
                                                    @if (request()->routeIs('tasks.index'))
                                                        <h1 class="card-title fw-bold">@lang('general.tasks')</h1>
                                                    @elseif(request()->routeIs('tasks.all'))
                                                        <h1 class="card-title fw-bold">@lang('general.alltasks')</h1>
                                                    @else
                                                        <h1 class="card-title fw-bold">@lang('general.finishedTasks')</h1>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 d-flex justify-content-end">
                                                    <a href="{{ route('tasks.create') }}">
                                                        <button class="btn btn-outline-primary px-5">
                                                            <i class="fa fa-plus fa-sm px-2" aria-hidden="true"></i>
                                                            @lang('general.add')
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="">
                                                <button class="btn btn-outline-secondary px-5" id="toggle-fullscreen">
                                                    <i class="fa fa-expand" aria-hidden="true"></i> Full Screen
                                                </button>

                                            </div>
                                            <form action="{{ route('tasks.bulkAction') }}" method="POST">
                                                @csrf
                                                <div class="row d-flex align-items-center thisForm">
                                                    {{-- Dynamic Select Input --}}
                                                    <div class="col-md-4 mb-4">
                                                        <label
                                                            class="col-form-label text-right">{{ __('general.employees') }}</label>
                                                        <select class="form-control selectpicker" id="multiSelect1"
                                                            multiple="multiple" data-live-search="true" name="employees[]">
                                                            <option value="">{{ __('general.select') }}</option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{ $employee->id }}"
                                                                    {{ collect(old('employees'))->contains($employee->id) ? 'selected' : '' }}>
                                                                    {{ $employee->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- Dynamic Select Input --}}
                                                    <div class="col-md-4 mb-4">
                                                        <label
                                                            class="col-form-label text-right">{{ __('general.projects') }}</label>
                                                        <select class="form-control selectpicker" id="multiSelect1"
                                                            multiple="multiple" data-live-search="true" name="projects[]">
                                                            <option value="">{{ __('general.select') }}</option>
                                                            @foreach ($projects as $project)
                                                                <option value="{{ $project->id }}"
                                                                    {{ collect(old('projects'))->contains($project->id) ? 'selected' : '' }}>
                                                                    {{ $project->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <input type="hidden" name="route_name" value="{{ isset($type)?$type:Route::currentRouteName() }}">

                                                    <div class="col-md-4">
                                                        <div class="">
                                                            <button type="submit" name="action" value="assign"
                                                                class="btn btn-primary">
                                                                @lang('general.assign_employee')
                                                            </button>

                                                        </div>
                                                        <div class="mt-2">
                                                            <button type="submit" name="action" value="delete"
                                                                class="btn btn-danger">
                                                                @lang('general.delete_tasks')
                                                            </button>
                                                        </div>
                                                        <div class="mt-2">
                                                            <button type="submit" name="action" value="filterProject"
                                                                class="btn btn-success">
                                                            {{ __('general.filter_projects') }}
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <table id="example1" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>
                                                                {{ __('general.title') }}
                                                            </th>
                                                            <th>{{__('general.level')}}</th>
                                                            <th>{{__('general.counter')}}</th>
                                                                <th>{{__('general.piority')}}</th>
                                                            <th>{{ __('general.project') }}</th>
                                                            <th>{{ __('general.employees') }}</th>
                                                            <th>{{ __('general.actions') }}</th>
                                                            <th class="d-none">{{ __('general.select') }}</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tasks as $task)
                                                            <tr>
                                                                <td>{{ $task->id }}</td>

                                                                <td class="{{ request()->routeIs('tasks.all') && $task->status == 1 ? 'text-success' : '' }} identified"
                                                                    style="cursor: pointer; white-space: normal; word-wrap: break-word; word-break: break-word; width: 500px;"
                                                                    onclick="toggleCheckbox({{ $task->id }})">
                                                                    {{ $task->title }}
                                                                </td>

                                                                <td class="toggleLevel" style="cursor: pointer" id="{{$task->id}}">{{$task->level?'mobile':'pc' }}</td>
                                                                <td class="counter" data-task-id="{{ $task->id }}" data-counter="{{ $task->counter }}" style="cursor: pointer;">
                                                                    {{ $task->counter }}
                                                                </td>
                                                                <td class="togglePiority" style="cursor: pointer" id="{{$task->id}}">{{$task->pority?'Important':'Normal' }}</td>
                                                                <td>{{ isset($task->project->title) ? $task->project->title:'None' }}</td>
                                                                <td>{{ taskEmployees($task->title) }}</td>
                                                                
                                                                <td>
                                                                    <a href="{{ route('tasks.edit', $task) }}" title="edit">
                                                                        <i class="fas fa-edit  text-secondary  fa-lg"></i>
                                                                    </a>
                                                                    
                                                                    <button class="btn btn-outline-secondary btn-sm mx-1"
                                                                    data-toggle="modal" data-target="#keywordsModal"
                                                                    data-task-id="{{ $task->id }}"
                                                                    data-keywords="{{ $task->keywords }}"
                                                                    data-task-title="{{ $task->title }}" type="button">
                                                                    <i class="fas fa-key fa-lg"></i>
                                                                </button>
                                                                
                                                                <button
                                                                class="btn btn-outline-secondary btn-sm copy-keywords clickable-text"
                                                                content="{{ $task->keywords }}" type="button"
                                                                data-keywords="{{ $task->keywords }}"
                                                                title="@lang('general.copy_keywords')">
                                                                <i class="fas fa-copy"></i>
                                                            </button>
                                                            
                                                        </td>
                                                        <td class="d-none">
                                                            <input type="checkbox" name="tasks[]"
                                                                value="{{ $task->id }}"
                                                                id="checkbox-{{ $task->id }}">
                                                        </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                </div>
                <!-- /.content -->
            </div>


            <div class="modal fade" id="keywordsModal" tabindex="-1" aria-labelledby="keywordsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="keywordsModalLabel">@lang('general.edit_keywords')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="keywordsForm"  method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="task_id" id="taskId">
                                <div class="form-group">
                                    <label for="taskKeywords">@lang('general.keywords')</label>
                                    <textarea class="form-control" name="keywords" id="taskKeywords" rows="20" placeholder="@lang('general.enter_keywords')"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('general.close')</button>
                                <button type="submit" class="btn btn-primary">@lang('general.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- /.content-wrapper -->
    @endsection


    <audio id="alarmSound" src="{{asset('work.mp3')}}"></audio>
    <audio id="successSound" src="{{asset('work.mp3')}}"></audio>
    <audio id="errorSound" src="{{asset('work.mp3')}}"></audio>
    
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const counters = document.querySelectorAll(".counter");
            const alarmSound = document.getElementById("alarmSound");
            const successSound = document.getElementById("successSound");
            const errorSound = document.getElementById("errorSound");
    
            let userInteracted = false;
    
            // Detect user interaction
            document.body.addEventListener("click", function () {
                userInteracted = true;
            });
    
            function playSound(sound) {
                if (userInteracted) {
                    sound.play().catch(error => console.error("Audio play failed:", error));
                }
            }
    
            counters.forEach(counter => {
                const taskId = counter.getAttribute("data-task-id");
                let storedTime = localStorage.getItem(`counter-${taskId}`);
                let startTime = localStorage.getItem(`counter-start-${taskId}`);
    
                if (storedTime !== null && startTime !== null) {
                    let elapsed = Math.floor((Date.now() - parseInt(startTime)) / 1000);
                    let remainingTime = Math.max(0, parseInt(storedTime) - elapsed);
    
                    counter.textContent = formatTime(remainingTime);
                    if (remainingTime > 0) {
                        startCountdown(taskId, counter, remainingTime);
                    } else {
                        localStorage.removeItem(`counter-${taskId}`);
                        localStorage.removeItem(`counter-start-${taskId}`);
                    }
                }
    
                counter.addEventListener("click", function () {
                    let minutes = parseInt(counter.getAttribute("data-counter"));
                    let seconds = minutes * 60;
    
                    localStorage.setItem(`counter-${taskId}`, seconds);
                    localStorage.setItem(`counter-start-${taskId}`, Date.now());
    
                    startCountdown(taskId, counter, seconds);
                });
            });
    
            function startCountdown(taskId, counter, seconds) {
                clearInterval(counter.dataset.intervalId);
    
                let interval = setInterval(() => {
                    if (seconds <= 0) {
                        clearInterval(interval);
                        localStorage.removeItem(`counter-${taskId}`);
                        localStorage.removeItem(`counter-start-${taskId}`);
                        counter.textContent = "00:00";
    
                        // Play alarm sound if user has interacted
                        playSound(alarmSound);
    
                        return;
                    }
    
                    seconds--;
                    counter.textContent = formatTime(seconds);
                    localStorage.setItem(`counter-${taskId}`, seconds);
                    localStorage.setItem(`counter-start-${taskId}`, Date.now());
                }, 1000);
    
                // Send a GET request every minute
                let ajaxInterval = setInterval(() => {
                    sendAjaxUpdate(taskId, seconds);
                }, 60000);
    
                counter.dataset.intervalId = interval;
                counter.dataset.ajaxIntervalId = ajaxInterval;
            }
    
            function formatTime(seconds) {
                let min = Math.floor(seconds / 60);
                let sec = seconds % 60;
                return `${String(min).padStart(2, "0")}:${String(sec).padStart(2, "0")}`;
            }
    
            function sendAjaxUpdate(taskId, remainingTime) {
                const url = `{{ route('counter.update') }}?task_id=${taskId}&counter=${remainingTime / 60}`;
    
                fetch(url, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(`Task ${taskId} updated successfully:`, data);
                        playSound(successSound); // Play success sound
                    })
                    .catch(error => {
                        console.error(`Error updating task ${taskId}:`, error);
                        playSound(errorSound); // Play error sound
                    });
            }
        });
    </script>
    @endpush
    

    @push('scripts')


    <script>
        $('.toggleLevel').on('click', function (e) {
            let self = $(this); // Reference to the clicked element
            let level = self.attr('id'); // Get the level ID
            
            $.ajax({
                url: `{{ route('level.toggle', '') }}/${level}`, // Generate the correct route
                type: 'GET', // HTTP method
                success: function (response) {
                    // Toggle the HTML content based on current value
                    if (self.html() == 'mobile') {
                        self.html('pc');
                    } else {
                        self.html('mobile');
                    }
                    console.log(response); // Log the success response
                },
                error: function (xhr, status, error) {
                    console.log("Error: " + error); // Log the error
                }
            });
        });
    </script>

    <script>
        $('.togglePiority').on('click', function (e) {
            let self = $(this); // Reference to the clicked element
            let level = self.attr('id'); // Get the level ID
            
            $.ajax({
                url: `{{ route('piority.toggle', '') }}/${level}`, // Generate the correct route
                type: 'GET', // HTTP method
                success: function (response) {
                    // Toggle the HTML content based on current value
                    if (self.html() == 'Important') {
                        self.html('Normal');
                    } else {
                        self.html('Important');
                    }
                    console.log(response); // Log the success response
                },
                error: function (xhr, status, error) {
                    console.log("Error: " + error); // Log the error
                }
            });
        });
    </script>



        <script>

    $(document).ready(function () {
        // Include CSRF token in all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#keywordsForm').submit(function (event) {
            event.preventDefault();
            
            // Serialize form data
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route("tasks.updateKeywords") }}',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-right' : 'toast-top-left'}}",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };

                        toastr.success("Updated successfully!");
                    } else {
                        // Handle validation errors
                        $('#successMsg').text('');
                        $.each(response.errors, function (key, value) {
                            $('#' + key + 'Error').text(value);
                        });
                    }
                }
            });
        });
    });

            
            $(document).ready(function() {
                const keywordsModal = $('#keywordsModal');

                // Load task title and keywords when the modal is shown
                keywordsModal.on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const taskId = button.data('task-id');
                    const taskTitle = button.data('task-title'); // Get task title
                    const savedKeywords = localStorage.getItem(`task_keywords_${taskId}`);

                    // Update modal title
                    $('#keywordsModalLabel').text(taskTitle);

                    $('#taskId').val(taskId);
                    $('#taskKeywords').val(savedKeywords || button.data('keywords') || '');
                });

                // Save keywords to localStorage on change
                $('#taskKeywords').on('input', function() {
                    const taskId = $('#taskId').val();
                    const keywords = $(this).val();
                    localStorage.setItem(`task_keywords_${taskId}`, keywords);
                });
            });



            document.getElementById('toggle-fullscreen').addEventListener('click', function() {
                document.body.classList.toggle('fullscreen-mode');

                const icon = this.querySelector('i');
                icon.classList.toggle('fa-expand');
                icon.classList.toggle('fa-compress');
                this.textContent = icon.classList.contains('fa-expand') ? ' Full Screen' : ' Exit Full Screen';
            });


            $(document).ready(function() {
                // Function to load the value into the search input and trigger search
                function loadSearchValue() {
                    if (localStorage.getItem('searchValue')) {
                        const $searchInput = $('input[type="search"]');
                        $searchInput.val(localStorage.getItem('searchValue'));
                        $searchInput.trigger('input'); // Trigger the input event to start the search
                    }
                }

                // Check for the input field's existence every 500ms
                const interval = setInterval(function() {
                    if ($('input[type="search"]').length > 0) {
                        loadSearchValue();
                        clearInterval(interval); // Stop checking once the input is found
                    }
                }, 500);

                // Save the value to localStorage whenever the input value changes
                $(document).on('input', 'input[type="search"]', function() {
                    localStorage.setItem('searchValue', $(this).val());
                });
            });



            function isMobileDevice() {
            return /Android|iPhone|iPad|iPod|Windows Phone|webOS|BlackBerry/i.test(navigator.userAgent) || 
                window.matchMedia("(max-width: 768px)").matches;
        }

        if(isMobileDevice())

            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    columnDefs: [
                        {
                            targets: [2,3,4, 5,6], // Columns to hide on mobile
                            responsivePriority: 1, // Lower priority means it gets hidden first
                            visible: false, // Force hide
                        },
                        {
                            targets: [0, 1], // Columns that must always be visible
                            responsivePriority: 1, // Higher priority means it stays visible
                        }
                    ],
                    "lengthChange": false,
                    "autoWidth": false,
                    "paging": false,
                    "searching": true,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });

            else
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "paging": false,
                    "searching": true,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });

            function toggleCheckbox(taskId) {
                const checkbox = document.getElementById(`checkbox-${taskId}`);
                const taskRow = $(`#checkbox-${taskId}`).closest('tr').find('.identified');

                checkbox.checked = !checkbox.checked;

                if (checkbox.checked) {
                    taskRow.css('background-color', 'yellow');
                    taskRow.css('color', 'black');
                } else {
                    taskRow.css('background-color', '');
                    taskRow.css('color', '');
                }
            }
        </script>
    @endpush
