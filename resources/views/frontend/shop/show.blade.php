@extends("frontend.layouts.app")
@section('style')
    <link href="{{ asset('client/css/custom/product-details.css') }}" rel="stylesheet" />
@endsection

@section('wrapper')
    {{-- <section class="container">
        <div class="p-3">
            <h2>{{ $product->name }}</h2>
        </div>
    </section> --}}

    <section class="inner-section my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="details-gallery">
                        <ul class="details-preview slider-arrow">
                            @foreach ($product->images as $item)
                                <li class="d-flex justify-content-center">
                                    <img src="{{ asset('images/' . $item->image) }}" alt="{{ $product->name }}">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5">
                    <ul class="product-navigation">
                        <li class="product-nav-prev">
                            @if ($product_previous != null)
                                <a
                                    href="{{ route('frontend.shop.show', [$product_previous->id, $product_previous->slug]) }}">
                                    <i class="icofont-arrow-left"></i> Lùi lại
                                    <span class="product-nav-popup">
                                        @if ($product_previous->images->count() > 0)
                                            <img src="{{ asset('images/' . $product_previous->images[0]->image) }}"
                                                alt="{{ $product_previous->slug }}">
                                        @endif
                                        <small>{{ $product_previous->name }}</small>
                                    </span>
                                </a>
                            @endif
                        </li>
                        <li class="product-nav-next">
                            @if ($product_next != null)
                                <a href="{{ route('frontend.shop.show', [$product_next->id, $product_next->slug]) }}">Xem
                                    tiếp
                                    <i class="icofont-arrow-right"></i>
                                    <span class="product-nav-popup">
                                        @if ($product_next->images->count() > 0)
                                            <img src="{{ asset('images/' . $product_next->images[0]->image) }}"
                                                alt="{{ $product_next->slug }}">
                                        @endif
                                        <small>{{ $product_next->name }}</small>
                                    </span>
                                </a>
                            @endif
                        </li>
                    </ul>
                    <div class="details-content">
                        <h3 class="details-name d-flex align-items-center">
                            <a href="#">{{ $product->name }}</a>
                            @if ($product->label != '')
                                <label class="view-label new ms-2">{{ $product->label }}</label>
                            @endif
                        </h3>
                        <div class="details-meta">
                            <p>MSP:<span>1234567</span></p>
                            <p>BRAND: radhuni</p>
                        </div>
                        <h3 class="details-price d-flex align-items-center">
                            @if ($product->sale > 0)
                                <span
                                    style="color: var(--red)">{{ number_format($product->price - $product->price * ($product->sale / 100)) }}
                                    ₫</span>
                                <label class="view-label off ms-2" cursorshover="true">-{{ $product->sale }}%</label>
                            @else
                                <span>{{ number_format($product->price) }} ₫</span>
                            @endif
                        </h3>
                        <div class="details-add-group">
                            <div class="details-list-group"><label class="details-list-title">tags:</label>
                                <ul class="details-tag-list">
                                    <li><a href="#">organic</a></li>
                                    <li><a href="#">fruits</a></li>
                                    <li><a href="#">chilis</a></li>
                                </ul>
                            </div>
                            <div class="details-list-group"><label class="details-list-title">Share:</label>
                                <ul class="details-share-list">
                                    <li><a href="#" class="icofont-facebook" title="Facebook"></a></li>
                                    <li><a href="#" class="icofont-twitter" title="Twitter"></a></li>
                                    <li><a href="#" class="icofont-linkedin" title="Linkedin"></a></li>
                                    <li><a href="#" class="icofont-instagram" title="Instagram"></a></li>
                                </ul>
                            </div>
                            <button class="product-add" onclick="storeCart({{ $product->id }})">
                                <i class="icofont-cart"></i>
                                <span>Thêm vào giỏ hàng</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="d-flex justify-content-center mb-3">
                    <h3>THÔNG TIN SẢN PHẨM</h3>
                </div>
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            @if ($product->video != '')
                                <div class=" text-center">
                                    <iframe class="details-youtube" src="{{ $product->video }}" frameborder="0"
                                        allowfullscreen></iframe>
                                </div>
                            @endif
                            <div class="details-description">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(".details-preview").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: !0,
            fade: !0,
            prevArrow: '<i class="icofont-arrow-right dandik"></i>',
            nextArrow: '<i class="icofont-arrow-left bamdik"></i>',
        });
    </script>
@endsection
