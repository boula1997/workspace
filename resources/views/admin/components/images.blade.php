<div class="row">
    <div class="col-md-12">
        <div class="form-group mt-30">
            <label for="fileInput">{{ __('general.files') }}</label>
            <div id="drop-area" class="border p-3 text-center bg-light">
                <p>Drag & Drop Files Here or Click to Upload</p>
                <input type="file" name="files[]" class="d-none" id="fileInput" multiple>
            </div>
        </div>
    </div>
</div>

<!-- File Preview Section -->
<div class="row mt-3" id="preview-container"></div>

@if (isset($files))
    <div class="row">
        @include('admin.components.selectAll', ['on' => 'danger', 'off' => 'success'])
        @foreach ($files as $file)
            @if (isset($file->id))
                <div class="col-md-3 mt-3 file-box">
                    <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
                        <input type="checkbox" name="delfiles[]" value="{{ $file->id }}"
                            class="custom-control-input" id="customSwitch{{ $file->id }}">

                        @php
                            $fileExtension = pathinfo($file->url, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <a href="{{ asset($file->url) }}" data-lightbox="projects">
                                <img width="100" height="100" class="clickable-text preview-img"
                                    src="{{ asset($file->url) }}" alt="">
                            </a>
                        @else
                            <a href="{{ asset($file->url) }}" target="_blank">
                                <div class="file-preview">
                                    <i class="fas fa-file-alt"></i> {{ basename($file->url) }}
                                </div>
                            </a>
                        @endif

                        <label class="custom-control-label" for="customSwitch{{ $file->id }}"></label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif


<script>
    $(document).ready(function () {
        let previewContainer = $("#preview-container");

        $("#drop-area").on("click", function () {
            $("#fileInput").click();
        });

        $("#fileInput").on("change", function (event) {
            handleFiles(event.target.files);
        });

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
                let fileType = file.type;

                reader.onload = function (e) {
                    let fileElement;

                    if (fileType.startsWith("image/")) {
                        fileElement = `
                            <div class="col-md-3 mt-3">
                                <div class="position-relative">
                                    <img src="${e.target.result}" class="img-fluid border rounded" width="100%">
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-file">X</button>
                                </div>
                            </div>`;
                    } else {
                        fileElement = `
                            <div class="col-md-3 mt-3">
                                <div class="position-relative file-preview">
                                    <i class="fas fa-file-alt"></i> ${file.name}
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-file">X</button>
                                </div>
                            </div>`;
                    }

                    previewContainer.append(fileElement);
                };

                reader.readAsDataURL(file);
            });
        }

        $(document).on("click", ".remove-file", function () {
            $(this).closest(".col-md-3").remove();
        });
    });
</script>


