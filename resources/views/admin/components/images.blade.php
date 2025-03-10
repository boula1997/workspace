<div class="row">
    <div class="col-md-12">
        <div class="form-group mt-30">
            <label for="exampleInputFile1">{{ __('general.images') }}</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="images[]" class="custom-file-input" multiple id="exampleInputFile1">
                    <label class="custom-file-label" for="exampleInputFile1">{{ __('general.choose') }}
                        {{ __('general.file') }}</label>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">@lang('general.upload_file')</span>
                </div>
            </div>
        </div>
    </div>
</div>

@if (isset($images))
    <div class="row">
        @include('admin.components.selectAll',['on'=>'danger','off'=>'success'])
        @foreach ($images as $image)
            @if (isset($image->id))
                <div class="col-md-3 mt-3">
                    <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
                        <input type="checkbox" name="delimages[]" value="{{ $image->id }}"
                            class="custom-control-input" id="customSwitch{{ $image->id }}">
                        <img width="100" height="100" src="{{ asset($image->url) }}" alt=""
                            for="customSwitch{{ $image->id }}">
                        <label class="custom-control-label" for="customSwitch{{ $image->id }}"></label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
