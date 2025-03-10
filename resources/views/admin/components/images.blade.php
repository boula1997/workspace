<div class="row">
    <div class="col-md-12">
        <div class="form-group mt-30">
            <label for="fileInput">{{ __('general.images') }}</label>
            <div id="drop-area" class="border p-3 text-center bg-light">
                <p>Drag & Drop Images Here or Click to Upload</p>
                <input type="file" name="images[]" class="d-none" id="fileInput" multiple>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Section -->
<div class="row mt-3" id="preview-container"></div>


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

<script>
    $(document).ready(function () {
        let previewContainer = $("#preview-container");

        // Open file picker when clicking the drop area
        $("#drop-area").on("click", function () {
            $("#fileInput").click();
        });

        // Handle file selection
        $("#fileInput").on("change", function (event) {
            handleFiles(event.target.files);
        });

        // Handle drag & drop
        $("#drop-area").on("dragover", function (event) {
            event.preventDefault();
            $(this).addClass("border-primary");
        }).on("dragleave", function () {
            $(this).removeClass("border-primary");
        }).on("drop", function (event) {
            event.preventDefault();
            $(this).removeClass("border-primary");

            let files = event.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        function handleFiles(files) {
            $.each(files, function (index, file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    let imgElement = `
                        <div class="col-md-3 mt-3">
                            <div class="position-relative">
                                <img src="${e.target.result}" class="img-fluid border rounded" width="100%" height="100">
                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-img">X</button>
                            </div>
                        </div>`;
                    
                    previewContainer.append(imgElement);
                };
                reader.readAsDataURL(file);
            });
        }

        // Remove image from preview
        $(document).on("click", ".remove-img", function () {
            $(this).closest(".col-md-3").remove();
        });
    });
</script>
