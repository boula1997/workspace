@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains admin content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-custom mb-2">
                    </div>
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-custom">
                            <div class="card-header card-header-tabs-line">
                                @include('admin.components.breadcrumb', ['module' => 'admins', 'action' => 'show'])
                            </div>
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">@lang('general.name')</label>
                                        <p>{{ $admin->name }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">@lang('general.email')</label>
                                        <p>{{ $admin->email }}</p>
                                    </div>

                                    <!-- tel input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{ __('general.phone') }}:</h5> <a href="tel:{{ $admin->phone }}" style="margin: 0; color: inherit; font-weight: normal;">{{ $admin->phone }}</a> </div> </div> </div>


                                    <!-- normal input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{__('general.facelinked')}}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{ $admin->messanger_id }}</p> </div> </div> </div>

<!-- tel input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{ __('general.whatsapp') }}:</h5> <a href="tel:{{ $admin->whatsapp }}" style="margin: 0; color: inherit; font-weight: normal;">{{ $admin->whatsapp }}</a> </div> </div> </div>

                                    <!-- checkbox input --> <div class="col-md-6"> <div class="mb-5 bg-light p-3 rounded h-100"> <div class="card-title fw-bold"> <h5 class="font-weight-bolder text-dark">{{ __('general.isActive') }}:</h5> <p style="margin: 0; color: inherit; font-weight: normal;">{{$admin->isActive?_('general.yes'):__('general.no')}}</p> </div> </div> </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <img width="300" height="300" src="{{ $admin->image }}" alt="">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->


                            </form>
                        </div>
                        <!-- /.card -->


                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
