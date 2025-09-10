@extends('admin.components.form')
@section('form_action', route('admins.update', $admin->id))
@section('form_type', 'POST')
@section('fields_content')

    <div class="content-wrapper">
        
        @method('PUT')
        <!-- Main content -->
        <section class="content">
            @include('admin.components.alert-error')

            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-custom">
                            <div class="card-header card-header-tabs-line">
                                @include('admin.components.breadcrumb', ['module' => 'admins', 'action' => 'edit'])
                            </div>
                            <!-- form start -->
                            <input type="hidden" name="id" value="{{ $admin->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.name')</label>
                                    <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputName" placeholder="@lang('general.name')">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.email')</label>
                                    <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputEmail" placeholder="@lang('general.email')">
                                </div>

                                <!-- Normal title input --> <div class="col-md-12"> <div class="form-group"> <label>{{__('general.phone')}} <span class="text-danger"> * </span></label> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fas fa-pen"></i></span> </div> <input type="tel" name="phone" placeholder="{{__('general.phone')}}" class="form-control pl-1 min-h-40px @error('phone') is-invalid @enderror" value="{{ old('phone', $admin->phone) }}"> </div> </div> </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.password')</label>
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputPassword" placeholder="@lang('general.password')">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.confirm_password')</label>
                                    <input type="password" name="confirm-password" value="{{ old('confirm-password') }}"
                                        class="form-control @error('') invalid @enderror" id="exampleInputConfirmpassword"
                                        placeholder="@lang('general.confirm_password')">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('general.role')</label>
                                    <select name="roles" id="" class="form-control @error('') invalid @enderror">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        @include('admin.components.image', [
                                            'label' => __('general.image'),
                                            'value' => old('image', $admin->image),
                                            'name' => 'image',
                                            'id' => 'kt_image_3',
                                            'accept' => 'image/*',
                                            'required' => true,
                                        ])

                                    </div>
                                </div>


                                <div class="card-footer mb-5  mt-5">

                                    <button type="submit" class="btn btn-outline-primary px-5">@lang('general.save')
                                    </button>

                                    <a href="{{ route('services.index') }}"
                                        class="btn btn-outline-danger px-5
                                        ">@lang('general.cancel')</a>

                                </div>
                            </div>
                            <!-- /.card -->


                        </div>
                        <!--/.col (left) -->

                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.container-fluid -->
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
