<header>
    @php $menusHtml = \App\Helpers\Helper::menus($menus); @endphp
    <!-- Header desktop -->
    <div class="container-menu-desktop">

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="#" class="logo">
                    <h1 style=" font-family: 'PlayfairDisplay-Bold'; color: black;">Happy Chicken</h1>
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu"><a href="/">Trang Chủ</a> </li>

                        {!! $menusHtml !!}

                        <li>
                            <a href="contact.html">Liên Hệ</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m 1111">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                        data-notify="{{ !is_null(\Session::get('carts')) ? count(\Session::get('carts')) : 0 }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>


                    <!-- Nếu người dùng đã đăng nhập (customer) -->
                    @if (Auth::guard('customer')->check())
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::guard('customer')->user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- Logout -->
                            <a class="dropdown-item" href="{{ route('signout.customer') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('signout.customer') }}" method="POST" class="d-none">
                                @csrf
                            </form>


                            <!-- Profile -->
                            <a class="dropdown-item" href="{{ route('profile.customer') }}"
                                onclick="event.preventDefault();
                                                 document.getElementById('profile-form').submit();">
                                {{ __('Profile') }}
                            </a>
                            <form id="profile-form" action="{{ route('profile.customer') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                            <!-- Profile -->
                            <a class="dropdown-item" href="{{ route('wishlist.index') }}"
                                onclick="event.preventDefault();
                                                 document.getElementById('wishlist-form').submit();">
                                {{ __('Yeu thich') }}
                            </a>
                            <form id="wishlist-form" action="{{ route('wishlist.index') }}" method="POST" class="d-none">
                                @csrf
                            </form>






                            </div>
                        </li>

                    @else
                        <!-- Nếu người dùng chưa đăng nhập, hiển thị form login -->
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 ">
                            <a href="{{ route('login.customer') }}"><i class="zmdi zmdi-account"></i></a>
                        </div>
                    @endif



                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="/template/images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li class="active-menu"><a href="/">Trang Chủ</a> </li>

            {!! $menusHtml !!}

            <li>
                <a href="contact.html">Liên Hệ</a>
            </li>

        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="/template/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form action="{{ route('search.products') }}" class="wrap-search-header flex-w p-l-15" method="GET">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>

        </div>
    </div>
</header>
