@extends("frontend.layouts.app")
@section('style')
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
@endsection

@section('wrapper')
    <div class="banner-part">
        <div class="container">
            <div class="col-lg-12">
                <div class="home-category-slider slider-arrow slider-dots">
                    <img src="{{ asset('images/' . $webInfo->banner) }}" alt="banner">
                    {{-- <img src="{{ asset('client/images/home/category/02.jpg') }}" alt="banner">
                        <img src="{{ asset('client/images/home/category/03.jpg') }}" alt="banner"> --}}
                </div>
            </div>
        </div>
    </div>

    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-1 order-lg-0">
                    <div class="shop-widget">
                        <h4 class="shop-widget-title">Danh mục</h4>
                        <ul class="shop-widget-list shop-widget-scroll">
                            <li class="{{ Request::routeIs('frontend.shop.index') ? 'active' : '' }}">
                                <div class="shop-widget-content">
                                    <label>
                                        <a class="text-link" href="{{ route('frontend.shop.index') }}">Hàng mới</a>
                                    </label>
                                </div>
                            </li>
                            @foreach ($category as $item)
                                <li class="{{ Request::segment(3) == $item->id ? 'active' : '' }}">
                                    <div class="shop-widget-content">
                                        <label>
                                            <a class="text-link"
                                                href="{{ route('frontend.shop.category', ['slug' => $item->slug, 'category_id' => $item->id]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="shop-widget-promo">
                        <a href="#">
                            <img src="{{ asset('client/images/promo/shop/01.jpg') }}" alt="promo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 order-0 order-lg-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shop-filter">
                                <div class="card-body">
                                    <div class="d-flex align-items-center table-responsive">
                                        <a href="{{ url()->current() }}" class="me-3">
                                            <i class="icofont-refresh"></i>
                                        </a>
                                        <form method="GET" action="{{ url()->current() }}" class="d-flex w-100">
                                            <input name="search_value" type="text" class="form-control"
                                                placeholder="Tìm sản phẩm ..." value="{{ old('search_value') }}"
                                                style="width: 300px">
                                            <div class="mx-4">
                                                <select name="sort_price" class="single-select" style="width: 150px"
                                                    onchange="this.form.submit()">
                                                    <option value="">Sắp xếp</option>
                                                    <option value="DESC"
                                                        {{ old('sort_price') == 'DESC' ? 'selected' : '' }}>
                                                        Giá
                                                        giảm dần</option>
                                                    <option value="ASC"
                                                        {{ old('sort_price') == 'ASC' ? 'selected' : '' }}>Giá
                                                        tăng dần</option>
                                                </select>
                                            </div>
                                            <a href="{{ request()->fullUrlWithQuery(['sort_sale' => 'sale']) }}"
                                                class="btn text-nowrap">Đang giảm
                                                giá</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            @if ($product->count() == 0)
                                <div class="mb-2 text-center">
                                    <h3>Không tìm thấy {{ old('search_value') }}</h3>
                                </div>
                            @endif
                            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">
                                @foreach ($product as $item)
                                    <div class="col">
                                        <div class="product-card">
                                            <div class="product-media">
                                                @if ($item->label != null)
                                                    <div class="product-label">
                                                        <label class="label-text new">{{ $item->label }}</label>
                                                    </div>
                                                @endif
                                                <button class="product-wish wish"></button>
                                                <div class="product-image">
                                                    @if ($item->images->count() > 0)
                                                        <a
                                                            href="{{ route('frontend.shop.show', [$item->id, $item->slug]) }}">
                                                            <img src="{{ asset('images/' . $item->images[0]->image) }}">
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="product-widget">
                                                    @if ($item->video != null)
                                                        <a href="{{ $item->video }}" class="venobox icofont-ui-play"
                                                            data-autoplay="true" data-vbtype="video">
                                                        </a>
                                                    @endif
                                                    <a title="Xem" onclick="quickView({{ $item->id }})"
                                                        class="icofont-eye-alt">
                                                    </a>
                                                    <a class="icofont-cart" type="button"
                                                        onclick="storeCart({{ $item->id }})">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h6 class="product-name">
                                                    <a
                                                        href="{{ route('frontend.shop.show', [$item->id, $item->slug]) }}">{{ $item->name }}</a>
                                                </h6>
                                                <div class="d-flex justify-content-center">
                                                    @if ($item->sale > 0)
                                                        <h5 class="product-price">
                                                            <span
                                                                style="color: var(--red)">{{ number_format($item->price - $item->price * ($item->sale / 100)) }}
                                                                ₫</span>
                                                        </h5>
                                                        <label class="label-text off ms-1"
                                                            cursorshover="true">-{{ $item->sale }}%</label>
                                                    @else
                                                        <h5 class="product-price">
                                                            <span>{{ number_format($item->price) }} ₫</span>
                                                        </h5>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-12 shop-pagination">
                            {{ $product->onEachSide(1)->withQueryString()->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <div class="modal fade" id="product-view" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button class="modal-close icofont-close" data-bs-dismiss="modal"></button>
                <div class="product-view" id="quickView">

                </div>
            </div>
        </div>
    </div>

    <div class="hotline-phone-ring-wrap">
        <div class="hotline-phone-ring">
            <div class="hotline-phone-ring-circle"></div>
            <div class="hotline-phone-ring-circle-fill"></div>
            <div class="hotline-phone-ring-img-circle">
                <a href="tel:{{ $webInfo->phone }}" class="pps-btn-img">
                    <img src="{{ asset('images/phone.png') }}" alt="Số điện thoại" width="20px;">
                </a>
            </div>
            <span class="phone_text text-end">{{ $webInfo->phone }}</span>
        </div>
    </div>

    <!-- Messenger Plugin chat Code -->
    {!! $webInfo->messenger !!}

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script>
        new PerfectScrollbar(".shop-widget-list");

        const quickView = (id) => {
            $('#quickView').empty()
            $.ajax({
                url: "{{ route('frontend.modal') }}",
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(data) {
                    $('#quickView').html(data.xhtml);
                    config()
                    $('#product-view').modal('show');
                }
            })
        }

        const config = () => {
            $(".preview-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: !0,
                fade: !0,
                prevArrow: '<i class="icofont-arrow-right dandik"></i>',
                nextArrow: '<i class="icofont-arrow-left bamdik"></i>',
            });
            $(".modal").on("shown.bs.modal", (function(i) {
                $(".preview-slider, .thumb-slider").slick("setPosition"), $(
                    ".product-details-image").addClass("slider-opacity")
            }))
        }
    </script>
@endsection
