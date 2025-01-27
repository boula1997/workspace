{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'app/helpers/helper.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'app/helpers/helper.php'"</p>
 <p>powershell -Command "(Get-Content 'app/helpers/helper.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'app/helpers/helper.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'app/helpers/helper.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'app/helpers/helper.php'"</p>
<p>powershell -Command "(Get-Content 'app/helpers/helper.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'app/helpers/helper.php'"</p>
<p>powershell -Command "(Get-Content 'app/helpers/helper.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'app/helpers/helper.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'database/seeders/PermissionTableSeeder.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'database/seeders/PermissionTableSeeder.php'"</p>
 <p>powershell -Command "(Get-Content 'database/seeders/PermissionTableSeeder.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'database/seeders/PermissionTableSeeder.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'database/seeders/PermissionTableSeeder.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'database/seeders/PermissionTableSeeder.php'"</p>
<p>powershell -Command "(Get-Content 'database/seeders/PermissionTableSeeder.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'database/seeders/PermissionTableSeeder.php'"</p>
<p>powershell -Command "(Get-Content 'database/seeders/PermissionTableSeeder.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'database/seeders/PermissionTableSeeder.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'resources/views/dashboard.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'resources/views/dashboard.blade.php'"</p>
 <p>powershell -Command "(Get-Content 'resources/views/dashboard.blade.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'resources/views/dashboard.blade.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'resources/views/dashboard.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'resources/views/dashboard.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/dashboard.blade.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'resources/views/dashboard.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/dashboard.blade.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'resources/views/dashboard.blade.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'resources/views/admin/components/dashboard.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'resources/views/admin/components/dashboard.blade.php'"</p>
 <p>powershell -Command "(Get-Content 'resources/views/admin/components/dashboard.blade.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'resources/views/admin/components/dashboard.blade.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'resources/views/admin/components/dashboard.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'resources/views/admin/components/dashboard.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/admin/components/dashboard.blade.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'resources/views/admin/components/dashboard.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/admin/components/dashboard.blade.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'resources/views/admin/components/dashboard.blade.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'resources/views/front/components/nav.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'resources/views/front/components/nav.blade.php'"</p>
 <p>powershell -Command "(Get-Content 'resources/views/front/components/nav.blade.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'resources/views/front/components/nav.blade.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'resources/views/front/components/nav.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'resources/views/front/components/nav.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/front/components/nav.blade.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'resources/views/front/components/nav.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/front/components/nav.blade.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'resources/views/front/components/nav.blade.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'database/seeders/DatabaseSeeder.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'database/seeders/DatabaseSeeder.php'"</p>
 <p>powershell -Command "(Get-Content 'database/seeders/DatabaseSeeder.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'database/seeders/DatabaseSeeder.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'database/seeders/DatabaseSeeder.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'database/seeders/DatabaseSeeder.php'"</p>
<p>powershell -Command "(Get-Content 'database/seeders/DatabaseSeeder.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'database/seeders/DatabaseSeeder.php'"</p>
<p>powershell -Command "(Get-Content 'database/seeders/DatabaseSeeder.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'database/seeders/DatabaseSeeder.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'routes/admin.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'routes/admin.php'"</p>
 <p>powershell -Command "(Get-Content 'routes/admin.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'routes/admin.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'routes/admin.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'routes/admin.php'"</p>
<p>powershell -Command "(Get-Content 'routes/admin.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'routes/admin.php'"</p>
<p>powershell -Command "(Get-Content 'routes/admin.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'routes/admin.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'routes/api.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'routes/api.php'"</p>
 <p>powershell -Command "(Get-Content 'routes/api.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'routes/api.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'routes/api.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'routes/api.php'"</p>
<p>powershell -Command "(Get-Content 'routes/api.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'routes/api.php'"</p>
<p>powershell -Command "(Get-Content 'routes/api.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'routes/api.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'routes/web.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'routes/web.php'"</p>
 <p>powershell -Command "(Get-Content 'routes/web.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'routes/web.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'routes/web.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'routes/web.php'"</p>
<p>powershell -Command "(Get-Content 'routes/web.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'routes/web.php'"</p>
<p>powershell -Command "(Get-Content 'routes/web.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'routes/web.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'resources/views/admin/components/controls.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'resources/views/admin/components/controls.blade.php'"</p>
 <p>powershell -Command "(Get-Content 'resources/views/admin/components/controls.blade.php') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'resources/views/admin/components/controls.blade.php'"</p>
@endif
<p>powershell -Command "(Get-Content 'resources/views/admin/components/controls.blade.php') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'resources/views/admin/components/controls.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/admin/components/controls.blade.php') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'resources/views/admin/components/controls.blade.php'"</p>
<p>powershell -Command "(Get-Content 'resources/views/admin/components/controls.blade.php') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'resources/views/admin/components/controls.blade.php'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'src/App.jsx') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'src/App.jsx'"</p>
 <p>powershell -Command "(Get-Content 'src/App.jsx') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'src/App.jsx'"</p>
@endif
<p>powershell -Command "(Get-Content 'src/App.jsx') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'src/App.jsx'"</p>
<p>powershell -Command "(Get-Content 'src/App.jsx') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'src/App.jsx'"</p>
<p>powershell -Command "(Get-Content 'src/App.jsx') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'src/App.jsx'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'src/App.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'src/App.js'"</p>
 <p>powershell -Command "(Get-Content 'src/App.js') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'src/App.js'"</p>
@endif
<p>powershell -Command "(Get-Content 'src/App.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'src/App.js'"</p>
<p>powershell -Command "(Get-Content 'src/App.js') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'src/App.js'"</p>
<p>powershell -Command "(Get-Content 'src/App.js') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'src/App.js'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'src/components/Menubar/index.jsx') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'src/components/Menubar/index.jsx'"</p>
 <p>powershell -Command "(Get-Content 'src/components/Menubar/index.jsx') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'src/components/Menubar/index.jsx'"</p>
@endif
<p>powershell -Command "(Get-Content 'src/components/Menubar/index.jsx') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'src/components/Menubar/index.jsx'"</p>
<p>powershell -Command "(Get-Content 'src/components/Menubar/index.jsx') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'src/components/Menubar/index.jsx'"</p>
<p>powershell -Command "(Get-Content 'src/components/Menubar/index.jsx') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'src/components/Menubar/index.jsx'"</p>
{{-- Boula Work area for shared modules to get into the process --}}

{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'src/pages/HomePage/index.jsx') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'src/pages/HomePage/index.jsx'"</p>
 <p>powershell -Command "(Get-Content 'src/pages/HomePage/index.jsx') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'src/pages/HomePage/index.jsx'"</p>
@endif
<p>powershell -Command "(Get-Content 'src/pages/HomePage/index.jsx') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'src/pages/HomePage/index.jsx'"</p>
<p>powershell -Command "(Get-Content 'src/pages/HomePage/index.jsx') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'src/pages/HomePage/index.jsx'"</p>
<p>powershell -Command "(Get-Content 'src/pages/HomePage/index.jsx') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'src/pages/HomePage/index.jsx'"</p>
{{-- Boula Work area for shared modules to get into the process --}}
{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'navigations\BaseNavigation.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'navigations\BaseNavigation.js'"</p>
 <p>powershell -Command "(Get-Content 'navigations\BaseNavigation.js') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'navigations\BaseNavigation.js'"</p>
@endif
<p>powershell -Command "(Get-Content 'navigations\BaseNavigation.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'navigations\BaseNavigation.js'"</p>
<p>powershell -Command "(Get-Content 'navigations\BaseNavigation.js') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'navigations\BaseNavigation.js'"</p>
<p>powershell -Command "(Get-Content 'navigations\BaseNavigation.js') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'navigations\BaseNavigation.js'"</p>
{{-- Boula Work area for shared modules to get into the process --}}
{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'navigations\BottomTabs.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'navigations\BottomTabs.js'"</p>
 <p>powershell -Command "(Get-Content 'navigations\BottomTabs.js') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'navigations\BottomTabs.js'"</p>
@endif
<p>powershell -Command "(Get-Content 'navigations\BottomTabs.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'navigations\BottomTabs.js'"</p>
<p>powershell -Command "(Get-Content 'navigations\BottomTabs.js') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'navigations\BottomTabs.js'"</p>
<p>powershell -Command "(Get-Content 'navigations\BottomTabs.js') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'navigations\BottomTabs.js'"</p>
{{-- Boula Work area for shared modules to get into the process --}}
{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'navigations\DrawerNavigation.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'navigations\DrawerNavigation.js'"</p>
 <p>powershell -Command "(Get-Content 'navigations\DrawerNavigation.js') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'navigations\DrawerNavigation.js'"</p>
@endif
<p>powershell -Command "(Get-Content 'navigations\DrawerNavigation.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'navigations\DrawerNavigation.js'"</p>
<p>powershell -Command "(Get-Content 'navigations\DrawerNavigation.js') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'navigations\DrawerNavigation.js'"</p>
<p>powershell -Command "(Get-Content 'navigations\DrawerNavigation.js') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'navigations\DrawerNavigation.js'"</p>
{{-- Boula Work area for shared modules to get into the process --}}
{{-- Boula Work area for shared modules to get into the process --}}
@if (isset($plural))
 <p>powershell -Command "(Get-Content 'screens\Home.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($plural) }}' | Out-File -encoding ASCII 'screens\Home.js'"</p>
 <p>powershell -Command "(Get-Content 'screens\Home.js') -creplace '{{ $module }}s', '{{ $plural }}' | Out-File -encoding ASCII 'screens\Home.js'"</p>
@endif
<p>powershell -Command "(Get-Content 'screens\Home.js') -creplace '{{ ucfirst($module) }}s', '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII 'screens\Home.js'"</p>
<p>powershell -Command "(Get-Content 'screens\Home.js') -creplace '{{ ucfirst($module) }}', '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII 'screens\Home.js'"</p>
<p>powershell -Command "(Get-Content 'screens\Home.js') -creplace '{{ $module }}', '{{ $rmodule }}' | Out-File -encoding ASCII 'screens\Home.js'"</p>
{{-- Boula Work area for shared modules to get into the process --}}
