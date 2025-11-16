<!-- Top Bar Start -->
<div class="topbar d-print-none">
    <div class="container-xxl">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">


            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu-scale"></i>
                    </button>
                </li>
                <li class="mx-3 welcome-text">
                    <h3 class="mb-0 fw-bold text-truncate">
                        <span style="float: right; margin-left: 12px;">مرحباً</span>
                        <span style="float: left;">{{ Auth::user()->name }}</span>
                        <div style="clear: both;"></div>
                    </h3>
                    <!-- <h6 class="mb-0 fw-normal text-muted text-truncate fs-14">Here's your overview this week.</h6> -->
                </li>
            </ul>
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li class="topbar-item">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                        <i class="icofont-moon dark-mode"></i>
                        <i class="icofont-sun light-mode"></i>
                    </a>
                </li>


                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets-dashboard/images/users/avatar-1.jpg') }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="thumb-lg rounded-circle"
                             style="object-fit: cover;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img
                                    src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets-dashboard/images/users/avatar-1.jpg') }}"
                                    alt="{{ Auth::user()->name }}"
                                    class="thumb-md rounded-circle"
                                    style="object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13">{{ Auth::user()->name }}</h6>
                                <p class="my-0 text-muted fs-12">{{ Auth::user()->email }}</p>
                            </div><!--end media-body-->
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">الملف الشخصي</small>
                        <a class="dropdown-item" href="{{ route('dashboard.profile.index') }}"><i class="las la-user fs-18 me-1 align-text-bottom"></i> الملف الشخصي</a>
                        <div class="dropdown-divider mb-0"></div>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="las la-power-off fs-18 me-1 align-text-bottom"></i>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </li>
            </ul><!--end topbar-nav-->
        </nav>
        <!-- end navbar-->
    </div>
</div>