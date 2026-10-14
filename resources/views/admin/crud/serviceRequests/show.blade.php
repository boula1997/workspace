@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">

            <div class="card card-custom card-stretch gutter-b">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'serviceRequests', 'action' => 'show'])
                </div>
                <div class="card-body p-5">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-5 bg-light p-3 rounded h-100">
                                    <div class="card-title fw-bold">
                                        <h5 class="font-weight-bolder text-dark">@lang('general.name'):</h5>
                                        <p style="margin: 0; color: inherit; font-weight: normal;">{{ $serviceRequest->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-5 bg-light p-3 rounded h-100">
                                    <div class="card-title fw-bold">
                                        <h5 class="font-weight-bolder text-dark">@lang('general.email'):</h5>
                                        <p style="margin: 0; color: inherit; font-weight: normal;">{{ $serviceRequest->email }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-5 bg-light p-3 rounded h-100">
                                    <div class="card-title fw-bold">
                                        <h5 class="font-weight-bolder text-dark">@lang('general.serviceRequest'):</h5>
                                        <p style="margin: 0; color: inherit; font-weight: normal;">{{ $serviceRequest->service_request }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
