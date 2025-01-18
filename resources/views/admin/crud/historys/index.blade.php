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


                                            <input type="hidden" name="route_name" value="{{ isset($type)?$type:Route::currentRouteName() }}">

                                            <div class="col-md-4">
                                                <div class="">
                                                    <button type="submit" name="action" value="reassign"
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
                                            </div>

                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <input type="text" id="projectFilter" class="form-control" placeholder="@lang('general.project')">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="employeeFilter" class="form-control" placeholder="@lang('general.employee')">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" id="startFrom" class="form-control" placeholder="@lang('general.start_from')">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" id="endTo" class="form-control" placeholder="@lang('general.end_to')">
                                            </div>
                                        </div>
                                        <table id="example1" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th style="width: 1500px !important;">{{ __('general.task') }}</th>
                                                    <th class="d-none">{{ __('general.select') }}</th>
                                                    <th>{{__('general.employee')}}</th>
                                                    <th>{{ __('general.project') }}</th>
                                                    <th>{{ __('general.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($historys as $history)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="{{ request()->routeIs('tasks.all') && $history->status == 1 ? 'text-success' : '' }}"
                                                            style="cursor: pointer; white-space: normal; word-wrap: break-word; word-break: break-word; width: 500px;"
                                                            onclick="toggleCheckbox({{ $history->task_id }})">
                                                            {{ $history->task->title }}
                                                        </td>
                                                        <td class="d-none">
                                                            <input type="checkbox" name="tasks[]"
                                                                value="{{ $history->task_id }}"
                                                                id="checkbox-{{ $history->task_id }}">
                                                        </td>
                                                        <td>{{ $history->employee->name }}</td>
                                                        <td>{{ $history->task->project->title }}</td>

                                                        <td>
                                                            <a href="{{ route('historys.edit', $history) }}" title="edit">
                                                                <i class="fas fa-edit  text-secondary  fa-lg"></i>
                                                            </a>




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




    <!-- /.content-wrapper -->
@endsection

@push('scripts')

<script>
    $(function() {
        const tableStateKey = "coursesTableState";

        var table = $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "stateSave": true,
            "stateLoadCallback": function(settings) {
                var savedState = localStorage.getItem(tableStateKey);
                return savedState ? JSON.parse(savedState) : null;
            },
            "stateSaveCallback": function(settings, data) {
                localStorage.setItem(tableStateKey, JSON.stringify(data));
            }
        });

        // Append DataTable buttons to container
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Filter logic
        $('#projectFilter').on('keyup', function() {
            table.columns(3).search(this.value).draw(); // project column
        });

        $('#employeeFilter').on('keyup', function() {
            table.columns(2).search(this.value).draw(); // Employee column
        });

        $('#startFrom, #endTo').on('change', function() {
            const start = $('#startFrom').val();
            const end = $('#endTo').val();

            // Custom filter for date range
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const createdAt = data[5]; // `created_at` column index
                if (start && createdAt < start) return false;
                if (end && createdAt > end) return false;
                return true;
            });

            table.draw();
            $.fn.dataTable.ext.search.pop(); // Remove custom filter to prevent conflicts
        });
    });
</script>

<script>
    $('.toggleLevel').on('click', function (e) {
        let self = $(this); // Reference to the clicked element
        let level = self.attr('id'); // Get the level ID
        
        $.ajax({
            url: `{{ route('level.toggle', '') }}/${level}`, // Generate the correct route
            type: 'GET', // HTTP method
            success: function (response) {
                // Toggle the HTML content based on current value
                if (self.html() == 'easy') {
                    self.html('difficult');
                } else {
                    self.html('easy');
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
            const taskRow = $(`#checkbox-${taskId}`).closest('tr').find('td:nth-child(2)');

            checkbox.checked = !checkbox.checked;

            if (checkbox.checked) {
                taskRow.css('background-color', 'yellow');
            } else {
                taskRow.css('background-color', '');
            }
        }
    </script>
@endpush
