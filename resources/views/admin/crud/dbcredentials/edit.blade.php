@extends('admin.components.form')
@section('form_action', route('dbcredentials.update', $dbcredential->id))
@section('form_type', 'POST')
@section('fields_content')
    <div class="content-wrapper">
        @include('admin.components.alert-error')

        @method('PUT')
        <!-- Main content -->
        <section class="content py-3">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-custom">
                            <div class="card card-header">
                                @include('admin.components.breadcrumb', ['module' => 'dbcredentials', 'action' => 'edit'])
    
                            </div>

                            <input type="hidden" name="id" value="{{ $dbcredential->id }}">
                            <div class="card-body mb-5">
<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_host')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_host" placeholder="{{__('general.db_host')}}" class="form-control pl-1 min-h-40px @error('db_host') is-invalid @enderror" value="{{ old('db_host', $dbcredential->db_host) }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_name')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_name" placeholder="{{__('general.db_name')}}" class="form-control pl-1 min-h-40px @error('db_name') is-invalid @enderror" value="{{ old('db_name', $dbcredential->db_name) }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_password')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_password" placeholder="{{__('general.db_password')}}" class="form-control pl-1 min-h-40px @error('db_password') is-invalid @enderror" value="{{ old('db_password', $dbcredential->db_password) }}"> </div> </div> </div>

<!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.db_username')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="text" name="db_username" placeholder="{{__('general.db_username')}}" class="form-control pl-1 min-h-40px @error('db_username') is-invalid @enderror" value="{{ old('db_username', $dbcredential->db_username) }}"> </div> </div> </div>

                                <div class="card-footer mb-5 mt-5">
                                    <button type="submit" class="btn btn-outline-primary px-5">@lang('general.save')</button>
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
        </section>
        <!-- /.content -->
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
