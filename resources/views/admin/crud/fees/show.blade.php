@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'fees', 'action' => 'show'])
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.amount') }}:</h5>
                                    <p class="{{ $fee->amount>0?'text-success' : 'text-danger' }}" style="margin: 0; color: inherit; font-weight: normal;">{{ $fee->amount>0?'+':'' }} {{ $fee->amount }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- select input show -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.project') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ isset($fee->project->name) ? $fee->project->name:'None' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.note') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $fee->note }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
