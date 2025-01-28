@include('admin.layouts.header')

<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    <div class="wrapper">
        @include('admin.components.success')
        @include('admin.components.errors')
        @include('admin.components.dashboard')
        @yield('content')
    </div>

    @include('admin.layouts.footer')
