@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Thành Viên', ['Chức năng']) !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center table-responsive">
                            <form action="{{ route('backend.permission.index') }}" method="GET">
                                @csrf
                                <div class="input-group">
                                    <select name="search_type" class="form-control" style="width: 110px;">
                                        <option value="username">Chức năng</option>
                                    </select>
                                    <input name="search_value" type="text" class="form-control"
                                        value="{{ old('search_value') }}" placeholder="Tìm kiếm ..."
                                        style="width: 260px; border-left-width: 0px;">
                                </div>
                            </form>
                            <a href="{{ route('backend.permission.index') }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i></a>
                            <div class="ms-auto px-2">
                                <a href="{{ route('backend.permission.create') }}" class="btn btn-sm btn-primary"><i
                                        class="bx bx-plus"></i>Thêm</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="dropdown ms-start">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"
                                    aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                </a>
                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li><a class="dropdown-item" href="javascript:;">Hoạt động</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Không hoạt động</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Xóa</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Chức năng</th>
                                        <th>Mô tả</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $value)
                                        <tr>
                                            <td><span class="badge bg-primary">{{ $value->name }}</span></td>
                                            <td>{{ $value->description }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('backend.permission.edit', $value->id) }}"
                                                    class="rounded-circle btn btn-sm btn-custom-warning" title="Edit">
                                                    <i class="bx bx-edit-alt" aria-hidden="true"></i>
                                                </a>
                                                <button
                                                    onclick="destroy('{{ route('backend.permission.destroy', $value->id) }}')"
                                                    class="rounded-circle btn btn-sm btn-custom-danger">
                                                    <i class="bx bx-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            @if ($data->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <form action="{{ route('backend.permission.index') }}" method="GET">
                        @csrf
                        <select name="select_row" class="form-select form-select-sm" style="width: 5%; min-width: 80px"
                            onchange="event.preventDefault(); this.closest('form').submit();">
                            <option value="1" @if (session('permission_row') == 1) selected @endif>1</option>
                            <option value="3" @if (session('permission_row') == 3) selected @endif>3</option>
                            <option value="5" @if (session('permission_row') == 5) selected @endif>5</option>
                        </select>
                    </form>
                    <div class="ms-auto">
                        {{ $data->onEachSide(1)->withQueryString()->links() }}
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
