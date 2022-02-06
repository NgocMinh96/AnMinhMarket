@extends("backend.layouts.app")
@section('style')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Cửa hàng', ['Sản phẩm', 'Thêm sản phẩm']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Thêm sản phẩm</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.productlist.store') }}" method="POST"
                                class="row justify-content-center g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="category" class="form-label fw-bold">Danh mục</label>
                                    <select name="category" class="single-select">
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('category') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('name') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Giá bán</label>
                                    <input type="text" name="price" class="form-control" value="0">
                                    @error('price')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('price') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Giảm giá</label>
                                    <input type="text" name="sale" class="form-control" value="0">
                                    @error('sale')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('sale') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nhãn mác</label>
                                    <input type="text" name="label" class="form-control" value="">
                                    @error('label')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('label') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nội dung</label>
                                    <textarea id="tinymce" name="description"
                                        class="form-control">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('description') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">Trạng thái</label>
                                    <select name="status" class="single-select">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="special" class="form-label fw-bold">Đặc biệt</label>
                                    <select name="special" class="single-select">
                                        <option value="0">Không</option>
                                        <option value="1">Có</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Video</label>
                                    <input type="text" name="video" class="form-control" value="{{ old('video') }}">
                                    @error('video')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('video') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">Hình ảnh</label>
                                    <input name="image[]" type="file" class="form-control" multiple>
                                    @error('image')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('image') }}
                                        </span>
                                    @enderror
                                </div>
                                {!! Form::submit_close(route('backend.productlist.index')) !!}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/tinymce/custom.js') }}"></script>
@endsection
