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
                        <div class="row">
                            <div class="form-group">
                                <label for="exampleInputFile1">{{ __('general.images') }}</label>
                                <div class="d-flex">
                                    @foreach ($images as $image)
                                    {{dd($images)}}
                                        @if (isset($image->id))
                                        <div class="zoom-container">
                                            <img class="zoomable m-2" src="{{ $image->url }}" style="height: 100vh !important" alt="">
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
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
                        let offsetX = event.clientX - rect.left; // Click X relative to image
                        let offsetY = event.clientY - rect.top;  // Click Y relative to image
                        let centerX = offsetX / rect.width * 100;
                        let centerY = offsetY / rect.height * 100;
    
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