@extends('admin.components.form')
@section('form_action', route('tasks.store'))
@section('form_type', 'POST')
@section('fields_content')
    @method('post')
    <div class="content-wrapper">
        <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'tasks', 'action' => 'create'])
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.title') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                                <textarea name="title" class="form-control @error('title') is-invalid @enderror" placeholder="ex:task1+task2+task3+task4" id="" cols="30" rows="10" >{{ old('title') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} 
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('status')) type="checkbox" id="status" name="status"
                                            value="1"> <label class="form-check-label"
                                            for="status">{{ __('general.status') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                        {{-- Multi Select Input Create --}}
                         <div class="form-group col-md-6"> 
                            <label
                                class="col-form-label text-right">{{ __('general.employees') }}</label>
                                <select class="form-control selectpicker"
                                    id="multiSelect1" multiple="multiple" data-live-search="true" name="employees[]">
                                    <option value="">{{ __('general.select') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ collect(old('employees'))->contains($employee->id) ? 'selected' : '' }}>
                                            {{ $employee->name }}</option>
                                    @endforeach
                                </select> 
                        </div>

                        {{-- Dynamic Select Input --}} 
                        <div class="col-md-6">
                            <div class="mb-3"> <label for=""
                                    class="form-label">{{ __('general.project') }}</label> <select
                                    class="form-select form-select-lg" name="project_id" id="project">
                                    <option value="">{{ __('general.select') }}</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->title }} </option>
                                    @endforeach
                                </select> </div>
                        </div>
                    </div>
                    <div class="card-footer mb-5">
                        <button type="submit"
                            class="btn btn-outline-primary px-5
                          ">@lang('general.save')</button>
                        <a href="{{ route('tasks.index') }}"
                            class="btn btn-outline-danger px-5
                            ">@lang('general.cancel')</a>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')

        <script>

        $(document).ready(function() {
            // Check if there is a title value in local storage and set it to the input field
            if (localStorage.getItem('title')) {
                $('input[name="title"]').val(localStorage.getItem('title'));
            }

            // Save the title to local storage whenever it changes
            $('input[name="title"]').on('input', function() {
                localStorage.setItem('title', $(this).val());
            });
        });


            $(document).ready(function() {
                // Retrieve the search value from localStorage
                let searchValue = localStorage.getItem('searchValue') || '';
        
                // Select option in "projects" dropdown based on searchValue (using "contains" logic)
                $('#project option').each(function() {
                    if ($(this).text().toLowerCase().includes(searchValue.toLowerCase())) {
                        $(this).prop('selected', true);
                        return false; // stop after first match
                    }
                });
        
                // Select option in "employees" dropdown if text contains "Boula"
                if(searchValue.toLowerCase().includes('aloo')){
                    $('#multiSelect1 option').each(function() {
                        if ($(this).text().toLowerCase().includes('boula')) {
                            $(this).prop('selected', true);
                        }
                    });
                }
        
                // Refresh selectpicker to reflect selections in UI (if using Bootstrap selectpicker)
                $('#multiSelect1').selectpicker('refresh');
                $('#project').selectpicker('refresh');
            });
        </script>


            <script>
                $(function() {
                    // Summernote
                    $('.summernote').summernote()

                    // CodeMirror
                    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                        mode: "htmlmixed",
                        theme: "monokai"
                    });
                })
            </script>
        @endpush

    @endsection
