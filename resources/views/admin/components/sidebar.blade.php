<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center bg-dark">
    <a href="{{ route('action') }}">
        <img class="animation__shake" src="{{ settings()->logo }}" alt="AdminLTELogo">

    </a>
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class=" px-1 fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            {{-- <a href="{{ route('action') }}" class="nav-link">@lang('general.home')</a> --}}
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">@lang('general.home')</a>
        </li>

        <li class="nav-item">
            <form action="{{route('date.filter')}}" method="post">
                @csrf
                <div class="d-flex">

                    {{-- Date input --}} <div class="col-md-5">
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"> <span class="input-group-text"><i
                                            class="fas fa-calendar-alt"></i></span> </div> <input type="date"
                                    id="dateInput" class="form-control"
                                    value="{{ old('start_date', settings()->start_date) }}" name="start_date">
                            </div>
                        </div>
                    </div>
    
                    {{-- Date input --}}<div class="col-md-5">
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"> <span class="input-group-text"><i
                                            class="fas fa-calendar-alt"></i></span> </div> <input type="date"
                                    id="dateInput" class="form-control"
                                    value="{{ old('end_date', settings()->end_date) }}" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning">Filter</button>
                    </div>
                </div>
            </form>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li class="{{ app()->getLocale() == $localeCode ? 'd-none' : '' }}">
                <a rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <img src="{{ asset('flags/' . $localeCode . '.png') }}" class="flag" alt="KSA Flag">
                </a>
            </li>
        @endforeach


    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar">
        <div class="d-flex justify-content-center">


            <a href="{{ route('action') }}">
                <img class="logo-side pt-3" style="height: 100px" src="{{ settings()->logo }}"
                    alt="">
                    
                </a>
                
                
            </div>
            <p class="text-sm text-center">Priorities Methodology</p>
        {{-- <div class="">
            <!-- Sidebar user panel (optional) -->
            <a href="{{ route('edit.profile') }}">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ auth('admin')->user()->file ? auth('admin')->user()->image : '' }}"
                            class="img-circle elevation-2" alt="Edit Your Profile">
                    </div>
                    <div class="info">
                        <a href="{{ route('edit.profile') }}" class="d-block">{{ auth('admin')->user()->name }}</a>
                    </div>
                </div>
            </a>
        </div> --}}




        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

                @can('admin-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-users-cog"></i>
                            <p>
                                @lang('general.admins')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('admins') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admins.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('user-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-users-cog"></i>
                            <p>
                                @lang('general.users')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('users') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('role-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-user-tag"></i>
                            <p>
                                @lang('general.roles')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('roles') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('admin-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-user-tag"></i>
                            <p>
                                @lang('general.admins')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('admins') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admins.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('clienttrack-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-user-tag"></i>
                            <p>
                                @lang('general.clienttracks')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('clienttracks') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('clienttracks.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('user-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-users"></i>
                            <p>
                                @lang('general.users')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('users') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
          
                @can('dbcredential-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-users"></i>
                            <p>
                                @lang('general.dbcredentials')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('dbcredentials') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dbcredentials.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan


                @can('partner-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-handshake"></i>
                            <p>
                                @lang('general.partners') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('partners') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('partners.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('team-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-friends"></i>
                            <p>
                                @lang('general.teams') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('teams') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('teams.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan


                @can('issue-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-issues"></i>
                            <p>
                                @lang('general.issues')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('issues') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('issues.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('service-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fab fa-servicestack"></i>
                            <p>
                                @lang('general.services') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('services') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('services.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('product-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fab fa-productstack"></i>
                            <p>
                                @lang('general.products') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('products') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('category-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fab fa-categoriestack"></i>
                            <p>
                                @lang('general.categories') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('categories') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('testimonial-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-comments"></i>
                            <p>
                                @lang('general.testimonials') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('testimonials') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('testimonials.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('process-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-microchip"></i>
                            <p>
                                @lang('general.processes') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('processes') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('processes.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('portfolio-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-portrait"></i>
                            <p>
                                @lang('general.portfolios')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('Portfolios') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('portfolios.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('page-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-file"></i>
                            <p>
                                @lang('general.pages')
                                <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('pages') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('pages.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('faq-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-tags"></i>
                            <p>
                                @lang('general.faqs') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('faqs') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('faqs.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('complain-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-tags"></i>
                            <p>
                                @lang('general.complains') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('complains') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('complains.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('vaccancy-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-tags"></i>
                            <p>
                                @lang('general.vaccancies') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('vaccancies') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('vaccancies.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('counter-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-globe"></i>
                            <p>
                                @lang('general.counters') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('counters') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('counters.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('contact-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.contacts') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('contacts') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('contacts.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('project-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.projects') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('projects') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('projects.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('accountant-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.accountants') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('accountants') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('accountants.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('history-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.historys') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('historys') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('historys.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('fee-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.fees') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('fees') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('fees.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('finance-log-list')
                    <li class="nav-item">
                        <a href="{{ route('finance-logs.index') }}" class="nav-link">
                            <i class=" px-1 fas fa-history"></i>
                            <p>@lang('general.finance_logs')</p>
                        </a>
                    </li>
                @endcan


                @can('video-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-play-circle"></i>
                            <p>
                                @lang('general.videos') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('videos') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('videos.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan


                @can('task-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.alltasks') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('alltasks') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('tasks.index', ['taskType' => 'alltasks']) }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('task-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.tasks') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('tasks') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('tasks.index', ['taskType' => 'tasks']) }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('task-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.finishedTasks') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('finishedTasks') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('tasks.index', ['taskType' => 'finishedTasks']) }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('message-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-envelope-open-text"></i>
                            <p>
                                @lang('general.messages') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('messages') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('messages.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- @can('followup-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.allfollowups') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('allfollowups') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('followups.all') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan --}}
                {{-- @can('followup-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.followups') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('followups') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('followups.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('followup-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.finishedFollowups') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('finishedFollowups') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('followups.finished') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan --}}

                 @can('navigation-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 far fa-address-card"></i>
                            <p>
                                @lang('general.navigations') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('navigations') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('navigations.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('newsletter-list')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class=" px-1 fas fa-envelope-open-text"></i>
                            <p>
                                @lang('general.newsletters') <i class=" px-1 fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ itemsCount('newsletters') }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('newsletters.index') }}" class="nav-link">
                                    <i class=" px-1 far fa-circle nav-icon"></i>
                                    <p>@lang('general.show')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('setting-list')
                    <li class="nav-item">
                        <a href="{{ route('edit.setting') }}" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <p>
                                @lang('general.settings')
                                {{-- <span class="right badge badge-danger">@lang('general.new')</span> --}}
                            </p>
                        </a>
                    </li>
                @endcan

                <li class="nav-item pb-3">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <i class=" px-1 nav-icon  fa fa-sign-out text-white" aria-hidden="true"></i>
                        <button class="btn text-secondary" type="submit">@lang('general.logout')</button>

                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
