<section class="header-part">
    <div class="container">
        <div class="header-content-group d-flex justify-content-between align-items-center">
            <div class="header-widget-group left">
                <button class="tab-widget header-user" title="Navbar">
                    <i class="icofont-navigation-menu"></i>
                </button>
                <a class="header-logo" href="{{ route('frontend.shop.index') }}">
                    <img src="{{ asset('images/' . $webInfo->logo) }}" alt="logo">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="navbar-list">
                    <li class="navbar-item dropdown">
                        <a class="navbar-link {{ Request::segment(1) == 'cua-hang' ? 'active' : '' }}"
                            href="{{ route('frontend.shop.index') }}">CỬA HÀNG</a>
                    </li>
                    <li class="navbar-item dropdown">
                        <a class="navbar-link {{ Request::segment(1) == 'bai-viet' ? 'active' : '' }}"
                            href="{{ route('frontend.post.index') }}">BÀI VIẾT</a>
                    </li>
                    <li class="navbar-item dropdown">
                        <a class="navbar-link {{ Request::segment(1) == 'lien-he' ? 'active' : '' }}"
                            href="{{ route('frontend.contact.index') }}">LIÊN HỆ</a>
                    </li>
                </ul>
                <div class="ms-4">
                    <button class="header-widget header-cart" title="Giỏ hàng">
                        <i class="icofont-shopping-cart"></i>
                        @if (session()->has('cart') && count(session()->get('cart')) <= 9)
                            <sup id="supProduct">{{ count(session()->get('cart')) }}</sup>
                        @elseif(session()->has('cart') && count(session()->get('cart')) > 9)
                            <sup id="supProduct">9+</sup>
                        @endif
                    </button>
                </div>
            </div>

        </div>
</section>

<aside class="mobile-nav">
    <div class="nav-container">
        <div class="nav-header">
            <a href="#">
                <img src="{{ asset('images/' . $webInfo->logo) }}" alt="logo">
            </a>
            <button class="nav-close"><i class="icofont-close"></i>
            </button>
        </div>
        <div class="nav-content">
            <ul class="nav-list">
                <li>
                    <a class="nav-link {{ Request::segment(1) == 'cua-hang' ? 'active' : '' }}"
                        href="{{ route('frontend.shop.index') }}"><i class="icofont-home"></i>CỬA HÀNG</a>
                </li>
                <li>
                    <a class="nav-link {{ Request::segment(1) == 'bai-viet' ? 'active' : '' }}"
                        href="{{ route('frontend.post.index') }}"><i class="icofont-newspaper"></i>BÀI VIẾT</a>
                </li>
                <li>
                    <a class="nav-link {{ Request::segment(1) == 'lien-he' ? 'active' : '' }}"
                        href="{{ route('frontend.contact.index') }}"><i class="icofont-contacts"></i></i>LIÊN HỆ</a>
                </li>
            </ul>
            <div class="nav-info-group">
                <div class="nav-info"><i class="icofont-ui-touch-phone"></i>
                    <p><small>Điện thoại</small><span>{{ $webInfo->phone }}</span></p>
                </div>
                <div class="nav-info"><i class="icofont-ui-email"></i>
                    <p><small>Email</small><span>{{ $webInfo->email }}</span></p>
                </div>
            </div>
        </div>
    </div>
</aside>
