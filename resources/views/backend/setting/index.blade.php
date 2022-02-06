@extends("backend.layouts.app")
@section('style')
    <link href="{{ asset('assets/plugins/colorpicker/spectrum.css') }}" rel="stylesheet" />
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Cài đặt', []) !!}

            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        {{-- section left --}}
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-label fw-bold">Favicon</div>
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="height: 60px">
                                                <img src="{{ asset('images/' . $webInfo->favicon) }}" height="100%">
                                            </div>
                                            <form action="{{ route('backend.setting.update', ['favicon']) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="my-3">
                                                    <input name="favicon" type="file" class="form-control">
                                                </div>
                                                @error('favicon')
                                                    <span class="invalid-feedback is-invalid d-block my-2"
                                                        role="alert">{{ $errors->first('favicon') }}
                                                    </span>
                                                @enderror
                                                <div class="d-flex justify-content-center">
                                                    {!! Form::btn_submit('', 'bx bx-save') !!}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-label fw-bold">Logo</div>
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="height: 60px">
                                                <img src="{{ asset('images/' . $webInfo->logo) }}" class="card-img-top">
                                            </div>
                                            <form action="{{ route('backend.setting.update', ['logo']) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="my-3">
                                                    <input name="logo" type="file" class="form-control">
                                                </div>
                                                @error('logo')
                                                    <span class="invalid-feedback is-invalid d-block my-2"
                                                        role="alert">{{ $errors->first('logo') }}
                                                    </span>
                                                @enderror
                                                <div class="d-flex justify-content-center">
                                                    {!! Form::btn_submit('', 'bx bx-save') !!}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-label fw-bold">Banner</div>
                                        <form action="{{ route('backend.setting.update', ['banner']) }}" method="POST"
                                            enctype="multipart/form-data" class="row g-3">
                                            @csrf
                                            @method('PUT')
                                            <img src="{{ asset('images/' . $webInfo->banner) }}" class="card-img-top">
                                            <div class="col-md-12">
                                                <input name="banner" type="file" class="form-control">
                                            </div>
                                            @error('banner')
                                                <span class="invalid-feedback is-invalid d-block my-2"
                                                    role="alert">{{ $errors->first('banner') }}
                                                </span>
                                            @enderror
                                            <div class="d-flex justify-content-center">
                                                {!! Form::btn_submit('', 'bx bx-save') !!}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- section right --}}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row g-3" action="{{ route('backend.setting.update', ['info']) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Thương hiệu</label>
                                            <input name="brand" type="text" class="form-control"
                                                value="{{ $webInfo->brand }}">
                                            @error('brand')
                                                <span class="invalid-feedback is-invalid d-block mt-2"
                                                    role="alert">{{ $errors->first('brand') }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Màu sắc</label>
                                            <input name="color" id="color-picker" class="form-control"
                                                value="{{ $webInfo->color }}" />
                                            @error('color')
                                                <span class="invalid-feedback is-invalid d-block mt-2"
                                                    role="alert">{{ $errors->first('color') }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Số điện thoại</label>
                                            <input name="phone" type="text" class="form-control"
                                                value="{{ $webInfo->phone }}">
                                            @error('phone')
                                                <span class="invalid-feedback is-invalid d-block mt-2"
                                                    role="alert">{{ $errors->first('phone') }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Email</label>
                                            <input name="email" type="text" class="form-control"
                                                value="{{ $webInfo->email }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Địa chỉ</label>
                                            <input name="address" type="text" class="form-control"
                                                value="{{ $webInfo->address }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Bản đồ</label>
                                            <input name="map" type="text" class="form-control"
                                                value="{{ $webInfo->map }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Facebook</label>
                                            <input name="facebook" type="text" class="form-control"
                                                value="{{ $webInfo->facebook }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Messenger</label>
                                            <input name="messenger" type="text" class="form-control"
                                                value="{{ $webInfo->messenger }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Youtube</label>
                                            <input name="youtube" type="text" class="form-control"
                                                value="{{ $webInfo->youtube }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Từ khóa</label>
                                            <input name="keyword" class="form-control" value="{{ $webInfo->keyword }}">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {!! Form::btn_submit('', 'bx bx-save') !!}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/colorpicker/spectrum.js') }}"></script>

    <script>
        $('#color-picker').spectrum({
            preferredFormat: "rgb",
            type: "text",
            showAlpha: false
        });
    </script>
@endsection
