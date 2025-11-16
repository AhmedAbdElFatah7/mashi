<div class="startbar d-print-none">
    <div class="brand">
        <a href="{{ route('dashboard') }}" class="logo">
            <span>
                <img src="{{asset('assets-dashboard')}}/images/logo-sm.png" alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="{{asset('assets-dashboard')}}/images/logo-light.png" alt="logo-large" class="logo-lg logo-light">
                <img src="{{asset('assets-dashboard')}}/images/logo-dark.png" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu">
        <style>
            .navbar-nav .nav-link .menu-title {
                font-weight: 600 !important;
                font-size: 14px !important;
            }

            .menu-label span {
                font-weight: 700 !important;
                font-size: 13px !important;
            }
        </style>
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <!-- الصفحة الرئيسية -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="iconoir-home-simple me-2"></i>
                            <span class="menu-title">الصفحة الرئيسية</span>
                        </a>
                    </li>

                    <!-- عنوان قسم المستخدمين -->
                    <li class="menu-label mt-3">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>المستخدمين والصلاحيات</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="iconoir-user me-2"></i>
                            <span class="menu-title">قائمة العملاء</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admins.*') ? 'active' : '' }}" href="{{ route('admins.index') }}">
                            <i class="iconoir-user-star me-2"></i>
                            <span class="menu-title">قائمة الادمن</span>
                        </a>
                    </li>

                    <!-- عنوان قسم الإعلانات -->
                    <li class="menu-label mt-3">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>إدارة الإعلانات</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ads.*') && !request()->routeIs('ads.featured') ? 'active' : '' }}" href="{{ route('ads.index') }}">
                            <i class="iconoir-list me-2"></i>
                            <span class="menu-title">الإعلانات</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ads.featured') ? 'active' : '' }}" href="{{ route('ads.featured') }}">
                            <i class="iconoir-medal me-2"></i>
                            <span class="menu-title">الإعلانات المميزة</span>
                        </a>
                    </li>
                    <!-- عنوان قسم التصنيفات -->
                    <li class="menu-label mt-3">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>إدارة التصنيفات</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="iconoir-folder me-2"></i>
                            <span class="menu-title">إدارة التصنيفات</span>
                        </a>
                    </li>

                    <!-- عنوان قسم الصفحات الثابتة -->
                    <li class="menu-label mt-3">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>الصفحات الثابتة</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.about-us.index') ? 'active' : '' }}" href="{{ route('settings.about-us.index') }}">
                            <i class="iconoir-info-circle me-2"></i>
                            <span class="menu-title">من نحن</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="iconoir-mail me-2"></i>
                            <span class="menu-title">اتصل بنا</span>
                        </a>
                    </li>

                    <!-- عنوان قسم الإعدادات -->
                    <li class="menu-label mt-3">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>الإعدادات</span>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                            <i class="iconoir-settings me-2"></i>
                            <span class="menu-title">إعدادات الموقع</span>
                        </a>
                    </li>

                    <!-- عنوان قسم الملف الشخصي -->
                    <li class="menu-label mt-3">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>الملف الشخصي</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}" href="{{ route('dashboard.profile.index') }}">
                            <i class="iconoir-user-circle me-2"></i>
                            <span class="menu-title">الملف الشخصي</span>
                        </a>
                    </li>

                </ul><!--end navbar-nav--->
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->