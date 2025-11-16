<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">


<!-- Mirrored from mannatthemes.com/rizz/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 04 Oct 2025 12:58:01 GMT -->

@include('dashboard.partials.head')

<body>
    @include('dashboard.partials.navbar')

    @include('dashboard.partials.sidebar')


    <div class="startbar-overlay d-print-none"></div>
    <!-- end leftbar-tab-menu-->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">




                    @yield('content')

                    <!--end row-->
                </div><!-- container -->

                <!--Start Rightbar-->
                <!--Start Rightbar/offcanvas-->
                

                @include('dashboard.partials.footer')

            </div>
        </div>
        @include('dashboard.partials.scripts')
</body>

</html>