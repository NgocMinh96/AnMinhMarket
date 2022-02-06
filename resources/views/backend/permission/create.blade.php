@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Thành Viên', ['Chức năng', 'Thêm chức năng']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0 text-primary">Thêm chức năng</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.permission.store') }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label">Tên chức năng</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('name') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mô tả</label>
                                    <input type="text" name="description" class="form-control" value="{{ old('name') }}">
                                    @error('description')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('description') }}
                                        </span>
                                    @enderror
                                </div>
                    
                                <div class="col-md-auto">
                                    <button type="submit" class="btn btn-primary px-5">Lưu</button>
                                    <a href="{{ route('backend.permission.index') }}" class="btn btn-danger px-5">Đóng</a>
                                </div>
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
