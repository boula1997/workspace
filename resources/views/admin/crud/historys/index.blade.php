@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains history content -->
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
                                    <!-- general form elements -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex d-flex justify-content-start">
                                            <h1 class="card-title fw-bold">@lang('general.historys')</h1>
                                        </div>
                                        <div class="col-md-6 d-flex d-flex justify-content-end">
                                            <a href="{{ route('historys.create') }}">

                                                <button
                                                    class="btn btn-outline-primary px-5
                                                    "><i
                                                        class="fa fa-plus fa-sm px-2" aria-hidden="true"></i>
                                                    @lang('general.add')</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <input type="text" id="taskFilter" class="form-control" placeholder="@lang('general.task')">
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
                                    
                                    <table id="example1" class="table  table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('general.task')}}</th>

                                                <th>{{__('general.employee')}}</th>
                                                <th>{{__('general.project')}}</th>
                                                
                                                <th>{{__('general.action')}}</th>
                                                <th>{{__('general.created_at')}}</th>
                                                
                                                <th>@lang('general.controls')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historys as $history)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $history->task->title }}</td>

                                                    <td>{{ $history->employee->name }}</td>
                                                    <td>{{ $history->task->project->title }}</td>
                                                    
                                                    <td>{{ $history->action }}</td>
                                                    <td>{{ $history->created_at }}</td>
                                                    <td>
                                                        @include('admin.components.controls', [
                                                            'route' => 'historys',
                                                            'role' => 'history',
                                                            'module' => $history,
                                                        ])
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
        $('#taskFilter').on('keyup', function() {
            table.columns(1).search(this.value).draw(); // Task column
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
@endpush

    <script>
        $(function() {
            // Define a unique key for your DataTable state in localStorage
            const tableStateKey = "coursesTableState";

            // Initialize DataTable with stateSave and custom state management
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "stateSave": true, // Enable state saving
                "stateLoadCallback": function(settings) {
                    // Load the state from localStorage
                    var savedState = localStorage.getItem(tableStateKey);
                    return savedState ? JSON.parse(savedState) : null;
                },
                "stateSaveCallback": function(settings, data) {
                    // Save the state to localStorage
                    localStorage.setItem(tableStateKey, JSON.stringify(data));
                }
            });

            // Append DataTable buttons to container
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
