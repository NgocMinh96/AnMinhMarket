@extends("frontend.layouts.app")
@section('style')
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <style>
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

    </style>
@endsection

@section('wrapper')
    <div class="inner-section">
        <div class="container">
            @if (!session()->has('cart'))
                <div class="d-flex justify-content-center p-5">
                    <div class="card" style="width: 500px">
                        <div class="card-body text-center">
                            @if (Session::has('order_compelete'))
                                <i class="icofont-check-circled icofont-5x text-success"></i>
                                <p class="my-3 fs-5">Đơn hàng <span
                                        class="text-primary">#{{ session('order_compelete') }}</span> đặt thành công !
                                </p>
                            @else
                                <p class="my-3 fs-5">Chưa có sản phẩm nào trong giở hàng</p>
                            @endif
                            <a href="{{ route('frontend.shop.index') }}" class="btn btn-custom text-light">
                                Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row my-4">
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="shop-widget-title">
                                    <h4>Bạn có <span id="totalCart">{{ count(session()->get('cart')) }}</span> sản phẩm
                                    </h4>
                                </div>
                                <ul class="mx-4">
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
                                            <div class="cart-info-group d-flex justify-content-between">
                                                <div class="cart-info">
                                                    <h5>
                                                        <a href="#">{{ $item['name'] }}</a>
                                                    </h5>
                                                    <p>{{ number_format($item['price']) }} ₫</p>
                                                </div>
                                                <div class="cart-action-group d-block">
                                                    <div class="product-action">
                                                        <button class="action-minus"
                                                            onclick="minusCart({{ $item['id'] }})">
                                                            <i class="icofont-minus"></i>
                                                        </button>
                                                        <input class="action-input" type="number" name="quantity"
                                                            id="quantity-{{ $item['id'] }}"
                                                            value="{{ $item['quantity'] }}" min="0" max="10" readonly>
                                                        <button class="action-plus"
                                                            onclick="plusCart({{ $item['id'] }})">
                                                            <i class="icofont-plus"></i>
                                                        </button>
                                                    </div>
                                                    <h5 id="itemPrice-{{ $item['id'] }}" class="text-center mt-2">
                                                        {{ number_format($item['price'] * $item['quantity']) }} đ
                                                    </h5>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="card-header">
                                    <p>Thông tin khách hàng</p>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <form id="checkoutForm" action="{{ route('backend.order.store') }}" method="POST"
                                        enctype="multipart/form-data" class="needs-validation" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 mt-3">
                                                <input type="text"
                                                    class="form-control {{ $errors->first('name') != null ? 'is-invalid' : '' }}"
                                                    name="name" placeholder="Nhập họ và tên" value="{{ old('name') }}">
                                                @error('name')
                                                    <span class="invalid-feedback">{{ $errors->first('name') }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 my-3">
                                                <input type="number"
                                                    class="form-control {{ $errors->first('phone') != null ? 'is-invalid' : '' }}"
                                                    name="phone" placeholder="Nhập số điện thoại"
                                                    value="{{ old('phone') }}">
                                                @error('phone')
                                                    <span class="invalid-feedback">{{ $errors->first('phone') }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 mb-3">
                                                <select name="province"
                                                    class="province-select {{ $errors->first('province') != null ? 'is-invalid' : '' }}">
                                                    <option></option>
                                                    @foreach ($province as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('province') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('province')
                                                    <span class="invalid-feedback">{{ $errors->first('province') }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 mb-3">
                                                <select name="district"
                                                    class="district-select {{ $errors->first('district') != null ? 'is-invalid' : '' }}">
                                                    <option></option>
                                                    @if (old('district') != null)
                                                        @foreach (session()->get('district') as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('district') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('district')
                                                    <span class="invalid-feedback">{{ $errors->first('district') }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <select name="ward"
                                                    class="ward-select {{ $errors->first('ward') != null ? 'is-invalid' : '' }}">
                                                    <option></option>
                                                    @if (old('district') != null)
                                                        @foreach (session()->get('ward') as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('ward') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('ward')
                                                    <span class="invalid-feedback">{{ $errors->first('ward') }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group">
                                                    <input type="text" name="address"
                                                        class="form-control {{ $errors->first('address') != null ? 'is-invalid' : '' }}"
                                                        placeholder="Nhập địa chỉ" value="{{ old('address') }}">
                                                    @error('address')
                                                        <span class="invalid-feedback">{{ $errors->first('address') }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="payment_method_1" value="1">
                                                    <label class="form-check-label" for="payment_method_1">
                                                        Thanh toán khi nhận hàng
                                                    </label>
                                                    @error('payment_method')
                                                        <span
                                                            class="invalid-feedback d-block">{{ $errors->first('payment_method') }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="shop-widget-title">Thông tin đơn hàng</h4>
                                <div class="d-flex justify-content-between my-2">
                                    <span>Tổng tiền</span>
                                    <span id="totalPrice">{{ number_format(session()->get('totalPrice')) }} đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Khuyến mãi giảm</span>
                                    <span id="discount">0 đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí giao hàng dự kiến</span>
                                    <span>0 đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Cần thanh toán</span>
                                    <span id="lastPrice">{{ number_format(session()->get('totalPrice')) }} đ</span>
                                </div>
                                <div class="text-center">
                                    <button class="coupon-btn">
                                        <i class="icofont-sale-discount"></i>
                                        Sử dụng mã giảm giá
                                    </button>
                                    <div class="coupon-form">
                                        <input type="text" id="formCoupon" placeholder="Nhập mã giảm giá"
                                            class="input-coupon" value="">
                                        <button onclick="applyCoupon()">
                                            <span>Áp dụng</span>
                                        </button>
                                    </div>
                                    <span id="invalid-coupon" class="invalid-feedback d-block mb-3"></span>
                                    <a class="cart-checkout-btn" href="#" onclick="$('#checkoutForm').submit()">
                                        <span class="checkout-label">Hoàn tất đặt hàng</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        const updateCart = (id, type) => {
            $.ajax({
                url: "{{ route('frontend.cart.update') }}",
                type: 'GET',
                data: {
                    id: id,
                    type: type
                },
                success: function(data) {
                    $itemPrice = formatNumber(data.cart.price * data.cart.quantity) + ' đ'
                    console.log($itemPrice)
                    $('[id="itemPrice-' + id + '"]').slice(0).text($itemPrice);
                    $('[id="itemQuantity-' + id + '"]').slice(0).text(' x ' + data.cart.quantity);
                    $('#totalPrice').text(formatNumber(data.totalPrice) + ' đ')
                    $('#discount').text('0 đ')
                    $('#lastPrice').text(formatNumber(data.totalPrice) + ' đ')
                }
            })
        }

        const plusCart = (id = '', option = '') => {
            var $qty = $('#quantity-' + id);
            var currentVal = parseInt($qty.val(), 10);
            if (!isNaN(currentVal)) {
                $qty.val(currentVal + 1);
            }
            // if (option == 'update') 
            updateCart(id, 'plus')
        }

        const minusCart = (id = '', option = '') => {
            var $qty = $('#quantity-' + id);
            var currentVal = parseInt($qty.val(), 10);
            if (!isNaN(currentVal) && currentVal > 1) {
                $qty.val(currentVal - 1);
            }
            // if (option == 'update')
            updateCart(id, 'minus')
        }

        const applyCoupon = () => {
            $.ajax({
                url: "{{ route('frontend.cart.applyCoupon') }}",
                data: {
                    coupon: $('#formCoupon').val()
                },
                success: function(data) {
                    $('#invalid-coupon').empty()
                    if (data.error != '') {
                        $('#invalid-coupon').text(data.error)
                    }
                    if (data.success == true) {
                        console.log(data.coupon)
                        $('#discount').text(formatNumber(data.coupon.amount) + ' đ')
                        $('#lastPrice').text(formatNumber(data.lastPrice) + ' đ')
                    }
                }
            })
        }

        $('.province-select').on('select2:select', function(e) {
            var data = e.params.data;
            var id = data.id
            $.ajax({
                url: "{{ route('frontend.cart.getDistrict') }}",
                type: 'GET',
                data: {
                    id: data.id,
                },
                success: function(data) {
                    $('.district-select').empty().html('<option></option>')
                    $('.ward-select').empty().html('<option></option>')
                    $.each(data.district, function(index, value) {
                        $('.district-select').append(
                            `<option value="${value.id}">${value.name}</option>`)
                    })
                }
            })
        });

        $('.district-select').on('select2:select', function(e) {
            var data = e.params.data;
            var id = data.id
            $.ajax({
                url: "{{ route('frontend.cart.getWard') }}",
                type: 'GET',
                data: {
                    id: data.id,
                },
                success: function(data) {
                    $('.ward-select').empty().html('<option></option>')
                    $.each(data.ward, function(index, value) {
                        $('.ward-select').append(
                            `<option value="${value.id}">${value.name}</option>`)
                    })
                }
            })
        });
    </script>
@endsection
