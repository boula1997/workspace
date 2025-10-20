@extends('admin.components.form')
@section('form_action', route('clienttracks.store'))
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
                                'module' => 'clienttracks',
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
                                            <div class="col-md-12">
                                                <div class="col-form-group"> <label>{{ __('general.action') }} <span
                                                            class="text-danger"> * </span></label>
                                                    <textarea rows="100" class=" summernote @error('action') is-invalid @enderror" name="{{ 'action' }}"> {!! old('action') !!} </textarea>
                                                </div>
                                            </div>

                                            <div class="card-footer mb-5 text-center">
                                                <button type="submit"
                                                    class="btn btn-outline-primary px-5">@lang('general.save')</button>
                                                <a href="{{ route('clienttracks.index') }}"
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
