@extends('admin.components.form')
@section('form_action', route('dbcredentials.store'))
@section('form_type', 'POST')
@section('fields_content')
    <!-- Content Wrapper. Contains blog content -->
    <div class="content-wrapper">
        @include('admin.components.alert-error')

        <!-- Content Header (blog header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="card card-custom mb-2">
                        <div class="card-header card-header-tabs-line">
                            @include('admin.components.breadcrumb', [
                                'module' => 'dbcredentials',
                                'action' => 'create',
                            ])
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-12">
                                    <!-- general form elements -->
                                    <div class="card card-custom">
                                        <!-- form start -->
                                        <div class="card-body">


<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_host')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_host" placeholder="{{__('general.db_host')}}" class="form-control pl-1 min-h-40px @error('db_host') is-invalid @enderror" value="{{ old('db_host') }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_name')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_name" placeholder="{{__('general.db_name')}}" class="form-control pl-1 min-h-40px @error('db_name') is-invalid @enderror" value="{{ old('db_name') }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_password')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_password" placeholder="{{__('general.db_password')}}" class="form-control pl-1 min-h-40px @error('db_password') is-invalid @enderror" value="{{ old('db_password') }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_username')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_username" placeholder="{{__('general.db_username')}}" class="form-control pl-1 min-h-40px @error('db_username') is-invalid @enderror" value="{{ old('db_username') }}"> </div> </div> </div>


                                            <div class="card-footer mb-5 text-center">
                                                <button type="submit"
                                                    class="btn btn-outline-primary px-5">@lang('general.save')</button>
                                                <a href="{{ route('dbcredentials.index') }}"
                                                    class="btn btn-outline-danger px-5
                                                    ">@lang('general.cancel')</a>
                                            </div>
                                        </div>
                                        <!-- /.card -->


                                    </div>
                                    <!--/.col (left) -->

                                </div>
                                <!-- /.row -->
                            </div><!-- /.container-fluid -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

    </div>
    <!-- /.content-wrapper -->
@endsection

@push('scripts')
    <script>
        $(function() {
            // Summernote
            $('.summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endpush
