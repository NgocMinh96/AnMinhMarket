@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Thông tin cá nhân', ['']) !!}

            <div class="contaier">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{ Auth::user()->image == '' ? asset('images/avatar.png') : asset('images/' . Auth::user()->image) }}"
                                            class="rounded-circle p-1 bg-secondary" width="110">
                                        <div class="mt-3">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-secondary mb-1">{{ Auth::user()->roles[0]->name }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('backend.userinfo.update', ['info']) }}" class="row g-2"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Họn tên</label>
                                            <input name="name" type="text" class="form-control"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Ảnh đại diện</label>
                                            <input name="image" type="file" class="form-control">
                                            @error('image')
                                                <span class="invalid-feedback is-invalid d-block mt-2"
                                                    role="alert">{{ $errors->first('image') }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            {!! Form::btn_submit('', 'bx bx-save') !!}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <form action="{{ route('backend.userinfo.update', ['password']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label class="form-label fw-bold">Đổi mật khẩu</label>
                                        <div class="row mb-3">
                                            <div class="ctext-secondary">
                                                <input name="password" type="password" class="form-control"
                                                    placeholder="Mật khẩu mới">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="text-secondary">
                                                <input name="password_confirmation" type="password" class="form-control"
                                                    placeholder="Nhập lại mật khẩu">
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback is-invalid d-block mt-2"
                                                    role="alert">{{ $errors->first('password') }}
                                                </span>
                                            @enderror
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
    <form id="destroy" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection
