@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains issue content -->
    <div class="content-wrapper">
        <!-- Content Header (issue header) -->
        <!-- Content Header (blog header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="card card-custom mb-2">
                        <div class="card-header card-header-tabs-line">
                            @include('admin.components.breadcrumb', [
                                'module' => 'issues',
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
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">@lang('general.name')</label>
                                                <p>{{ $issue->name }}</p>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">@lang('general.email')</label>
                                                    <p>{{ $issue->email }}</p>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile1">@lang('general.image')</label>
                                                        <div class="col-md-6">
                                                            <div class="form-group text-center">
                                                                <img width="300" height="300" src="{{ $issue->image }}"
                                                                    alt="">

                                                            </div>
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
