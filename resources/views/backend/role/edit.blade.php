@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">

            {!! Form::breadcrumb('Thành Viên', ['Vai trò', 'Sửa vai trò']) !!}

            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h4 class="mb-0">Sửa vai trò</h4>
                            </div>
                            <hr>
                            <form action="{{ route('backend.role.update', $role->id) }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tên vai trò</label>
                                    <input type="text" name="name" class="form-control" value="{{ $role->name }}">
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
                                        @foreach ($permissions as $item)
                                            <option value="{{ $item->id }}" @foreach ($role->permissions as $permission)
                                                @if ($item->id == $permission->id) selected @endif
                                        @endforeach>
                                        {{ $item->name }} {{ $item->description }}</option>
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
