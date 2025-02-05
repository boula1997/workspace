@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'tasks', 'action' => 'show'])
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">@lang('general.task'):</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $task->task }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">@lang('general.type'):</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $task->type }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">@lang('general.icon'):</h5>
                                    <i class="{{ $task->icon }}"></i>
                                </div>
                            </div>
                        </div>

                        <!-- checkbox input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{ __('general.mobile') }}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{$task->level?_('general.yes'):__('general.no')}}</p> </div> </div> </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
