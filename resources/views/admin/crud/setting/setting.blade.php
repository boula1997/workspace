@extends('admin.components.form')
@section('form_action', route('setting', $setting))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
        @method('PUT')
                <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    {{-- <div class="card-title fw-bold">
                            <h3 class="card-label">@lang('general.add_new')</h3>
                        </div> --}}
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
                                            value="{{ old($locale . '.title', $setting->translate($locale)->title) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('general.address') - @lang('general.' . $locale)<span class="text-danger"> * </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon-edit"></i></span>
                                        </div>
                                        <input type="text" name="{{ $locale . '[address]' }}"
                                            placeholder="@lang('general.address')"
                                            class="form-control @error('') invalid @enderror  pl-5 min-h-40px @error($locale . '.address') is-invalid @enderror"
                                            value="{{ old($locale . '.address', $setting->translate($locale)->address) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('general.appointment1') - @lang('general.' . $locale)<span class="text-danger"> *
                                        </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon-edit"></i></span>
                                        </div>
                                        <input type="text" name="{{ $locale . '[appointment1]' }}"
                                            placeholder="@lang('general.appointment1')"
                                            class="form-control @error('') invalid @enderror  pl-5 min-h-40px @error($locale . '.appointment1') is-invalid @enderror"
                                            value="{{ old($locale . '.appointment1', $setting->translate($locale)->appointment1) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('general.copyright') - @lang('general.' . $locale)<span class="text-danger"> *
                                        </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon-edit"></i></span>
                                        </div>
                                        <input type="text" name="{{ $locale . '[copyright]' }}"
                                            placeholder="@lang('general.copyright')"
                                            class="form-control @error('') invalid @enderror  pl-5 min-h-40px @error($locale . '.copyright') is-invalid @enderror"
                                            value="{{ old($locale . '.copyright', $setting->translate($locale)->copyright) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('general.meta_data') - @lang('general.' . $locale)<span class="text-danger"> *
                                        </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="flaticon-edit"></i></span>
                                        </div>
                                        <input type="text" name="{{ $locale . '[meta_data]' }}"
                                            placeholder="@lang('general.meta_data')"
                                            class="form-control @error('') invalid @enderror  pl-5 min-h-40px @error($locale . '.meta_data') is-invalid @enderror"
                                            value="{{ old($locale . '.meta_data', $setting->translate($locale)->meta_data) }}">
                                    </div>
                                </div>



                                <div class="col-form-group">
                                    <label>@lang('general.description')(@lang('general.' . $locale))<span class="text-danger">*</span></label>
                                    <textarea rows="100" class="summernote @error($locale . '.description') is-invalid @enderror"
                                        name="{{ $locale . '[description]' }}">
                                        {!! old($locale . '.description', $setting->translate($locale)->description) !!} 
                                    </textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('admin.components.image', [
                                'label' => __('general.logo'),
                                'value' => old('logo', $setting->logo),
                                'name' => 'logo',
                                'id' => 'kt_image_2',
                                'accept' => 'image/*',
                                'required' => true,
                            ])

                        </div>
                        <div class="col-md-6">
                            @include('admin.components.image', [
                                'label' => __('general.white_logo'),
                                'value' => old('white_logo', $setting->white_logo),
                                'name' => 'white_logo',
                                'id' => 'kt_image_2',
                                'accept' => 'image/*',
                                'required' => true,
                            ])

                        </div>
                        <div class="col-md-6">
                            @include('admin.components.image', [
                                'label' => __('general.tab'),
                                'value' => old('tab', $setting->tab),
                                'name' => 'tab',
                                'id' => 'kt_image_3',
                                'accept' => 'image/*',
                                'required' => true,
                            ])

                        </div>
                    </div>
                </div>
                <div class="card-footer mb-5">
                    <button type="submit" class="btn btn-outline-primary">@lang('general.save')</button>
                    <a href="{{ route('dashboard') }}"
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
