@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'projects', 'action' => 'show'])
                </div>

                <div class="card card-custom">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile1">{{ __('general.images') }}</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($images as $image)
                                    @if (isset($image->id))
                                        <div class="zoom-container m-2" style="height: 100vh; flex: 1 1 auto; min-width: 300px; max-width: 100%;">
                                            <img class="zoomable w-100 h-100" src="{{ $image->url }}" style="object-fit: cover;" alt="">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label>{{ __('general.files') }}</label>
                            <ul>
                                @foreach ($files as $file)
                                    <li>
                                        <a href="{{ $file->url }}" target="_blank">{{ $file->name ?? 'Download File' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".zoomable").forEach(img => {
            let isZoomed = false;

            img.addEventListener("click", function (event) {
                if (!isZoomed) {
                    let rect = img.getBoundingClientRect();
                    let offsetX = event.clientX - rect.left;
                    let offsetY = event.clientY - rect.top;
                    let centerX = (offsetX / rect.width) * 100;
                    let centerY = (offsetY / rect.height) * 100;

                    img.style.transformOrigin = `${centerX}% ${centerY}%`;
                    img.style.transform = "scale(2)";
                    img.parentElement.style.cursor = "zoom-out";
                } else {
                    img.style.transform = "scale(1)";
                    img.style.transformOrigin = "center center";
                    img.parentElement.style.cursor = "zoom-in";
                }
                isZoomed = !isZoomed;
            });
        });
    });
</script>
@endpush
