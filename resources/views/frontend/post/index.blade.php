@extends("frontend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    {{-- <section class="py-2">
        <div class="container border-bottom-5">
            <h3>BÀI VIẾT</h3>
        </div>
    </section> --}}

    <section class="inner-section mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 order-0 order-lg-0">
                    <div class="card shop-filter">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-1">
                                <a href="{{ url()->current() }}" class="me-3">
                                    <i class="icofont-refresh"></i>
                                </a>
                                <form method="GET" action="{{ url()->current() }}" class="d-flex" style="width: 100%">
                                    <input name="search_value" type="text" class="form-control" placeholder="Tìm bài viết ..."
                                        value="{{ old('search_value') }}" >
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if($postList->count() == 0)
                            <div class="mb-2 text-center">
                                <h3>Không tìm thấy '{{ old('search_value') }}'</h3>
                            </div>
                        @endif
                        @foreach ($postList as $item)
                            <div class="col-md-6 col-lg-6">
                                <div class="blog-card">
                                    <div class="blog-media">
                                        <a class="blog-img"
                                            href="{{ route('frontend.post.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                            <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->title }}">
                                        </a>
                                    </div>
                                    <div class="blog-content">
                                        <div class="blog-title">
                                            <a class="text-link"
                                                href="{{ route('frontend.post.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                                {{ $item->title }}
                                                {{-- {!! Form::short_title($item->title, 5) !!} --}}
                                            </a>
                                        </div>
                                        <ul class="blog-meta">
                                            <li>
                                                <i class="icofont-clock-time"></i>
                                                <span>{{ date('d-m-Y', strtotime($item->created_at)) }}</span>
                                            </li>
                                            <li>
                                                <i class="icofont-user-suited"></i>
                                                <span>{{ $item->author_name }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $postList->onEachSide(1)->withQueryString()->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-1 order-lg-0">
                    <div class="blog-widget">
                        <h4 class="blog-widget-title">PHỔ BIẾN</h4>
                        <ul class="blog-widget-feed">
                            @foreach ($postSpecial as $item)
                                <li>
                                    <a class="blog-widget-media" href="#">
                                        <img src="{{ asset('images/' . $item->image) }}" alt="blog-widget">
                                    </a>
                                    <h6 class="blog-widget-text">
                                        <a
                                            href="{{ route('frontend.post.show', ['id' => $item->id, 'slug' => $item->slug]) }}">{{ $item->title }}</a>
                                    </h6>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="shop-widget-promo">
                        <a href="#">
                            <img src="{{ asset('client/images/promo/blog/01.jpg') }}" alt="promo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
