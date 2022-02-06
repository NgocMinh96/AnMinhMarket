@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Thành Viên', ['Vai trò']) !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center table-responsive p-1">
                            <a href="{{ route('backend.role.index') }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i>
                            </a>
                            <form action="{{ route('backend.role.index') }}" method="GET">
                                <div class="d-flex">
                                    <input name="search_value" type="text" class="form-control ms-1"
                                        value="{{ old('search_value') }}" placeholder="Tìm kiếm ..." style="width: 260px">
                                </div>
                            </form>
                            <div class="ms-auto px-2">
                                {!! Form::btn_link(route('backend.role.create'), 'Thêm', 'bx bx-plus') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card radius-10">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Vai trò</th>
                                        <th>Quyền</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-wrap">
                                                @foreach ($item->permissions as $permission)
                                                    <span
                                                        class="badge text-primary bg-light-primary p-1 text-uppercase px-2">
                                                        {{ $permission->description }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                {!! Form::edit_destroy(route('backend.role.edit', $item->id), route('backend.role.destroy', $item->id)) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($roles->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {!! Form::row_pagination(route('backend.role.index'), 'role_row', $roles) !!}
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
