@extends('admin.components.form')
@section('form_action', route('pages.update', $page->id))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
        @method('PUT')

                <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'pages', 'action' => 'edit'])
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
                                            value="{{ old($locale . '.title', $page->translate($locale)->title) }}">
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
                                            value="{{ old($locale . '.subtitle', $page->translate($locale)->subtitle) }}">
                                    </div>
                                </div>



                                <div class="col-form-group">
                                    <label>@lang('general.description')(@lang('general.' . $locale))<span class="text-danger">*</span></label>
                                    <textarea rows="100" class="summernote @error($locale . '.description') is-invalid @enderror"
                                        name="{{ $locale . '[description]' }}">
                                        {!! old($locale . '.description', $page->translate($locale)->description) !!} 
                                    </textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-body mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('general.identifier') }}</label>
                                    <input type="text" name="identifier"
                                        value="{{ old('identifier', $page->identifier) }}" class="form-control @error('') invalid @enderror"
                                        id="exampleInputName" placeholder="@lang('general.identifier')">
                                </div>
                            </div>

                        </div>

                    </div>
                    <br>
                    @include('admin.components.images', ['images' => $images])
                </div>
                <div class="card-footer mb-5 mb-5">
                    <button type="submit" class="btn btn-outline-success">@lang('general.save')</button>
                    <a href="{{ route('pages.index') }}"
                        class="btn btn-outline-danger font-weight-bold">@lang('general.cancel')</a>
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
