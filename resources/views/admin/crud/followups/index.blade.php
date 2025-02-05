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
    <!-- Content Wrapper. Contains followup content -->
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
                                            @if (request()->routeIs('followups.index'))
                                                <h1 class="card-title fw-bold">@lang('general.followups')</h1>
                                            @elseif(request()->routeIs('followups.all'))
                                                <h1 class="card-title fw-bold">@lang('general.allfollowups')</h1>
                                            @else
                                                <h1 class="card-title fw-bold">@lang('general.finishedFollowups')</h1>
                                            @endif
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <a href="{{ route('followups.create') }}">
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
                                    <form action="{{ route('followups.bulkAction') }}" method="POST">
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

                                            {{-- Date input --}} <div class="col-md-4">
                                                <div class="form-group"> <label
                                                        for="dateInput">{{ __('general.startdate') }} <span
                                                            class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"> <span class="input-group-text"><i
                                                                    class="fas fa-calendar-alt"></i></span> </div> <input
                                                            type="date" id="dateInput" class="form-control"
                                                            value="{{ old('startdate') }}" name="startdate">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Date input --}} <div class="col-md-4">
                                                <div class="form-group"> <label for="dateInput">{{ __('general.enddate') }}
                                                        <span class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"> <span class="input-group-text"><i
                                                                    class="fas fa-calendar-alt"></i></span> </div> <input
                                                            type="date" id="dateInput" class="form-control"
                                                            value="{{ old('enddate') }}" name="enddate">
                                                    </div>
                                                </div>
                                            </div>

                                                                  {{-- Checkbox Input --}} <div class="col-md-4 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('difficulty')) type="checkbox" id="difficulty" name="difficulty"
                                            value="1"> <label class="form-check-label"
                                            for="difficulty">{{ __('general.difficulty') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>
                        {{-- Checkbox Input --}} <div class="col-md-4 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('hasPhone')) type="checkbox" id="hasPhone" name="hasPhone"
                                            value="1"> <label class="form-check-label"
                                            for="hasPhone">{{ __('general.hasPhone') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12 d-flex justify-content-around mb-3">
                                                <div class="mt-2">
                                                    <button type="submit" name="action" value="assign"
                                                        class="btn btn-primary">
                                                        @lang('general.assign_employee')
                                                    </button>
    
                                                </div>
                                                <div class="mt-2">
                                                    <button type="submit" name="action" value="delete" class="btn btn-danger">
                                                        @lang('general.delete_followups')
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="submit" name="action" value="filter"
                                                        class="btn btn-success">
                                                        @lang('general.filter')
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="button" id="openLinks" class="btn btn-info clickable-text" content="{{ getFollowupTitles($followups) }}">
                                                        @lang('general.openLinks')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="example1" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th style="width: 500px;">{{ __('general.title') }}</th>
                                                    <th class="d-none">{{ __('general.select') }}</th>
                                                    <th>{{ __('general.employees') }}</th>
                                                    <th>{{ __('general.difficulty') }}</th>
                                                    <th>{{ __('general.hasPhone') }}</th>
                                                    <th>{{ __('general.created_at') }}</th>
                                                    <th>{{ __('general.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($followups as $followup)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="{{ request()->routeIs('followups.all') && $followup->status == 1 ? 'text-success' : '' }}"
                                                            style="cursor: pointer; white-space: normal; word-wrap: break-word; word-break: break-word; width: 100px;"
                                                            onclick="toggleCheckbox({{ $followup->id }})">
                                                            <a href="{{ $followup->title }}" target="__blank">
                                                                {{ $followup->title }}
                                                            </a>
                                                        </td>
                                                        <td class="d-none">
                                                            <input type="checkbox" name="followups[]"
                                                                value="{{ $followup->id }}"
                                                                id="checkbox-{{ $followup->id }}">
                                                        </td>
                                                        <td>{{ followupEmployees($followup->title) }}</td>
                                                        <td>{{ $followup->difficulty ? __
                                                        ('general.yes') : __('general.no') }}
                                                        </td>
                                                        <td>{{ $followup->hasPhone ? __
                                                        ('general.yes') : __('general.no') }}
                                                        </td>
                                                        <td>{{ $followup->created_at }}</td>
                                                        <td>
                                                            <a href="{{ route('followups.edit', $followup) }}" title="edit">
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

        function toggleCheckbox(followupId) {
            const checkbox = document.getElementById(`checkbox-${followupId}`);
            const followupRow = $(`#checkbox-${followupId}`).closest('tr').find('td:nth-child(2)');

            checkbox.checked = !checkbox.checked;

            if (checkbox.checked) {
                followupRow.css('background-color', 'yellow');
            } else {
                followupRow.css('background-color', '');
            }
        }
    </script>
@endpush
