<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\SiteSetting::get('meta_title', 'Zerox – Pharmaceuticals'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description', 'Official web portal of Zerox Pharmaceuticals Ltd.'))">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Custom overrides to match zzerox.com exact layout and dynamic features */
        .verification__loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            min-height: 120px;
        }
        .verification__loader-spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-top-color: #c9a227;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        .verification__loader-text {
            margin-top: 20px;
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .modal-custom {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
        }
        .modal-custom-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 8px;
            max-width: 550px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }
        .modal-custom-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .modal-custom-close:hover {
            color: #000;
        }
        .product-gallery-thumbs {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .product-gallery-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .product-gallery-thumb:hover, .product-gallery-thumb.active {
            border-color: #c9a227;
        }
    </style>
    @yield('styles')
</head>
<body>

<header class="header header_white">
    <div class="container">
        <div class="row">
            <nav class="header__nav header__nav_left">
                <ul id="menu-top-left-menu">
                    <li class="{{ request()->routeIs('home') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="{{ request()->routeIs('about') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="{{ request()->routeIs('category.show') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('category.show', 'tablets') }}">Products</a>
                    </li>
                </ul>
            </nav>
            <a href="{{ route('home') }}" class="header__logo">
                <img src="{{ asset('img/logo.png') }}" alt="Zerox">
            </a>
            <nav class="header__nav header__nav_right">
                <ul id="menu-top-right-menu">
                    <li class="{{ request()->routeIs('authenticity') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('authenticity') }}">Authenticity</a>
                    </li>
                    <li class="{{ request()->routeIs('analysis') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('analysis') }}">Analysis</a>
                    </li>
                    <li class="{{ request()->routeIs('contact') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
            </nav>
            <div class="mobile-menu" id="mobileMenuToggle">
                <div class="mobile-menu__icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <a href="{{ route('home') }}" class="footer__logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Zerox">
                    </a>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="footer__phones">
                        <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}">{{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}</a>
                        <a href="tel:{{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}">{{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}</a>
                    </div>
                </div>
                <div class="col-md-2 col-xs-12">
                    <nav class="footer__nav">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-2 col-xs-12">
                    <nav class="footer__nav">
                        <ul>
                            <li><a href="{{ route('category.show', 'tablets') }}">Products</a></li>
                            <li><a href="{{ route('authenticity') }}">Authenticity</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-2 col-xs-12">
                    <nav class="footer__nav">
                        <ul>
                            <li><a href="{{ route('analysis') }}">Analysis</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            @auth
                                <li><a href="{{ route('admin.dashboard') }}" style="color: #c9a227;">Admin Panel</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Partner Login</a></li>
                            @endauth
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="footer__copyright">
                        {{ date('Y') }} Zerox Pharmaceuticals. All Rights reserved.
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="footer__social">
                        <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <a href="#"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
                        <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#"><i class="fab fa-google-plus-g"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('css/lightbox.min.css') }}"></script>

@yield('scripts')
</body>
</html>
