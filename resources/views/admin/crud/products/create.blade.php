@extends('admin.components.form')
@section('form_action', route('products.store'))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
                <div class="container p-3">
            @include('admin.components.alert-error')
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'products', 'action' => 'create'])
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

                                <div class="form-group"> <label>{{__('general.brand')}} - @lang('general.' . $locale)<span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="{{ $locale . '[brand]' }}" placeholder="{{__('general.brand')}}" class="form-control @error('brand') invalid @enderror pl-1 min-h-40px @error($locale . '.brand') is-invalid @enderror" value="{{ old($locale . '.brand') }}"> </div> </div>



                                <div class="col-form-group">
                                    <label>@lang('general.description')(@lang('general.' . $locale))<span class="text-danger">*</span></label>
                                    <textarea rows="5" class="summernote @error($locale . '.description') is-invalid @enderror"
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


                {{-- Number Input --}} <div class="col-md-6"> <div class="form-group"> <label>{{__('general.hdd')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="number" name="hdd" placeholder="{{__('general.hdd')}}" class="form-control min-h-40px @error('hdd') is-invalid @enderror" value="{{ old('hdd') }}"> </div> </div> </div>

{{-- Number Input --}} <div class="col-md-6"> <div class="form-group"> <label>{{__('general.ssd')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="number" name="ssd" placeholder="{{__('general.ssd')}}" class="form-control min-h-40px @error('ssd') is-invalid @enderror" value="{{ old('ssd') }}"> </div> </div> </div>

{{-- Number Input --}} <div class="col-md-6"> <div class="form-group"> <label>{{__('general.ram')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="number" name="ram" placeholder="{{__('general.ram')}}" class="form-control min-h-40px @error('ram') is-invalid @enderror" value="{{ old('ram') }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.processor')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="processor" placeholder="{{__('general.processor')}}" class="form-control pl-1 min-h-40px @error('processor') is-invalid @enderror" value="{{ old('processor') }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.generation')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="generation" placeholder="{{__('general.generation')}}" class="form-control pl-1 min-h-40px @error('generation') is-invalid @enderror" value="{{ old('generation') }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.screenCard')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="screenCard" placeholder="{{__('general.screenCard')}}" class="form-control pl-1 min-h-40px @error('screenCard') is-invalid @enderror" value="{{ old('screenCard') }}"> </div> </div> </div>



                    <div class="row">
                        <div class="col-md-6">
                            @include('admin.components.image', [
                                'label' => __('general.image'),
                                'value' => old('image'),
                                'name' => 'image',
                                'id' => 'kt_image_3',
                                'accept' => 'image/*',
                                'required' => true,
                            ])

                        </div>

                        <div class="col-md-6">
                            @include('admin.components.icon', [
                                'label' => 'icon',
                                'required' => true,
                                'value' => 'fas fa-desktop',
                            ])

                        </div>

                    </div>
                </div>
                <div class="card-footer mb-5">
                    <button type="submit"
                        class="btn btn-outline-primary px-5
                        ">@lang('general.save')</button>
                    <a href="{{ route('products.index') }}"
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
