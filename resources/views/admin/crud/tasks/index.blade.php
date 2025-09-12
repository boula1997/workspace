    @extends('admin.layouts.master')

    @section('content')
        <style>
            .fullscreen-mode .sidebar,
            .fullscreen-mode .navbar,
            .fullscreen-mode .card-header .btn,
            .fullscreen-mode .content-wrapper .thisForm>*:not(.container) {
                display: none !Active;
            }

            .employee-column {
                max-width: 120px;
                /* or whatever fits */
                white-space: normal;
                /* allow wrapping */
                word-break: break-word;
                /* break long words */
                vertical-align: top;
                /* align names to top */
            }
        </style>




        <!-- Content Wrapper. Contains task content -->
        <div class="content-wrapper">
            @if (boula())
                <button type="button" id="readAllTitles" class="btn btn-success  mx-2 my-2">Read</button>

                <button id="stopReadingButton">Stop Reading for 60 Minutes</button>
            @endif
            <!-- Main content -->
            <div class="container-fluid">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start">
                                @if (request()->route('taskType') == 'task')
                                    <h1 class="card-title fw-bold">@lang('general.tasks') (You can order rows by
                                        dragging from third column)</h1>
                                @elseif(request()->route('taskType') == 'alltasks')
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
                        <form action="{{ route('tasks.bulkAction', ['taskType' => request()->route('taskType')]) }}"
                            method="POST">

                            @csrf
                            <div class="row d-flex align-items-center thisForm">


                                {{-- Dynamic Select Input for Employees --}}
                                <div class="col-md-4 mb-4">
                                    <label class="col-form-label text-right">{{ __('general.employees') }}</label>
                                    <select class="form-control select2" id="multiSelectEmployees" multiple="multiple"
                                        name="employees[]">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ collect(old('employees', $employeeIds))->contains($employee->id) ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Dynamic Select Input for Projects --}}
                                <div class="col-md-4 mb-4">
                                    <label class="col-form-label text-right">{{ __('general.projects') }}</label>
                                    <select class="form-control select2 bg-dark" id="multiSelectProjects"
                                        multiple="multiple" name="projects[]">
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ collect(old('projects', []))->contains($project->id) ? 'selected' : '' }}>
                                                {{ $project->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="col-form-label text-right">{{ __('general.type') }}</label>

                                    {{-- Dynamic Select Input for Projects --}}
                                    <select class="form-control select2 bg-dark" name="taskType" id="taskTypeSelect">
                                        <option value="tasks" selected>tasks</option>
                                        <option value="finishedTasks">finishedTasks</option>
                                        <option value="allTasks">allTasks</option>
                                    </select>
                                </div>







                                <input type="hidden" name="route_name"
                                    value="{{ isset($type) ? $type : Route::currentRouteName() }}">

                                <div class="col-md-4">
                                    <div class="">
                                        <button type="submit" name="action" value="assign" class="btn btn-primary">
                                            @lang('general.assign_employee')
                                        </button>

                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" name="action" value="delete" class="btn btn-danger">
                                            @lang('general.delete_tasks')
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" name="action" value="filterProject" class="btn btn-success">
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

                                        <th>{{ __('general.employees') }}</th>
                                        <th>{{ __('general.project') }}</th>
                                        <th>{{ __('general.piority') }}</th>
                                        @if (boula())
                                            <th>{{ __('general.level') }}</th>
                                        @endif
                                        {{-- <th>{{ __('general.counter') }}</th> --}}

                                        <th>{{ __('general.actions') }}</th>
                                        <th class="d-none">{{ __('general.select') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>

                                            <td class="clickable-text {{ request()->routeIs('tasks.all') && $task->status == 1 ? 'text-success' : '' }} identified"
                                                style="cursor: pointer; white-space: normal; word-wrap: break-word; word-break: break-word; width: 500px;"
                                                onclick="toggleCheckbox({{ $task->id }})"
                                                content="{{ $task->title }}" data-title="{{ $task->title }}">
                                                {{ $task->title }}
                                            </td>

                                            <td class="employee-column">{!! taskEmployees($task->title) !!}</td>


                                            <td>{{ isset($task->project->title) ? $task->project->title : 'None' }}
                                            </td>
                                            <td data-title="{{ $task->title }}" class="togglePiority"
                                                data-order="{{ $task->piority ? 1 : 0 }}"
                                                style="cursor: pointer;
                                                                    background-color: {{ $task->piority ? 'green' : 'yellow' }};
                                                                    color: {{ $task->piority ? 'white' : 'black' }};"
                                                id="{{ $task->id }}">
                                                {{ $task->piority ? 'Active' : 'Pending' }}
                                            </td>
                                            @if (boula())
                                                <td class="toggleLevel" style="cursor: pointer" id="{{ $task->id }}">
                                                    {{ $task->level ? 'Bed' : 'Office' }}
                                                </td>
                                            @endif
                                            {{-- <td class="counter" data-task-id="{{ $task->id }}"
                                                                data-counter="{{ $task->counter }}"
                                                                style="cursor: pointer;">
                                                                {{ $task->counter }}
                                                            </td> --}}


                                            <td>
                                                @if (isset($task->created_at))
                                                    <a href="{{ route('tasks.edit', $task) }}" title="edit">
                                                        <i class="fas fa-edit  text-secondary  fa-md"></i>
                                                    </a>

                                                    <button class="btn btn-secondary btn-sm mx-1 btn-icon"
                                                        data-toggle="modal" data-target="#keywordsModal"
                                                        data-task-id="{{ $task->id }}"
                                                        data-keywords="{{ $task->keywords }}"
                                                        data-task-title="{{ $task->title }}" type="button">
                                                        <i class="fas fa-key fa-md"></i>
                                                    </button>

                                                    <button
                                                        class="btn sbtn-secondary btn-sm deleteTask delete-icon btn-icon"
                                                        type="button" data-keywords="{{ $task->keywords }}"
                                                        title="@lang('general.delete')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif


                                            </td>
                                            <td class="d-none">
                                                <input type="checkbox" name="tasks[]" value="{{ $task->id }}"
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
            <!-- /.content -->
        </div>


        <div class="modal fade" id="keywordsModal" tabindex="-1" aria-labelledby="keywordsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="keywordsModalLabel">@lang('general.edit_keywords')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="keywordsForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="task_id" id="taskId">
                            <div class="form-group">
                                <label for="taskKeywords">@lang('general.keywords')</label>
                                <textarea class="form-control" name="keywords" id="taskKeywords" rows="20" placeholder="@lang('general.enter_keywords')"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">@lang('general.close')</button>
                            <button type="submit" class="btn btn-primary">@lang('general.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /.content-wrapper -->
    @endsection

    {{-- <audio id="alarmSound" src="https://yousab-tech.com/workspace/public/work.mp3"></audio>
    <audio id="alarmSound2" src="https://yousab-tech.com/workspace/public/hurry.mp3"></audio> --}}
    {{-- <audio id="successSound" controls>
        <source src="https://yousab-tech.com/workspace/public/work.mp3" type="audio/mpeg">
        <source src="https://yousab-tech.com/workspace/public/work.ogg" type="audio/ogg">
        Your browser does not support the audio element.
    </audio> <!-- FIXED: Added missing ">" here --> --}}
    {{-- <audio id="errorSound" src="https://yousab-tech.com/workspace/public/work.mp3"></audio> --}}



    @push('scripts')

        <script>
            $(document).ready(function() {
                var $select = $('#taskTypeSelect');
                var savedValue = localStorage.getItem('taskType');

                if (savedValue) {
                    $select.val(savedValue).trigger('change'); // set value AND trigger change event
                }

                $select.on('change', function() {
                    localStorage.setItem('taskType', $(this).val());
                });
            });
        </script>




        <script>
            $(document).ready(function() {
                // Get selected project IDs from localStorage
                let storedProjects = localStorage.getItem('selectedProjects');

                if (storedProjects) {
                    let selectedIds = JSON.parse(storedProjects); // convert to array

                    // Set the selected values in the select2 element
                    $('#multiSelectProjects').val(selectedIds).trigger('change');
                }

                // Save selection on change
                $('#multiSelectProjects').on('change', function() {
                    let selected = $(this).val(); // get array of selected values
                    localStorage.setItem('selectedProjects', JSON.stringify(selected));
                });

                // Initialize select2 (optional if already initialized)
                $('#multiSelectProjects').select2();
            });
        </script>



        <script>
            $(document).on('click', '.deleteTask', function() {
                // Get the closest table row to the clicked button and remove it
                $(this).closest('tr').remove();
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll("audio, video").forEach((el) => {
                    el.volume = 0.2; // Reduce volume to 20%
                });
            });
        </script>
        {{-- <script>
            document.addEventListener("DOMContentLoaded", function() {
                const counters = document.querySelectorAll(".counter");
                const alarmSound = document.getElementById("alarmSound");
                const alarmSound2 = document.getElementById("alarmSound2");
                const successSound = document.getElementById("successSound");
                const errorSound = document.getElementById("errorSound");

                function enableAudio(sound) {
                    sound.muted = true; // Play muted first
                    sound.play()
                        .then(() => {
                            sound.pause(); // Pause after playing
                            sound.muted = false; // Unmute for future playback
                        })
                        .catch(error => console.warn("Audio preload failed:", error));
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

                    counter.addEventListener("click", function() {
                        // Enable audio on user interaction
                        enableAudio(alarmSound);
                        enableAudio(alarmSound2);
                        enableAudio(successSound);
                        enableAudio(errorSound);

                        let minutes = parseInt(counter.getAttribute("data-counter"));
                        let seconds = minutes * 60;

                        localStorage.setItem(`counter-${taskId}`, seconds);
                        localStorage.setItem(`counter-start-${taskId}`, Date.now());

                        startCountdown(taskId, counter, seconds);
                    });
                });

                function startCountdown(taskId, counter, seconds) {
                    clearExistingIntervals(counter);

                    let interval = setInterval(() => {
                        if (seconds <= 0) {
                            clearExistingIntervals(counter);
                            counter.textContent = "00:00";
                            localStorage.removeItem(`counter-${taskId}`);
                            localStorage.removeItem(`counter-start-${taskId}`);

                            // Play alarm sound
                            alarmSound.play().catch(error => console.error("Audio play failed:", error));

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

                    // Store interval IDs to clear later
                    counter.dataset.intervalId = interval;
                    counter.dataset.ajaxIntervalId = ajaxInterval;
                }

                function clearExistingIntervals(counter) {
                    if (counter.dataset.intervalId) {
                        clearInterval(counter.dataset.intervalId);
                    }
                    if (counter.dataset.ajaxIntervalId) {
                        clearInterval(counter.dataset.ajaxIntervalId);
                    }
                }

                function formatTime(seconds) {
                    let min = Math.floor(seconds / 60);
                    let sec = seconds % 60;
                    return `${String(min).padStart(2, "0")}:${String(sec).padStart(2, "0")}`;
                }

                function sendAjaxUpdate(taskId, remainingTime) {

                    if (Math.floor(remainingTime / 60) == 1) {
                        alarmSound2.play().catch(error => console.error("Audio play failed:", error));
                    }
                    const url =
                        `{{ route('counter.update') }}?task_id=${taskId}&counter=${Math.floor(remainingTime / 60)}`;

                    fetch(url, {
                            method: "GET",
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status == 'success') {
                                console.log(`Task ${taskId} updated successfully:`, data);
                                successSound.play().catch(error => console.error("Audio play failed:", error));
                            } else {
                                localStorage.removeItem(`counter-${taskId}`);
                                localStorage.removeItem(`counter-start-${taskId}`);
                            }
                        })
                        .catch(error => {
                            console.error(`Error updating task ${taskId}:`, error);
                            errorSound.play().catch(error => console.error("Audio play failed:", error));
                        });
                }
            });
        </script> --}}
        @if (false)
            <script>
                let femaleVoice = null;
                let stopReading = false;
                let titleIndex = 0;
                let readInterval = null;
                let repeatCount = 0;
                let stopTimeout = null;
                let countdownInterval = null;
                let remainingTime = 0;
                let readingLoopActive = false;

                function setFemaleVoice() {
                    let voices = speechSynthesis.getVoices();
                    if (voices.length === 0) {
                        console.log("No voices available, retrying...");
                        speechSynthesis.onvoiceschanged = setFemaleVoice;
                        return;
                    }

                    femaleVoice = voices.find(voice =>
                            voice.lang.startsWith('en') && voice.name.toLowerCase().includes('female')
                        ) ||
                        voices.find(voice =>
                            voice.lang.startsWith('en') && voice.name.includes('Google')
                        ) ||
                        voices.find(voice => voice.lang.startsWith('en')) ||
                        voices[0];

                    console.log('Selected Voice:', femaleVoice ? femaleVoice.name : 'Not found');
                }

                document.addEventListener('DOMContentLoaded', () => {
                    console.log('DOM fully loaded and parsed.');
                    setTimeout(setFemaleVoice, 200);
                    readTitlesInSequence(); // Start reading
                    document.getElementById('readAllTitles').addEventListener('click', resumeReadingNow);
                    document.getElementById('stopReadingButton').addEventListener('click', stopReadingFor60Minutes);
                });

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

                function stopReadingFor60Minutes() {
                    stopReading = true;
                    remainingTime = 60 * 60;
                    clearTimeout(stopTimeout);
                    clearInterval(countdownInterval);

                    stopTimeout = setTimeout(() => {
                        stopReading = false;
                        console.log('Reading resumed after 60 minutes.');
                    }, 60 * 60 * 1000);

                    countdownInterval = setInterval(updateButtonCountdown, 1000);
                    console.log('Reading stopped for 60 minutes.');
                }

                function resumeReadingNow() {
                    stopReading = false;
                    clearTimeout(stopTimeout);
                    clearInterval(countdownInterval);
                    readingLoopActive = false; // allow new loop
                    document.getElementById('stopReadingButton').textContent = 'Stop Reading for 60 Minutes';
                    console.log('Reading resumed immediately.');
                    speechSynthesis.cancel();
                    readTitlesInSequence();
                }



                function readText(text) {
                    if (stopReading) {
                        console.log('Reading is currently stopped.');
                        return;
                    }

                    speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(text);
                    if (femaleVoice) {
                        utterance.voice = femaleVoice;
                    }

                    utterance.onstart = () => console.log("Speaking:", text);
                    utterance.onend = () => console.log("Finished speaking:", text);
                    utterance.onerror = (e) => console.error("Speech error:", e);

                    speechSynthesis.speak(utterance);
                }

                function readTitlesInSequence() {
                    if (stopReading || readingLoopActive) {
                        console.log('Reading is currently stopped or already running.');
                        return;
                    }

                    const titles = Array.from(document.querySelectorAll('.togglePiority'))
                        .filter(el => el.getAttribute('data-order') === '1')
                        .map(el => el.getAttribute('data-title'));

                    if (titles.length === 0) {
                        console.log('No active titles to read.');
                        return;
                    }

                    readingLoopActive = true; // prevent re-entrance
                    let current = 0;

                    function readNext() {
                        if (stopReading) {
                            console.log('Reading stopped.');
                            readingLoopActive = false;
                            return;
                        }

                        if (current >= titles.length) {
                            console.log('All titles read. Waiting 60 seconds...');
                            setTimeout(() => {
                                current = 0;
                                readNext(); // restart after 1 minute
                            }, 20 * 60 * 1000);
                            return;
                        }

                        const text = titles[current];
                        const utterance = new SpeechSynthesisUtterance(text);
                        if (femaleVoice) {
                            utterance.voice = femaleVoice;
                        }

                        utterance.onend = () => {
                            console.log(`Finished: ${text}`);
                            current++;
                            readNext();
                        };

                        utterance.onerror = (e) => {
                            console.error("Speech error:", e);
                            current++;
                            readNext();
                        };

                        console.log(`Speaking: ${text}`);
                        speechSynthesis.speak(utterance);
                    }

                    // Cancel any ongoing speech before starting
                    speechSynthesis.cancel();
                    readNext();
                }
            </script>
        @endif



    @endpush






    @push('scripts')
        <script>
            $('.toggleLevel').on('click', function(e) {
                let self = $(this); // Reference to the clicked element
                let level = self.attr('id'); // Get the level ID

                $.ajax({
                    url: `{{ route('level.toggle', '') }}/${level}`, // Generate the correct route
                    type: 'GET', // HTTP method
                    success: function(response) {
                        // Toggle the HTML content based on current value
                        self.html(response.data);

                        console.log(response); // Log the success response
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error); // Log the error
                    }
                });
            });
        </script>

        <script>
            $(function() {
                // ✅ Initialize the DataTable once
                var table = $("#example1").DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    paging: false,
                    searching: true,
                    // rowReorder: {
                    //     selector: 'td:nth-child(3)'
                    // },
                    // columnDefs: [{
                    //     targets: 2,
                    //     orderable: true
                    // }]
                });


                $('#example1').on('row-reorder', function(e, diff, edit) {
                    console.log('Row order changed');
                    console.log(diff);
                });

                // ✅ Handle priority toggle clicks
                $('#example1').on('click', '.togglePiority', function() {
                    let self = $(this);
                    let level = self.attr('id');

                    $.ajax({
                        url: `{{ route('piority.toggle', '') }}/${level}`,
                        type: 'GET',
                        success: function(response) {
                            if (self.html().trim() === 'Active') {
                                self.html('Pending');
                                self.attr('data-order', 0);
                                self.css({
                                    'background-color': 'yellow',
                                    'color': 'black'
                                });
                            } else {
                                self.html('Active');
                                self.attr('data-order', 1);
                                self.css({
                                    'background-color': 'green',
                                    'color': 'white'
                                });
                            }

                            // ✅ Re-evaluate the whole row to keep sorting/ordering working
                            let row = table.row(self.closest('tr'));
                            row.invalidate().draw(false);
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                        }
                    });
                });
            });
        </script>






        <script>
            $(document).ready(function() {
                // Include CSRF token in all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#keywordsForm').submit(function(event) {
                    event.preventDefault();

                    // Serialize form data
                    var formData = $(this).serialize();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('tasks.updateKeywords') }}',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "{{ app()->getLocale() == 'ar' ? 'toast-top-right' : 'toast-top-left' }}",
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
                                $.each(response.errors, function(key, value) {
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

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $('#readAllTitles').click();
                }, 10000); // 10000 milliseconds = 10 seconds
            });
        </script>
    @endpush
