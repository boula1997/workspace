<!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <a href="{{ route('dashboard') }}">
            <img class="animation__shake" src="{{ settings()->logo}}" alt="AdminLTELogo">
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
            {{-- <a href="{{ route('front.home') }}" class="nav-link">@lang('general.home')</a> --}}
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">@lang('general.home')</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class=" px-1 fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input
                            class="form-control @error('') invalid @enderror form-control @error('') invalid @enderror-navbar"
                            type="search" placeholder="@lang('general.search')" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class=" px-1 fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class=" px-1 fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>



        </li>

        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li class="{{ app()->getLocale() == $localeCode ? 'd-none' : '' }}">
                <a rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <img src="{{ asset('flags/' . $localeCode . '.png') }}" class="flag" alt="KSA Flag">
                </a>
            </li>
        @endforeach


        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">

            {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class=" px-1 fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class=" px-1 far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class=" px-1 fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class=" px-1 far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class=" px-1 fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class=" px-1 far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div> --}}
        </li>
        <!-- Newsletters Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('newsletters.index') }}">
                <i class=" px-1 far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">{{ itemsCount('newsletters') }}</span>
            </a>
            {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Newsletter Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class=" px-1 fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class=" px-1 far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Newsletter End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Newsletter Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class=" px-1 fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your newsletter bro</p>
                            <p class="text-sm text-muted"><i class=" px-1 far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Newsletter End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Newsletter Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class=" px-1 fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class=" px-1 far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Newsletter End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Newsletters</a>
            </div> --}}
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class=" px-1 far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class=" px-1 fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class=" px-1 fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class=" px-1 fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class=" px-1 fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class=" px-1 fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar">
        <div class="d-flex justify-content-center">
            <img class="logo-side pt-3" style="height: 100px" src="{{ settings()->white_logo }}" alt="">
        </div>
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
                                <a href="{{ route('tasks.all') }}" class="nav-link">
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
                                <a href="{{ route('tasks.index') }}" class="nav-link">
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
                                <a href="{{ route('tasks.finished') }}" class="nav-link">
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
                @can('followup-list')
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
            @endcan
            @can('followup-list')
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
