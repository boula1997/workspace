    <!-- search popup start-->
    <div class="td-search-popup" id="td-search-popup">
        <form action="index.html" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search.....">
            </div>
            <button type="submit" class="submit-btn"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <!-- search popup end-->
    <div class="body-overlay" id="body-overlay"></div>

    <!-- navbar start -->
    <div class="navbar-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <ul class="topbar-right text-md-start text-center">
                        <li class="d-none d-none d-lg-inline-block">
                            <p><i class="far fa-clock"></i>
                                {{ __('general.opening_hour') }}{{ settings()->translate(app()->getLocale())->appointment1 }}
                            </p>
                        </li>
                        <li>
                            <p><i class="far fa-envelope"></i> {{ contacts('email')[0]->contact }}</p>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ul class="topbar-right text-md-end text-center">
                        <li class="d-none d-none d-lg-inline-block">
                            <p>{{ __('general.hotline') }} <span>: {{ contacts('phone')[0]->contact }} </span></p>
                        </li>
                        <li class="social-area">
                            <p class="d-inline-block">{{ __('general.follow_us_on') }}</p>
                            @foreach (contacts('social') as $contact)
                                <a href="{{ $contact->contact }}"><i class="{{ $contact->icon }}"
                                        aria-hidden="true"></i></a>
                            @endforeach

                            {{-- <a href="{{ settings()->twitter }}"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            <a href="{{ settings()->instgram }}"><i class="fab fa-instagram"
                                    aria-hidden="true"></i></a>
                            <a href="{{ settings()->youtube }}"><i class="fab fa-youtube" aria-hidden="true"></i></a> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-area navbar-area-1 navbar-expand-lg">
        <div class="container nav-container navbar-bg">
            <div class="responsive-mobile-menu">
                <button class="menu toggle-btn d-block d-lg-none" data-target="#Iitechie_main_menu"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-left"></span>
                    <span class="icon-right"></span>
                </button>
            </div>
            <div class="logo">
                <a href="{{ route('front.home') }}"><img class="logo" src="{{ asset(settings()->white_logo) }}"
                        alt="img"></a>
            </div>
            {{-- <div class="nav-right-part nav-right-part-mobile">
                <a class="search-bar-btn" href="#">
                    <i class="fa fa-search"></i>
                </a>
            </div> --}}
            <div class="collapse navbar-collapse" id="Iitechie_main_menu">
                <ul class="navbar-nav menu-open text-lg-end">
                    <li><a class="{{ request()->routeIs('front.home') ? 'active' : '' }}"
                            href="{{ route('front.home') }}">{{ __('general.home') }}</a></li>
                    <li><a class="{{ request()->routeIs('front.service') ? 'active' : '' }}"
                            href="{{ route('front.service') }}">{{ __('general.services') }}</a></li>
                    <li><a class="{{ request()->routeIs('front.portfolios') ? 'active' : '' }}"
                            href="{{ route('front.portfolios') }}">{{ __('general.portfolios') }}</a></li>
                    <li><a class="{{ request()->routeIs('front.about') ? 'active' : '' }}"
                            href="{{ route('front.about') }}">{{ __('general.about') }}</a></li>
                    {{-- <li><a class="{{request()->routeIs('front.home')?'active':''}}" href="{{route('front.home')}}">Project</a></li> --}}
                    <li><a class="{{ request()->routeIs('front.message') ? 'active' : '' }}"
                            href="{{ route('front.message') }}">{{ __('general.contact_us') }}</a></li>
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li class="{{ app()->getLocale() == $localeCode ? 'd-none' : '' }}">
                            <a rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{ asset('flags/' . $localeCode . '.png') }}" class="flag"
                                    alt="KSA Flag">
                            </a>
                        </li>
                    @endforeach

                </ul>

            </div>
            <div class="nav-right-part nav-right-part-desktop align-self-center">
                {{-- <a class="search-bar-btn" href="#">
                    <i class="fa fa-search"></i>
                </a> --}}
                <a class="btn btn-base"
                    href="{{ request()->routeIs('front.home') ? '#process' : route('front.home') . '#process' }}">{{ __('general.get_started') }}</a>
            </div>
        </div>
    </nav>
    <!-- navbar end -->
