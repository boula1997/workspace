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
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="text" name="title"
                                        placeholder="ex:task1+task2+task3+task4"
                                        class="form-control pl-1 min-h-40px @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}">
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
                // Retrieve the searchValue from localStorage
                let searchValue = localStorage.getItem('searchValue');
                
                if (searchValue) {
                    // Iterate over each option in the project select element
                    $('#project option').each(function() {
                        // Check if the option's text contains the searchValue (case-insensitive)
                        if ($(this).text().toLowerCase().includes(searchValue.toLowerCase())) {
                            // Set this option as selected
                            $(this).prop('selected', true);
                            return false; // Exit loop after first match
                        }
                    });
                }
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
