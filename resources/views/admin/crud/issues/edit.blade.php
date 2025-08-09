@extends('admin.components.form')
@section('form_action', route('issues.update', $issue->id))
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
                                @include('admin.components.breadcrumb', ['module' => 'issues', 'action' => 'edit'])
    
                            </div>

                            <input type="hidden" name="id" value="{{ $issue->id }}">
                            <div class="card-body mb-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.name')</label>
                                    <input type="text" name="name" value="{{ old('name', $issue->name) }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputName" placeholder="@lang('general.name')">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.email')</label>
                                    <input type="email" name="email" value="{{ old('email', $issue->email) }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputEmail" placeholder="@lang('general.email')">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.password')</label>
                                    <input type="password" name="password" value="" class="form-control @error('') invalid @enderror"
                                        id="exampleInputPassword" placeholder="Enter @lang('general.password')">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.confirm_password')</label>
                                    <input type="password" name="confirm-password" value="{{ old('confirm-password') }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputConfirmpassword"
                                        placeholder="Enter @lang('general.confirm_password')">
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        @include('admin.components.image', [
                                            'label' => __('general.image'),
                                            'value' => old('image',$issue->image),
                                            'name' => 'image',
                                            'id' => 'kt_image_3',
                                            'accept' => 'image/*',
                                            'required' => true,
                                        ])
                
                                    </div>
                                </div>

                                <div class="card-footer mb-5 mt-5">
                                    <button type="submit" class="btn btn-outline-primary px-5">@lang('general.save')</button>
                                    <a href="{{ route('issues.index') }}"
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
