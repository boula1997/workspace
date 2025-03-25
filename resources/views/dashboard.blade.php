@extends('admin.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@lang('general.dashboard')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                            <li class="breadcrumb-item"><a href="#">@lang('general.home')</a></li>
                            <li class="breadcrumb-item active">@lang('general.dashboard')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ itemsCount('tasks') }}</h3>

                                <p>@lang('general.tasks')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('tasks.index') }}" class="small-box-footer">@lang('general.moreinfo') <i
                                    class="fas fa-arrow-circle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ itemsCount('finishedTasks') }}</h3>

                                <p>@lang('general.finishedTasks')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('tasks.finished') }}" class="small-box-footer">@lang('general.moreinfo') <i
                                    class="fas fa-arrow-circle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ itemsCount('followups') }}</h3>

                                <p>@lang('general.followups')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('followups.index') }}" class="small-box-footer">@lang('general.moreinfo') <i
                                    class="fas fa-arrow-circle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ itemsCount('finishedFollowups') }}</h3>

                                <p>@lang('general.finishedFollowups')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('followups.finished') }}" class="small-box-footer">@lang('general.moreinfo') <i
                                    class="fas fa-arrow-circle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></a>
                        </div>
                    </div>

                </div>
                <!-- /.row -->

                @if (boula())
                    <div class="row">
                        <h4>Methodologies</h4>
                            <li>Edit first methodology: when adding or removing attributes do it first in edit.blade.php to
                                avoid any poring filling data or validations issues and if no entered modules add them from
                                database through ready insert and chatgpt to fill data inside insert </li>
                    </div>
                @endif

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
