@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains navigation content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content pt-2">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <!-- general form elements -->
                                <div class="row">
                                    <div class="col-md-6 d-flex d-flex justify-content-start">
                                        <h1 class="card-title fw-bold">
                                            <th>@lang('general.navigations')</th>
                                            </h3>
                                    </div>
                                    <div class="col-md-6 d-flex d-flex justify-content-end">
                                        <a href="{{ route('navigations.create') }}">

                                            <button class="btn btn-outline-primary px-5
"><i class="fa fa-plus fa-sm px-2"
                                                    aria-hidden="true"></i> @lang('general.add')</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table id="example1" class="table  table-hover">
                                    <thead class="h-2">
                                        <tr class="p-0 m-0">
                                            <th>#</th>

                                            <th>@lang('general.title')</th>
                                            <th>@lang('general.user')</th>
                                            <th>@lang('general.password')</th>
                                            <th>{{__('general.category')}}</th>
                                            <th class="th-controls">@lang('general.controls')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $navigation)
                                            <tr class="p-0 m-0">
                                                <td>{{ $loop->iteration }}</td>
                                                
                                                <td>
                                                    <a href="{{ $navigation->link }}" 
                                                    target="__blank" 
                                                    class="copy-creds" 
                                                    data-user="{{ $navigation->user }}" 
                                                    data-pass="{{ $navigation->password }}">
                                                    {{ $navigation->title }}
                                                    </a>
                                                </td>
                                                <td>{{ $navigation->user }}</td>
                                                <td>{{ $navigation->password }}</td>
                                                <td>{{ $navigation->category->title }}</td>
                                                <td>
                                                    @include('admin.components.controls', [
                                                        'route' => 'navigations',
                                                        'role' => 'navigation',
                                                        'module' => $navigation,
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@push('scripts')
    <script>
        $(function() {
            // Define a unique key for your DataTable state in localStorage
            const tableStateKey = "coursesTableState";

            // Initialize DataTable with stateSave and custom state management
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
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


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".copy-creds").forEach(link => {
            link.addEventListener("click", async function (e) {
                e.preventDefault(); // stop default link for a moment
                
                const username = this.dataset.user;
                const password = this.dataset.pass;
                const url = this.href;

                try {
                    // Copy username
                    await navigator.clipboard.writeText(username);
                    alert("Username copied!");

                    // Small delay before copying password
                    setTimeout(async () => {
                        await navigator.clipboard.writeText(password);
                        alert("Password copied!");
                        
                        // Finally open the link
                        window.open(url, "_blank");
                    }, 500);

                } catch (err) {
                    console.error("Clipboard error:", err);
                }
            });
        });
    });
</script>
@endpush
