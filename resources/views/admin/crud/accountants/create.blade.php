@extends('admin.components.form')
@section('form_action', route('accountants.store'))
@section('form_type', 'POST')
@section('fields_content')
    @method('post')
    <div class="content-wrapper">
        <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'accountants', 'action' => 'create'])
                </div>
                <div class="card-body">
                    <div class="row">
{{-- Number Input --}} <div class="col-md-6"> <div class="form-group"> <label>{{__('general.received')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="number" name="received" placeholder="{{__('general.received')}}" class="form-control min-h-40px @error('received') is-invalid @enderror" value="{{ old('received') }}"> </div> </div> </div>

{{-- Dynamic Select Input --}} <div class="col-md-6"> <div class="mb-3"> <label for="" class="form-label">{{ __('general.employee') }}</label> <select class="form-select form-select-lg" name="employee_id" id="employee"> <option value="">{{ __('general.select') }}</option> @foreach ($employees as $employee) <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}> {{ $employee->title}} </option> @endforeach </select> </div> </div>

{{-- Number Input --}} <div class="col-md-6"> <div class="form-group"> <label>{{__('general.has')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="number" name="has" placeholder="{{__('general.has')}}" class="form-control min-h-40px @error('has') is-invalid @enderror" value="{{ old('has') }}"> </div> </div> </div>
                    </div>
                    <div class="card-footer mb-5">
                        <button type="submit"
                            class="btn btn-outline-primary px-5
                          ">@lang('general.save')</button>
                        <a href="{{ route('accountants.index') }}"
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
