@extends('admin.components.form')
@section('form_action', route('navigations.update', $navigation->id))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
        @method('PUT')

        <div class="container p-3">
            @include('admin.components.alert-error')

            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'navigations', 'action' => 'edit'])
                </div>
                <div class="card-body">
                    <div class="row">
                        

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.link')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="link" placeholder="{{__('general.link')}}" class="form-control pl-1 min-h-40px @error('link') is-invalid @enderror" value="{{ old('link', $navigation->link) }}"> </div> </div> </div>

{{-- Dynamic Select Input --}} <div class="col-md-6"> <div class="mb-3"> <label for="" class="form-label">{{ __('general.category') }}</label> <select class="form-select form-select-lg" name="category_id" id="category"> <option value="">{{ __('general.select') }}</option> @foreach ($categorys as $category) <option value="{{ $category->id }}" {{ old('category_id',$navigation->category_id) == $category->id ? 'selected' : '' }}> {{ $category->title}} </option> @endforeach </select> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.title')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="title" placeholder="{{__('general.title')}}" class="form-control pl-1 min-h-40px @error('title') is-invalid @enderror" value="{{ old('title', $navigation->title) }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.user')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="user" placeholder="{{__('general.user')}}" class="form-control pl-1 min-h-40px @error('user') is-invalid @enderror" value="{{ old('user', $navigation->user) }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.password')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="password" placeholder="{{__('general.password')}}" class="form-control pl-1 min-h-40px @error('password') is-invalid @enderror" value="{{ old('password', $navigation->password) }}"> </div> </div> </div>
                    </div>
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
