<head>


    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Instant Dark Mode Script - يجب أن يكون قبل أي CSS -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
                document.documentElement.setAttribute('data-startbar', savedTheme);
            }
        })();
    </script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets-dashboard')}}/images/favicon.ico">



    <link rel="stylesheet" href="{{asset('assets-dashboard')}}/libs/jsvectormap/css/jsvectormap.min.css">

    <!-- App css -->
    <link href="{{asset('assets-dashboard')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets-dashboard')}}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets-dashboard')}}/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Custom Dark Mode CSS -->
    <style>
        /* تحسين انتقالات الثيم */
        .startbar, .startbar * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
        }
        
        /* التأكد من تطبيق الثيم على الـ sidebar */
        [data-startbar="dark"] .startbar {
            background-color: #212529 !important;
            color: #fff !important;
        }
        
        [data-startbar="dark"] .startbar .nav-link {
            color: #adb5bd !important;
        }
        
        [data-startbar="dark"] .startbar .nav-link:hover,
        [data-startbar="dark"] .startbar .nav-link.active {
            background-color: #495057 !important;
            color: #fff !important;
        }
        
        [data-startbar="dark"] .startbar .menu-label span {
            color: #6c757d !important;
        }
        
        [data-startbar="light"] .startbar {
            background-color: #fff !important;
            color: #212529 !important;
        }
        
        [data-startbar="light"] .startbar .nav-link {
            color: #495057 !important;
        }
        
        [data-startbar="light"] .startbar .nav-link:hover,
        [data-startbar="light"] .startbar .nav-link.active {
            background-color: #f8f9fa !important;
            color: #212529 !important;
        }
        
        /* تحسين عرض أيقونات الـ dark mode */
        #light-dark-mode .dark-mode,
        #light-dark-mode .light-mode {
            transition: opacity 0.3s ease;
        }
    </style>

</head>