@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Thành Viên', ['Danh sách', 'Chỉnh sửa']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radisus-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h4 class="mb-0">Thêm thành viên</h4>
                            </div>
                            <hr>
                            <form action="{{ route('backend.user.update', $user->id) }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label for="username" class="form-label fw-bold">Tài khoản đăng nhập</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ $user->username }}" disabled>
                                </div>
                                <div class="col-md-12">
                                    <label for="name" class="form-label fw-bold">Họ tên</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                        disabled>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Vai trò</label>
                                    <select name="role[]" class="multiple-select" data-placeholder="Choose anything"
                                        multiple="multiple">
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}" @foreach ($user->roles as $role)
                                                @if ($item->id == $role->id) selected @endif
                                        @endforeach>
                                        {{ $item->name }}</option>
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
                                        <option value="1" @if ($user->status == 1) selected @endif>Hoạt động</option>
                                        <option value="0" @if ($user->status == 0) Selected @endif>Khóa</option>
                                    </select>
                                </div>
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
