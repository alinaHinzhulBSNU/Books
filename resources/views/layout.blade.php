<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <!--Font Awesome Icons-->
    <script src="https://kit.fontawesome.com/66af6c845b.js" crossorigin="anonymous"></script>
    <!--Bootstrap-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <!--Власні стилі-->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <!--JS-->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
    <!--Заголовок-->
    <div class="header">
        <!--Іконки-->
        <nav class="icons my-2 my-md-0 mr-md-3">
            @can('admin')
                <a class="p-2" href="/admin/users">
                    <i class="fas fa-cog"></i>
                </a>
            @endcan
            @can('manage')
                <a class="p-2" href="/admin/orders">
                    <i class="fas fa-cog"></i>
                </a>
            @endcan
            @guest
                @if(Route::has('register'))
                    <a class="p-2" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                    </a>
                @endif
                <a class="p-2" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            @else
                <!--Профіль-->
                @can('surf')
                    <a class="p-2" href="/profile/orders">
                        <i class="p-2 far fa-user"></i>
                    </a>
                @endcan

                <!--Корзина-->
                @can('surf')
                    <a class="p-2" href="/cart/items">
                        <i class="p-2 fas fa-shopping-bag"></i>
                    </a>
                @endcan

                <!--Logout-->
                <a class="p-2" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
        </nav>

        <!--НАЗВА САЙТУ-->
        <div class="title">
            <a href="/">
                <h1>books</h1>
            </a>
        </div>
        <!--Меню-->
        <nav class="my-2 my-md-0 mr-md-3 text-white">
            <a class="p-2" href="/books">книги</a>
            <span>/</span>

            <a class="p-2" href="/authors">автори</a>
            <span>/</span>

            <a class="p-2" href="/publishers">видавництва</a>
            <span>/</span>

            <a class="p-2" href="/genres">жанри</a>
            <span>/</span>

            <a class="p-2" href="/about">про нас</a>
        </nav>
    </div>

    <!--Зміст-->
    <div class="content container-fluid">
        @yield('content')
    </div>

    <!--Footer-->
    <div class="footer">
        <p class="footer-text">©2020 books</p>
        <p class="footer-text">All Rights Reserved</p>
    </div>
</body>
</html>
