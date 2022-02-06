@extends("frontend.layouts.app")
@section('style')

@endsection

@section('wrapper')

    <section class="container">
        <div class="p-3">
            <h2>{{ $post->title }}</h2>
            <span
                class="">{{ $post->author_name . ' / ' . date('d-m-Y', strtotime($post->created_at)) }}</span>
        </div>
    </section>

    <section class="inner-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-detail">
                        <img src="{{ asset('images/' . $post->image) }}" width="100%">
                        {!! $post->content !!}
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
                                        {{-- <span>{{ date('d-m-Y', strtotime($item->created_at)) }}</span> --}}
                                    </h6>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
