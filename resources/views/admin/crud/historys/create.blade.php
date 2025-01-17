@extends('admin.components.form')
@section('form_action', route('historys.store'))
@section('form_type', 'POST')
@section('fields_content')
    @method('post')
    <div class="content-wrapper">
        <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'historys', 'action' => 'create'])
                </div>
                <div class="card-body">
                    <div class="row">
{{-- Dynamic Select Input --}} <div class="col-md-6"> <div class="mb-3"> <label for="" class="form-label">{{ __('general.task') }}</label> <select class="form-select form-select-lg" name="task_id" id="task"> <option value="">{{ __('general.select') }}</option> @foreach ($tasks as $task) <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}> {{ $task->title}} </option> @endforeach </select> </div> </div>

{{-- Dynamic Select Input --}} <div class="col-md-6"> <div class="mb-3"> <label for="" class="form-label">{{ __('general.employee') }}</label> <select class="form-select form-select-lg" name="employee_id" id="employee"> <option value="">{{ __('general.select') }}</option> @foreach ($employees as $employee) <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}> {{ $employee->title}} </option> @endforeach </select> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.action')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="action" placeholder="{{__('general.action')}}" class="form-control pl-1 min-h-40px @error('action') is-invalid @enderror" value="{{ old('action') }}"> </div> </div> </div>
                    </div>
                    <div class="card-footer mb-5">
                        <button type="submit"
                            class="btn btn-outline-primary px-5
                          ">@lang('general.save')</button>
                        <a href="{{ route('historys.index') }}"
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
