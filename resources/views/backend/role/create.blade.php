@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Thành Viên', ['Vai trò', 'Thêm vai trò']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Thêm vai trò</h5>
                            </div>
                            <hr>
                            <form action="{{ route('backend.role.store') }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tên vai trò</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('name') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Quyền</label>
                                    <select name="permission[]" class="multiple-select" data-placeholder="Choose anything"
                                        multiple="multiple">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}
                                                ({{ $permission->description }})</option>
                                        @endforeach
                                    </select>
                                    @error('permission')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('permission') }}
                                        </span>
                                    @enderror
                                </div>
                                {!! Form::submit_close(route('backend.role.index')) !!}
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
