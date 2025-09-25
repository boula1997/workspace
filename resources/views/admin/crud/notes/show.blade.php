@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains note content -->
    <div class="content-wrapper">
        <!-- Content Header (note header) -->
        <!-- Content Header (blog header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="card card-custom mb-2">
                        <div class="card-header card-header-tabs-line">
                            @include('admin.components.breadcrumb', [
                                'module' => 'notes',
                                'action' => 'show',
                            ])
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-custom">
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <!-- checkbox input -->
                                                <div class="col-md-6">
                                                    <div class="mb-5 bg-light p-3 rounded h-100">
                                                        <div class="card-title fw-bold">
                                                            <h5 class="font-weight-bolder text-dark">
                                                                {{ __('general.isNotification') }}:</h5>
                                                            <p style="margin: 0; color: inherit; font-weight: normal;">
                                                                {{ $note->isNotification ? _('general.yes') : __('general.no') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- checkbox input -->
                                                <div class="col-md-6">
                                                    <div class="mb-5 bg-light p-3 rounded h-100">
                                                        <div class="card-title fw-bold">
                                                            <h5 class="font-weight-bolder text-dark">
                                                                {{ __('general.isOverthinking') }}:</h5>
                                                            <p style="margin: 0; color: inherit; font-weight: normal;">
                                                                {{ $note->isOverthinking ? _('general.yes') : __('general.no') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- normal input -->
                                                <div class="col-md-6">
                                                    <div class="mb-5 bg-light p-3 rounded h-100">
                                                        <div class="card-title fw-bold">
                                                            <h5 class="font-weight-bolder text-dark">
                                                                {{ __('general.title') }}:</h5>
                                                            <p style="margin: 0; color: inherit; font-weight: normal;">
                                                                {{ $note->title }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->


                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
