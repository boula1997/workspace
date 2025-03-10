<div class="row">
    <div class="col-md-12">
        <div class="form-group mt-30">
            <label for="dropZone">{{ __('general.images') }}</label>
            <div id="dropZone" class="dropzone border p-3 text-center">
                <p class="mb-0">@lang('general.drag_drop_here') or <strong>@lang('general.choose_file')</strong></p>
                <input type="file" name="images[]" class="d-none" multiple id="fileInput">
            </div>
        </div>
    </div>
</div>

<!-- Preview Section -->
<div class="row mt-3" id="previewContainer"></div>

@if (isset($images))
    <div class="row">
        @include('admin.components.selectAll', ['on' => 'danger', 'off' => 'success'])
        @foreach ($images as $image)
            @if (isset($image->id))
                <div class="col-md-3 mt-3 image-box">
                    <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
                        <input type="checkbox" name="delimages[]" value="{{ $image->id }}"
                            class="custom-control-input" id="customSwitch{{ $image->id }}">

                        <a href="{{ asset($image->url) }}" data-lightbox="projects">
                            <img width="100" height="100" class="clickable-text preview-img"
                                src="{{ asset($image->url) }}" alt="">
                        </a>

                        <label class="custom-control-label" for="customSwitch{{ $image->id }}"></label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif




@push('scripts')
    <script>
        $(document).ready(function () {
    var dropZone = $("#dropZone");
    var fileInput = $("#fileInput");
    var previewContainer = $("#previewContainer");

    // Handle Click to Open File Picker
    dropZone.on("click", function () {
        fileInput.click();
    });

    // Handle File Selection
    fileInput.on("change", function (e) {
        handleFiles(e.target.files);
    });

    // Handle Drag & Drop
    dropZone.on("dragover", function (e) {
        e.preventDefault();
        dropZone.addClass("border-primary");
    });

    dropZone.on("dragleave", function () {
        dropZone.removeClass("border-primary");
    });

    dropZone.on("drop", function (e) {
        e.preventDefault();
        dropZone.removeClass("border-primary");
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    // Function to Handle Files & Show Preview
    function handleFiles(files) {
        previewContainer.empty(); // Clear previous previews
        Array.from(files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function (e) {
                let imgElement = `<div class="col-md-3 mt-3">
                    <img src="${e.target.result}" class="img-fluid rounded shadow-sm preview-img" width="100" height="100">
                </div>`;
                previewContainer.append(imgElement);
            };
            reader.readAsDataURL(file);
        });
    }
});

    </script>
@endpush