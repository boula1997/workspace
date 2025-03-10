@extends('admin.components.form')
@section('form_action', route('projects.update', $project->id))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
        @method('PUT')

        <div class="container p-3">
            @include('admin.components.alert-error')

            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'projects', 'action' => 'edit'])
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
                                        value="{{ old('title', $project->title) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.cost') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="number" name="cost"
                                        placeholder="{{ __('general.cost') }}"
                                        class="form-control pl-1 min-h-40px @error('cost') is-invalid @enderror"
                                        value="{{ old('cost', $project->cost) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.payed') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="number" name="payed"
                                        placeholder="{{ __('general.payed') }}"
                                        class="form-control pl-1 min-h-40px @error('payed') is-invalid @enderror"
                                        value="{{ old('payed', $project->payed) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.debit') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="number" name="debit"
                                        placeholder="{{ __('general.debit') }}"
                                        class="form-control pl-1 min-h-40px @error('debit') is-invalid @enderror"
                                        value="{{ old('debit', $project->debit) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('isYousab', $project->isYousab)) type="checkbox" id="isYousab" name="isYousab"
                                            value="1"> <label class="form-check-label"
                                            for="isYousab">{{ __('general.isYousab') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('status', $project->status)) type="checkbox" id="status" name="status"
                                            value="1"> <label class="form-check-label"
                                            for="status">{{ __('general.status') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('appearance', $project->appearance)) type="checkbox" id="appearance" name="appearance"
                                            value="1"> <label class="form-check-label"
                                            for="appearance">{{ __('general.appearance') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-check form-switch"> <input class="form-check-input"
                                            @checked(old('deal', $project->deal)) type="checkbox" id="deal" name="deal"
                                            value="1"> <label class="form-check-label"
                                            for="deal">{{ __('general.deal') }} <span class="text-danger"> *
                                            </span></label> </div>
                                </div>
                            </div>
                        </div>

                        {{-- Date input --}} <div class="col-md-6">
                            <div class="form-group"> <label for="dateInput">{{ __('general.deadline') }} <span
                                        class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-calendar-alt"></i></span> </div> <input type="date"
                                        id="dateInput" class="form-control"
                                        value="{{ old('deadline', $project->deadline) }}" name="deadline">
                                </div>
                            </div>
                        </div>

                        {{-- Date input --}} <div class="col-md-6">
                            <div class="form-group"> <label for="dateInput">{{ __('general.lastTransaction') }} <span
                                        class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-calendar-alt"></i></span> </div> <input type="date"
                                        id="dateInput" class="form-control"
                                        value="{{ old('lastTransaction', $project->lastTransaction) }}"
                                        name="lastTransaction">
                                </div>
                            </div>
                        </div>

                        <!-- Normal title input -->
                        <div class="col-md-12">
                            <div class="form-group"> <label>{{ __('general.fees') }} <span class="text-danger"> *
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"> <span class="input-group-text"><i
                                                class="fas fa-pen"></i></span> </div> <input type="number"
                                        name="fees" placeholder="{{ __('general.fees') }}"
                                        class="form-control pl-1 min-h-40px @error('fees') is-invalid @enderror"
                                        value="{{ old('fees', $project->fees) }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-form-group"> <label>{{ __('general.tasks') }} <span class="text-danger"> *
                                    </span></label>
                                <textarea rows="100" class=" summernote @error('tasks') is-invalid @enderror" name="{{ 'tasks' }}"> {!! old('tasks', $project->tasks) !!} </textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-form-group"> <label>{{ __('general.codeLinks') }} <span class="text-danger">
                                        * </span></label>
                                <textarea rows="100" class=" summernote @error('codeLinks') is-invalid @enderror" name="{{ 'codeLinks' }}"> {!! old('codeLinks', $project->codeLinks) !!} </textarea>
                            </div>
                        </div>

                        {{-- Multi images input --}} <div class="row"> <div class="col-md-6"> @include('admin.components.image', [ 'label' => __('general.images'), 'value' => old('images'), 'name' => 'image', 'id' => 'kt_image_3', 'accept' => 'image/*', 'required' => true, ]) </div> @include('admin.components.images') </div>

                    </div>
                    <div class="card-footer mb-5">
                        <button type="submit"
                            class="btn btn-outline-primary px-5
                          ">@lang('general.save')</button>
                        <a href="{{ route('projects.index') }}"
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
