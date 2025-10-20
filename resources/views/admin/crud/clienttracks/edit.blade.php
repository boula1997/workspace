@extends('admin.components.form')
@section('form_action', route('clienttracks.update', $clienttrack->id))
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
                                @include('admin.components.breadcrumb', [
                                    'module' => 'clienttracks',
                                    'action' => 'edit',
                                ])

                            </div>

                            <input type="hidden" name="id" value="{{ $clienttrack->id }}">
                            <div class="card-body mb-5">
                                <div class="col-md-12">
                                    <div class="col-form-group"> <label>{{ __('general.action') }} <span
                                                class="text-danger"> * </span></label>
                                        <textarea rows="100" class=" summernote @error('action') is-invalid @enderror" name="{{ 'action' }}"> {!! old('action', $clienttrack->action) !!} </textarea>
                                    </div>
                                </div>

                                <div class="card-footer mb-5 mt-5">
                                    <button type="submit" class="btn btn-outline-primary px-5">@lang('general.save')</button>
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
