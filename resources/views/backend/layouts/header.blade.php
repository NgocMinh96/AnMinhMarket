<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu">
                <i class='bx bx-menu'></i>
            </div>
            <div class="top-menu ms-auto">
                <div class="form-switch">
                    <input class="form-check-input" type="checkbox" id="SwitchBG">
                </div>
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->image == '' ? asset('images/avatar.png') : asset('images/' . Auth::user()->image) }}"
                        class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('backend.userinfo.index', Auth::user()->id) }}">
                            <i class="bx bx-user"></i>
                            <span>Thông tin</span>
                        </a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('backend.logout') }}" class="float-right">
                            @csrf
                            <button class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class='bx bx-log-out-circle'></i>
                                <span>Đăng xuất</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
