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
                                <div class="row">
                                    @foreach ($images as $image)
                                        @if (isset($image->id))
                                            <div class="col-12 mb-2">
                                                <img class="zoomable" style="height: 100vh !important;" src="{{ $image->url }}" alt="">
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
                img.addEventListener("click", function () {
                    this.classList.toggle("zoomed");
                });
            });
        });
    </script>
    
    @endpush