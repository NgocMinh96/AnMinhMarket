<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="template" content="{{ $webInfo->brand }}">
    <meta name="title" content="{{ $webInfo->brand }}">
    <meta name="keywords" content="organe, organic, food, shop">
    <title>{{ $webInfo->brand }}</title>
    <link rel="icon" href="{{ asset('images/' . $webInfo->favicon) }}">
    <link rel="stylesheet" href="{{ asset('client/fonts/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonts/icofont/icofont.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('client/css/vendor/jquery-ui.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('client/css/vendor/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/vendor/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/custom/main.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/custom/home-category.css') }}">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/notifications/css/lobibox.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('client/css/custom/custom.css') }}">

    @yield("style")
    <style>
        :root {
            --color-custom: {{ $webInfo->color }};
            --color-custom-light: {{ str_replace(',', '', str_replace(')', ' /.12)', $webInfo->color)) }};
        }

    </style>
</head>

<body>
    @include("frontend.layouts.header")

    @yield("wrapper")
    <footer class="footer-bottom">
        <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-center">
            <p class="order-lg-1 order-2 fs-sm mb-2 mb-lg-0">
                <span class="opacity-60">
                    © All rights reserved. Made by
                </span>
                <a class="nav-link-light fw-bold" href="#">{{ $webInfo->brand }}</a>
            </p>
        </div>
    </footer>

    <aside class="category-part">
        <div class="category-container">
            <div class="category-header">
                <a href="#"><img src="{{ asset('images/' . $webInfo->logo) }}" alt="logo"></a>
                <button class="category-close"><i class="icofont-close"></i></button>
            </div>
            <ul class="category-list">
                <li class="{{ Request::routeIs('frontend.shop.index') ? 'active' : '' }}">
                    <a class="cate-link" href="{{ route('frontend.shop.index') }}">Hàng mới</a>
                </li>
                @foreach ($categories as $item)
                    <li class="{{ Request::segment(3) == $item->id ? 'active' : '' }}">
                        <a class="cate-link"
                            href="{{ route('frontend.shop.category', ['slug' => $item->slug, 'category_id' => $item->id]) }}">
                            {{ $item->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <aside class="cart-part">
        <div class="cart-container">
            <div class="cart-header">
                <div class="cart-total">
                    <i class="icofont-shopping-cart"></i>
                    <span>Giỏ hàng</span>
                </div>
                <button class="cart-close">
                    <i class="icofont-close"></i>
                </button>
            </div>
            <ul class="cart-list">
                @if (session()->get('cart') != null)
                    @foreach (session()->get('cart') as $item)
                        <li class="cart-item" id="cart-{{ $item['id'] }}">
                            <div class="cart-media">
                                <a href="#">
                                    <img src="{{ asset('images/' . $item['image']) }}" alt="product">
                                </a>
                                <button type="button" class="cart-delete"
                                    onclick="destroyCart({{ $item['id'] }})">
                                    <i class="icofont-bin"></i>
                                </button>
                            </div>
                            <div class="cart-info-group">
                                <div class="cart-info">
                                    <h6><a href="product-single.html">{{ $item['name'] }}</a></h6>
                                    <p>{{ number_format($item['price']) }}<span
                                            id="itemQuantity-{{ $item['id'] }}"> x {{ $item['quantity'] }}</span>
                                    </p>
                                </div>
                                <div class="cart-action-group">
                                    <h6 id="itemPrice-{{ $item['id'] }}">
                                        {{ number_format($item['price'] * $item['quantity']) }} đ</h6>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <div id="cart-none" class="text-center p-5">
                        <span class="fs-5">Bạn chưa có sản phẩm</span>
                    </div>
                @endif
            </ul>
            <div class="cart-footer">
                <a class="cart-checkout-btn" href="{{ route('frontend.cart.index') }}">
                    <span class="checkout-label">Tiến hành đặt hàng</span>
                    <span class="checkout-price">{{ number_format(session()->get('totalPrice')) }}đ</span>
                </a>
            </div>
        </div>
    </aside>

    <menu class="mobile-menu">
        <button class="cate-btn" title="Danh mục">
            <i class="icofont-listine-dots"></i>
            <span>Danh mục</span>
        </button>
        <button class="cart-btn header-cart" title="Giỏ hàng">
            <i class="icofont-shopping-cart"></i>
            <span>Giỏ hàng</span>
            @if (session()->has('cart') && count(session()->get('cart')) <= 9)
                <sup id="supProduct">{{ count(session()->get('cart')) }}</sup>
            @elseif(session()->has('cart') && count(session()->get('cart')) > 9)
                <sup id="supProduct">9+</sup>
            @endif
        </button>
        <a href="tel:{{ $webInfo->phone }}" title="Liên hệ">
            <i class="icofont-phone"></i>
            <span>Điện thoại</span>
        </a>
    </menu>

    <script src="{{ asset('client/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/jquery-ui.js') }}"></script>
    {{-- <script src="{{ asset('client/js/vendor/popper.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/venobox.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('client/js/custom/accordion.js') }}"></script>
    <script src="{{ asset('client/js/custom/venobox.js') }}"></script>
    <script src="{{ asset('client/js/custom/main.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/lobibox.js') }}"></script>
    <script src="{{ asset('client/js/custom/custom.js') }}"></script>

    @yield("script")

    <script>
        const formatNumber = (num) => {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        const storeCart = (id) => {
            $.ajax({
                url: "{{ route('frontend.cart.store') }}",
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(data) {
                    round_noti('default', data.cart[id].name + ' đã thêm vào giỏ hàng', 'top center',
                        "{{ asset('images/') }}" + '/' + data.cart[id].image)
                    let itemLength = Object.keys(data.cart).length
                    if ($('[id="supProduct"]').length) {
                        if (itemLength > 9) {
                            $('[id="supProduct"]').text('9+')
                        } else {
                            $('[id="supProduct"]').text(itemLength)
                        }
                    } else {
                        $('.header-cart i').after(`<sup id="supProduct">${itemLength}</sup>`)
                    }
                    $('#cart-none').remove()
                    $('.checkout-price').text(formatNumber(data.totalPrice) + 'đ')
                    $.each(data.cart, function(index, value) {
                        if ($('#cart-' + value.id).length) {
                            $('#itemPrice-' + value.id).text(formatNumber(value.price * value
                                .quantity) + 'đ');
                            $('#itemQuantity-' + value.id).text('x ' + value
                                .quantity);
                        } else {
                            $('.cart-list').append(
                                `<li class="cart-item" id="cart-${value.id}">  
                                <div class="cart-media">
                                    <a href="#">
                                        <img src="{{ asset('images/${value.image}') }}" alt="product">
                                    </a>
                                    <button type="button" class="cart-delete"
                                        onclick="destroyCart(${value.id})">
                                        <i class="icofont-bin"></i>
                                    </button>
                                </div>
                                <div class="cart-info-group">
                                <div class="cart-info">
                                    <h6><a href="#">${value.name}</a></h6>
                                    <p>${formatNumber(value.price)} <span
                                            id="itemQuantity-${value.id}"> x ${value.quantity}</span>
                                    </p>
                                </div>
                                <div class="cart-action-group">
                                    <h6 id="itemPrice-${value.id}">
                                        ${formatNumber(value.price * value.quantity)} đ</h6>
                                </div>
                            </div>
                            </li>`
                            )
                        }
                    })
                }
            })
        };

        const destroyCart = (id) => {
            $.ajax({
                url: "{{ route('frontend.cart.destroy') }}",
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(data) {
                    $('[id="cart-' + id + '"]').slice(0).remove();
                    $('#totalPrice').html(formatNumber(data.totalPrice) + 'đ')
                    let itemLength = Object.keys(data.cart).length
                    if (itemLength > 9) {
                        $('[id="supProduct"]').text('9+')
                    } else if (itemLength == 0) {
                        $('[id="supProduct"]').remove()
                    } else {
                        $('[id="supProduct"]').text(itemLength)
                    }
                    $('.checkout-price').text(formatNumber(data.totalPrice) + 'đ')
                    $('#discount').text('0 đ')
                    $('#lastPrice').text(formatNumber(data.totalPrice) + ' đ')
                }
            })
        }
    </script>

</body>

</html>
