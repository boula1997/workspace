@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'navigations', 'action' => 'show'])
                </div>

                <div class="card-body">
                    <div class="row">


<!-- normal input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{__('general.link')}}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{ $navigation->link }}</p> </div> </div> </div>

<!-- normal input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{__('general.title')}}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{ $navigation->title }}</p> </div> </div> </div>

<!-- normal input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{__('general.user')}}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{ $navigation->user }}</p> </div> </div> </div>

<!-- normal input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{__('general.password')}}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{ $navigation->password }}</p> </div> </div> </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
