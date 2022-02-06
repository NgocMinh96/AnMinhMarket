@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Cửa hàng', ['Danh mục', 'Thêm danh mục']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Thêm danh mục</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.productcategory.update', $category->id) }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tên danh mục</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                                    @error('name')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('name') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="oerdering" class="form-label fw-bold">Thứ tự</label>
                                    <input name="ordering" type="text" class="form-control"
                                        value="{{ $category->ordering }}">
                                    @error('ordering')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('ordering') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">Trạng thái</label>
                                    <select name="status" class="single-select">
                                        <option value="1" @if ($category->status == 1) selected @endif>Hiện</option>
                                        <option value="0" @if ($category->status == 0) Selected @endif>Ẩn</option>
                                    </select>
                                </div>
                                {!! Form::submit_close(route('backend.productcategory.index')) !!}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
