@extends("backend.layouts.app")
@section('style')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Bài viết', ['Danh sách', 'Sửa bài viết']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Sửa bài viết</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.postlist.update', $post->id) }}" method="POST"
                                class="row justify-content-center g-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                                    @error('title')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('title') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Mô tả</label>
                                    <input type="text" name="description" class="form-control"
                                        value="{{ $post->description }}">
                                    @error('description')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('description') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nội dung</label>
                                    <textarea id="tinymce" name="content"
                                        class="form-control">{{ $post->content }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('content') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">Trạng thái</label>
                                    <select name="status" class="single-select">
                                        <option value="1" @if ($post->status == 1) selected @endif>Hiện</option>
                                        <option value="0" @if ($post->status == 0) Selected @endif>Ẩn</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="special" class="form-label fw-bold">Đặc biệt</label>
                                    <select name="special" class="single-select">
                                        <option value="0" @if ($post->special == 0) selected @endif>Không</option>
                                        <option value="1" @if ($post->special == 1) Selected @endif>Có</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Thứ tự</label>
                                    <input type="number" name="ordering" class="form-control"
                                        value="{{ $post->ordering }}">
                                    @error('ordering')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('ordering') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Từ khóa</label>
                                    <input type="text" name="keyword" class="form-control"
                                        value="{{ $post->keyword }}">
                                    @error('keyword')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('keyword') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="image" class="form-label fw-bold">Hình ảnh</label>
                                    <input name="image" type="file" class="form-control">
                                    @error('image')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('image') }}
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
