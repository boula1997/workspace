@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">
            <div class="card card-custom mb-2">
                <div class="card-header card-header-tabs-line">
                    @include('admin.components.breadcrumb', ['module' => 'projects', 'action' => 'show'])
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.title') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->title }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.cost') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->cost }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.payed') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->payed }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.debit') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->debit }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- checkbox input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.isYousab') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">
                                        {{ $project->isYousab ? _('general.yes') : __('general.no') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- checkbox input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.status') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">
                                        {{ $project->status ? _('general.yes') : __('general.no') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- checkbox input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.appearance') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">
                                        {{ $project->appearance ? _('general.yes') : __('general.no') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- checkbox input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.deal') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">
                                        {{ $project->deal ? _('general.yes') : __('general.no') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.deadline') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->deadline }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.lastTransaction') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">
                                        {{ $project->lastTransaction }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.fees') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->fees }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.tasks') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->tasks }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- normal input -->
                        <div class="col-md-6">
                            <div class="mb-5 bg-light p-3 rounded h-100">
                                <div class="card-title fw-bold">
                                    <h5 class="font-weight-bolder text-dark">{{ __('general.codeLinks') }}:</h5>
                                    <p style="margin: 0; color: inherit; font-weight: normal;">{{ $project->codeLinks }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card card-custom">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group"> <label
                                            for="exampleInputFile1">{{ __('general.images') }}</label>
                                        <div class="row">
                                            @foreach ($images as $image)
                                                @if (isset($image->id))
                                                    <div class="col-md-3"> <img width="100" height="100" class="mx-3"
                                                            src="{{ $image->url }}" alt=""> </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-start">
                                    <h1 class="card-title fw-bold">@lang('general.fees')</h1>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('general.amount') }}</th>
                                        <th>{{ __('general.rest') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->feeses as $fee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $fee->amount }}</td>
                                            <td>{{ $fee->rest }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
