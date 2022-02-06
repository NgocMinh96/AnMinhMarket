<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="icon-logo d-none" style="height:40px">
            <img src="{{ asset('images/' . $webInfo->favicon) }}" width="100%" height="100%">
        </div>
        <div class="toggle-logo" style="height:40px;">
            <img src="{{ asset('images/' . $webInfo->logo) }}" height="100%">
        </div>
    </div>

    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('backend.setting.index') }}">
                <div class="parent-icon"><i class='bx bx-wrench'></i>
                </div>
                <div class="menu-title">Cài đặt trang</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-user-circle'></i>
                </div>
                <div class="menu-title">Thành Viên</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('backend.user.index') }}"><i class="bx bx-right-arrow-alt"></i>Danh Sách</a>
                </li>
                <li>
                    <a href="{{ route('backend.role.index') }}"><i class="bx bx-right-arrow-alt"></i>Vai trò</a>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='lni lni-library'></i>
                </div>
                <div class="menu-title">Bài Viết</div>
            </a>
            <ul>
                {{-- <li> <a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Danh Mục</a>
                </li> --}}
                <li>
                    <a href="{{ route('backend.postlist.index') }}"><i class="bx bx-right-arrow-alt"></i>Danh Sách</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-store'></i>
                </div>
                <div class="menu-title">Cửa Hàng</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('backend.productcategory.index') }}"><i class="bx bx-right-arrow-alt"></i>Danh
                        Mục</a>
                </li>
                <li>
                    <a href="{{ route('backend.productlist.index') }}"><i class="bx bx-right-arrow-alt"></i>Sản
                        Phẩm</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('backend.coupon.index') }}">
                <div class="parent-icon"><i class='bx bxs-discount'></i>
                </div>
                <div class="menu-title">Mã giảm giá</div>
            </a>
        </li>
        <li>
            <a href="{{ route('backend.order.index') }}">
                <div class="parent-icon"><i class='bx bx-cart-alt'></i>
                </div>
                <div class="menu-title">Đơn hàng</div>
            </a>
        </li>
    </ul>
</div>
