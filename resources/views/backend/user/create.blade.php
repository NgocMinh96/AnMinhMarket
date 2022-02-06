@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Thành Viên', ['Danh sách', 'Thêm thành viên']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Thêm thành viên</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.user.store') }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tài khoản đăng nhập</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ old('username') }}">
                                    @error('username')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('username') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Họ tên</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('name') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Mật khẩu</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('password') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Vai trò</label>
                                    <select name="role[]" class="multiple-select" data-placeholder="Choose anything"
                                        multiple="multiple">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('role') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">Trạng thái</label>
                                    <select name="status" class="single-select">
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Khóa</option>
                                    </select>
                                </div>
                                {{-- <div class="d-flex justify-content-center">
                                    {!! Form::btn_submit('Lưu', '', 'px-4') !!}
                                    {!! Form::btn_close(route('backend.user.index'), 'Đóng', '', 'px-4') !!}
                                </div> --}}
                                {!! Form::submit_close(route('backend.user.index')) !!}
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
