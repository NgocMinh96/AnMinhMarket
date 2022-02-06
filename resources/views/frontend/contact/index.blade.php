@extends("frontend.layouts.app")
@section('style')
    <link rel="stylesheet" href="{{ asset('client/css/custom/contact.css') }}">
    <style>
        body {
            background: #f5f5f5;
        }

    </style>
@endsection

@section('wrapper')
    <section class="inner-section mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="contact-map">
                            {!! $webInfo->map !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-lg-12">
                            <div class="d-flex flex-row contact-card align-items-center">
                                <div class="ms-2">
                                    <img src="{{ asset('images/map.png') }}" height="50px">
                                </div>
                                <div class="mx-2">
                                    <h5>Địa chỉ</h5>
                                    <p>{{ $webInfo->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-row contact-card align-items-center">
                                <div class="ms-2">
                                    <img src="{{ asset('images/call.png') }}" height="50px">
                                </div>
                                <div class="mx-2">
                                    <h5>Điện thoại</h5>
                                    <p>{{ $webInfo->phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-row contact-card align-items-center">
                                <div class="ms-2">
                                    <img src="{{ asset('images/gmail.png') }}" height="50px">
                                </div>
                                <div class="mx-2">
                                    <h5>Gmail</h5>
                                    <p>{{ $webInfo->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if ($webInfo->facebook != null)
                                <div class="col-lg-6">
                                    <a href="{{ $webInfo->facebook }}"
                                        class="d-flex flex-row contact-card align-items-center">
                                        <div class="ms-2">
                                            <img src="{{ asset('images/facebook.png') }}" height="50px">
                                        </div>
                                        <div class="mx-2">
                                            <h5>Facebook</h5>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if ($webInfo->youtube != null)
                                <div class="col-lg-6">
                                    <a href="{{ $webInfo->youtube }}"
                                        class="d-flex flex-row contact-card align-items-center">
                                        <div class="ms-2">
                                            <img src="{{ asset('images/youtube.png') }}" height="50px">
                                        </div>
                                        <div class="mx-2">
                                            <h5>Youtube</h5>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
    </section>

@endsection

@section('script')

@endsection
