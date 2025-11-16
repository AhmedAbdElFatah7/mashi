@php
    $isHome = Request::is('/') || Request::is('index');
    $isDashboard = Request::is('dashboard');
    $isLogin = Request::is('login');
    $isRegister = Request::is('register');
@endphp

<div class="header-area {{ !$isHome ? 'page-header' : '' }}">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 col-sm-4 col-md-4">
                <div class="header-left-bar-text">
                    <ul class="list-inline mb-0">
                        @if ($settings->facebook_url)
                            <li class="list-inline-item">
                                <a href="{{ $settings->facebook_url }}" target="_blank" class="text-gray-600 hover:text-blue-600">
                                    <i class='bx bxl-facebook align-middle' style="font-size: 1.1rem;"></i>
                                </a>
                            </li>
                        @endif
                        @if ($settings->twitter_url)
                            <li class="list-inline-item me-3">
                                <a href="{{ $settings->twitter_url }}" target="_blank" class="text-gray-600 hover:text-blue-400">
                                    <i class='bx bxl-twitter align-middle' style="font-size: 1.1rem;"></i>
                                </a>
                            </li>
                        @endif
                        @if ($settings->linkedin_url)
                            <li class="list-inline-item me-3">
                                <a href="{{ $settings->linkedin_url }}" target="_blank" class="text-gray-600 hover:text-blue-700">
                                    <i class='bx bxl-linkedin align-middle' style="font-size: 1.1rem;"></i>
                                </a>
                            </li>
                        @endif
                        @if ($settings->instgram_url)
                            <li class="list-inline-item">
                                <a href="{{ $settings->instgram_url }}" target="_blank" class="text-gray-600 hover:text-pink-600">
                                    <i class='bx bxl-instagram align-middle' style="font-size: 1.1rem;"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-sm-8 col-md-8">
                <div class="header-right-content">
                    <ul class="list-inline mb-0 d-flex justify-content-center justify-content-sm-end align-items-center">
                        @auth
                            <li class="list-inline-item me-lg-3 me-md-3 me-sm-2">
                                <a href="{{ route('frontend.profile') }}" 
                                   class="text-decoration-none text-gray-700 hover:text-primary {{ $isDashboard ? 'active fw-semibold' : '' }}">
                                    <i class="fa-solid fa-id-badge me-1 align-middle" style="font-size: 0.9rem;"></i>
                                    <span class="align-middle">@lang('messages.profile')</span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ route('company.logout') }}" 
                                   class="text-decoration-none text-gray-700 hover:text-danger"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-1 align-middle" style="font-size: 0.9rem;"></i>
                                    <span class="align-middle">@lang('messages.logout')</span>
                                </a>
                                <form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="list-inline-item">
                                <a href="{{ route('login') }}" 
                                   class="text-decoration-none text-gray-700 hover:text-primary {{ $isLogin ? 'active fw-semibold' : '' }}">
                                    <i class="fa-solid fa-right-to-bracket me-1 align-middle" style="font-size: 0.9rem;"></i>
                                    <span class="align-middle">@lang('messages.login')</span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ route('register') }}" 
                                   class="text-decoration-none text-gray-700 hover:text-primary {{ $isRegister ? 'active fw-semibold' : '' }}">
                                    <i class="fa-regular fa-id-card me-1 align-middle" style="font-size: 0.9rem;"></i>
                                    <span class="align-middle">@lang('messages.register')</span>
                                </a>
                            </li>
                        @endauth

                        <li class="list-inline-item">
                            @if (LaravelLocalization::getCurrentLocale() == 'en')
                                <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" 
                                   class="text-decoration-none text-gray-700 hover:text-dark">
                                    <i class="fa-solid fa-earth-europe me-1 align-middle" style="font-size: 0.9rem;"></i>
                                    <span class="align-middle">عربي</span>
                                </a>
                            @else
                                <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" 
                                   class="text-decoration-none text-gray-700 hover:text-dark">
                                    <i class="fa-solid fa-earth-europe me-1 align-middle" style="font-size: 0.9rem;"></i>
                                    <span class="align-middle">English</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 767px) {
        .header-area {
            padding: 10px 0;
        }
        .header-right-content ul.list-inline {
            flex-wrap: wrap;
            justify-content: center !important;
        }
        .header-right-content .list-inline-item.border-start {
            border-left: none !important;
        }
        .header-right-content a {
            display: flex;
            align-items: center;
        }
        .header-left-bar-text,
        .header-right-content {
            text-align: center !important;
        }
        .row.align-items-center {
            flex-direction: column;
        }
        .col-sm-4, .col-sm-8 {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
