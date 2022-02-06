@extends("backend.layouts.app")
@section('style')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Bài viết', ['Danh sách', 'Thêm bài viết']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Thêm bài viết</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.postlist.store') }}" method="POST"
                                class="row justify-content-center g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="invalid-feedback is-invalid d-block mt-2">{{ $errors->first('title') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Mô tả</label>
                                    <input type="text" name="description" class="form-control"
                                        value="{{ old('description') }}">
                                    @error('description')
                                        <span
                                            class="invalid-feedback is-invalid d-block mt-2">{{ $errors->first('description') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nội dung</label>
                                    <textarea id="tinymce" name="content"
                                        class="form-control">{{ old('content') }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback is-invalid d-block mt-2">{{ $errors->first('content') }}
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
                                    <label class="form-label fw-bold">Thứ tự</label>
                                    <input type="number" name="ordering" class="form-control"
                                        value="{{ old('ordering') ? old('ordering') : 0 }}">
                                    @error('ordering')
                                        <span
                                            class="invalid-feedback is-invalid d-block mt-2">{{ $errors->first('ordering') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Từ khóa</label>
                                    <input type="text" name="keyword" class="form-control"
                                        value="{{ old('keyword') }}">
                                    @error('keyword')
                                        <span
                                            class="invalid-feedback is-invalid d-block mt-2">{{ $errors->first('keyword') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">Hình ảnh</label>
                                    <input name="image" type="file" class="form-control">
                                    @error('image')
                                        <span class="invalid-feedback is-invalid d-block mt-2">{{ $errors->first('image') }}
                                        </span>
                                    @enderror
                                </div>
                                {!! Form::submit_close(route('backend.postlist.index')) !!}
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
