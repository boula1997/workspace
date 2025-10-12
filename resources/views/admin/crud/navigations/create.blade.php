@extends('admin.components.form')
@section('form_action', route('navigations.store'))
@section('form_type', 'POST')
@section('fields_content')
    @method('post')
    <div class="content-wrapper">
        <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', [
                        'module' => 'navigations',
                        'action' => 'create',
                    ])
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.link') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="text" name="link"
                                        placeholder="{{ __('general.link') }}"
                                        class="form-control pl-1 min-h-40px @error('link') is-invalid @enderror"
                                        value="{{ old('link') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.title') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="text" name="title"
                                        placeholder="{{ __('general.title') }}"
                                        class="form-control pl-1 min-h-40px @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Dynamic Select Input --}} <div class="col-md-6">
                            <div class="mb-3"> <label for=""
                                    class="form-label">{{ __('general.category') }}</label> <select
                                    class="form-select form-select-lg" name="category_id" id="category">
                                    <option value="">{{ __('general.select') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }} </option>
                                    @endforeach
                                </select> </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-form-group"> <label>{{ __('general.user') }} <span class="text-danger"> *
                                    </span></label>
                                <textarea rows="10" class="@error('user') is-invalid @enderror" name="{{ 'user' }}"> {!! old('user') !!} </textarea>
                            </div>
                        </div>

                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.password') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="text" name="password"
                                        placeholder="{{ __('general.password') }}"
                                        class="form-control pl-1 min-h-40px @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4"> <div class="form-group"> <div class="form-group"> <div class="form-check form-switch"> <input class="form-check-input" @checked(old('isExcavation')) type="checkbox" id="isExcavation" name="isExcavation" value="1"> <label class="form-check-label" for="isExcavation">{{ __('general.isExcavation') }} <span class="text-danger"> * </span></label> </div> </div> </div> </div>
                    </div>
                    <div class="card-footer mb-5">
                        <button type="submit"
                            class="btn btn-outline-primary px-5
                          ">@lang('general.save')</button>
                        <a href="{{ route('navigations.index') }}"
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
                        $('textarea[name="title"]').val(localStorage.getItem('title'));
                    }

                    // Save the title to local storage whenever it changes
                    $('#titlearea').on('input', function() {
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
                    if (searchValue.toLowerCase().includes('aloo')) {
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
