@extends('admin.components.form')
@section('form_action', route('followups.update', $followup->id))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
        @method('PUT')

        <div class="container p-3">
            @include('admin.components.alert-error')

            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'followups', 'action' => 'edit'])
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
                                        placeholder="{{ __('general.title') }}"
                                        class="form-control pl-1 min-h-40px @error('title') is-invalid @enderror"
                                        value="{{ old('title', $followup->title) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('status', $followup->status)) type="checkbox" id="status" name="status"
                                            value="1"> <label class="form-check-label"
                                            for="status">{{ __('general.status') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                        {{-- Multi Select Input Edit --}} <div class="form-group row"> <label
                                class="col-form-label text-right col-lg-3 col-sm-12">{{ __('words.specifications') }}</label>
                            <div class="col-lg-4 col-md-9 col-sm-12"> <select class="form-control selectpicker"
                                    id="multiSelect1" multiple="multiple" data-live-search="true" name="employees[]">
                                    <option value="">{{ __('general.select') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ collect(old('employees', $selectedEmployees))->contains($employee->id) ? 'selected' : '' }}>
                                            {{ $employee->name }}</option>
                                    @endforeach
                                </select> </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('difficulty', $followup->difficulty)) type="checkbox" id="difficulty" name="difficulty"
                                            value="1"> <label class="form-check-label"
                                            for="difficulty">{{ __('general.difficulty') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('hasPhone', $followup->hasPhone)) type="checkbox" id="hasPhone" name="hasPhone"
                                            value="1"> <label class="form-check-label"
                                            for="hasPhone">{{ __('general.hasPhone') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-5">
                    <button type="submit"
                        class="btn btn-outline-primary px-5
                          ">@lang('general.save')</button>
                    <a href="{{ route('followups.index') }}"
                        class="btn btn-outline-danger px-5
                            ">@lang('general.cancel')</a>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
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
