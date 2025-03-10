@extends('admin.components.form')
@section('form_action', route('portfolios.store'))
@section('form_type', 'POST')
@section('fields_content')
    @method('post')
    <div class="content-wrapper">

        <div class="container p-3">
            @include('admin.components.alert-error')

            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', [
                        'module' => 'portfolios',
                        'action' => 'create',
                    ])
                </div>
                <div class="card-toolbar px-3">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        @foreach (config('translatable.locales') as $key => $locale)
                            <li class="nav-item">
                                <a class="nav-link  @if ($key == 0) active @endif" data-toggle="tab"
                                    href="{{ '#' . $locale }}">@lang('general.' . $locale)</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach (config('translatable.locales') as $key => $locale)
                            <div class="tab-pane fade show @if ($key == 0) active @endif"
                                id="{{ $locale }}" role="tabpanel">
                                <div class="form-group">
                                    <label>@lang('general.title') - @lang('general.' . $locale)<span class="text-danger"> * </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon-edit"></i></span>
                                        </div>
                                        <input type="text" name="{{ $locale . '[title]' }}"
                                            placeholder="@lang('general.title')"
                                            class="form-control @error('') invalid @enderror  pl-5 min-h-40px @error($locale . '.title') is-invalid @enderror"
                                            value="{{ old($locale . '.title') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('general.subtitle') - @lang('general.' . $locale)<span class="text-danger"> * </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon-edit"></i></span>
                                        </div>
                                        <input type="text" name="{{ $locale . '[subtitle]' }}"
                                            placeholder="@lang('general.subtitle')"
                                            class="form-control @error('') invalid @enderror  pl-5 min-h-40px @error($locale . '.subtitle') is-invalid @enderror"
                                            value="{{ old($locale . '.subtitle') }}">
                                    </div>
                                </div>



                                <div class="col-form-group">
                                    <label>@lang('general.description')(@lang('general.' . $locale))<span class="text-danger">*</span></label>
                                    <textarea rows="100" class="summernote @error($locale . '.description') is-invalid @enderror"
                                        name="{{ $locale . '[description]' }}">
                                        {!! old($locale . '.description') !!} 
                                    </textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-body">
                    @include('admin.components.images',['on'=>'success','off'=>'danger'])
                </div>
                <div class="card-footer mb-5">
                    <button type="submit"
                        class="btn btn-outline-primary px-5
                            ">@lang('general.save')</button>
                    <a href="{{ route('portfolios.index') }}"
                        class="btn btn-outline-danger px-5
                            ">@lang('general.cancel')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

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
