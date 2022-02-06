@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Thành Viên', ['Danh sách']) !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center table-responsive p-1">
                            {{-- <button type="button" class="btn btn-sm btn-tool" data-bs-toggle="collapse"
                                href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus text-option"></i></button> --}}
                            <a href="{{ route('backend.user.index') }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i>
                            </a>
                            <form action="{{ route('backend.user.index') }}" method="GET">
                                <div class="d-flex">
                                    <select name="search_type" class="single-select" style="width: 120px;">
                                        <option value="username" {{ old('search_type') == 'username' ? 'selected' : '' }}>
                                            Tài khoản</option>
                                        <option value="name" {{ old('search_type') == 'name' ? 'selected' : '' }}>Tên
                                        </option>
                                    </select>
                                    <input name="search_value" type="text" class="form-control ms-1"
                                        value="{{ old('search_value') }}" placeholder="Tìm kiếm ..."
                                        style="width: 260px;">

                                </div>
                            </form>
                            <div class="ms-auto px-2">
                                {!! Form::btn_link(route('backend.user.create'), 'Thêm', 'bx bx-plus') !!}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="collapse" id="collapseExample">
                        <div class="card-body">
                            <div class="row align-items-center table-responsive">

                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="card radius-10">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 10px"></th>
                                        <th>Tài khoản</th>
                                        <th>Họ tên</th>
                                        <th class="text-center">Vai Trò</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody id="load-data">
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>
                                                <img class="rounded-pill"
                                                    src="{{ $item->image != '' ? asset('images/' . $item->image) : asset('images/avatar.png') }}"
                                                    height="35px">
                                            </td>
                                            <td>
                                                {{ $item->username }}
                                            </td>
                                            <td>

                                                {{ $item->name }}
                                            </td>
                                            <td class="text-center text-wrap">
                                                @foreach ($item->roles as $role)
                                                    <span
                                                        class="badge text-primary bg-light-primary p-1 text-uppercase px-2">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                @if ($item->status == 1)
                                                    <div
                                                        class="badge text-success bg-light-success p-1 text-uppercase px-2">
                                                        <i class="bx bxs-circle me-1"></i>
                                                        Hoạt động
                                                    </div>
                                                @elseif($item->status == 0)
                                                    <div class="badge text-danger bg-light-danger p-1 text-uppercase px-2">
                                                        <i class="bx bxs-circle me-1"></i>
                                                        Bị khóa
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {!! Form::edit_destroy(route('backend.user.edit', $item->id), route('backend.user.destroy', $item->id)) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($users->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- <div class="d-flex align-items-center table-responsive">
                    Xem
                    <form action="{{ route('backend.user.index') }}" method="GET" class="px-2">
                        <select name="select_row" class="single-select" style="width: 50px"
                            onchange="event.preventDefault(); this.closest('form').submit();">
                            <option value="10" @if (session('user_row') == 10) selected @endif>10</option>
                            <option value="30" @if (session('user_row') == 30) selected @endif>30</option>
                            <option value="50" @if (session('user_row') == 50) selected @endif>50</option>
                        </select>
                    </form>
                    Dòng
                    <div class="ms-auto ps-2">
                        {{ $users->onEachSide(1)->withQueryString()->links() }}
                    </div>
                </div> --}}
                {!! Form::row_pagination(route('backend.user.index'), 'user_row', $users) !!}
            </div>
        </div>

    @endsection

    @section('script')
        <form id="destroy" method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endsection
