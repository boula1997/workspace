@extends('admin.components.form')
@section('form_action', route('notes.store'))
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
                                'module' => 'notes',
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
                                            {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <div class="form-check form-switch"> <input class="form-check-input"
                                                                @checked(old('isNotification')) type="checkbox"
                                                                id="isNotification" name="isNotification" value="1">
                                                            <label class="form-check-label"
                                                                for="isNotification">{{ __('general.isNotification') }}
                                                                <span class="text-danger"> * </span></label> </div>
                                                    </div>
                                                </div>
                                            </div>


                                            {{-- Checkbox Input --}} <div class="col-md-6 ps-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <div class="form-check form-switch"> <input class="form-check-input"
                                                                @checked(old('isOverthinking')) type="checkbox"
                                                                id="isOverthinking" name="isOverthinking" value="1">
                                                            <label class="form-check-label"
                                                                for="isOverthinking">{{ __('general.isOverthinking') }}
                                                                <span class="text-danger"> * </span></label> </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Normal title input -->
                                            <div class="col-md-12">
                                                <div class="form-group"> <label>{{ __('general.title') }} <span
                                                            class="text-danger"> * </span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"> <span class="input-group-text"><i
                                                                    class="fas fa-pen"></i></span> </div> <input
                                                            type="text" name="title"
                                                            placeholder="{{ __('general.title') }}"
                                                            class="form-control pl-1 min-h-40px @error('title') is-invalid @enderror"
                                                            value="{{ old('title') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer mb-5 text-center">
                                                <button type="submit"
                                                    class="btn btn-outline-primary px-5">@lang('general.save')</button>
                                                <a href="{{ route('notes.index') }}"
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
