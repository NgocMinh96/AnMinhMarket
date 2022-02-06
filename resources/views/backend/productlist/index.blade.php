@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Cửa hàng', ['Sản phẩm']) !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center table-responsive p-1">
                            <a href="{{ route('backend.productlist.index') }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i>
                            </a>
                            <form action="{{ route('backend.productlist.index') }}" method="GET">
                                @csrf
                                <div class="d-flex">
                                    <select name="search_type" class="single-select" style="width: 120px;">
                                        <option value="code" {{ old('search_type') == 'code' ? 'selected' : '' }}>
                                            Mã sản phẩm</option>
                                        <option value="name" {{ old('search_type') == 'name' ? 'selected' : '' }}>Tên sản
                                            phẩm
                                        </option>
                                    </select>
                                    <input name="search_value" type="text" class="form-control ms-1"
                                        value="{{ old('search_value') }}" placeholder="Tìm kiếm ..."
                                        style="width: 260px;">
                                </div>
                            </form>
                            <button type="button" class="btn btn-sm btn-tool" data-bs-toggle="collapse"
                                href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus text-option"></i></button>
                            <div class="ms-auto px-2">
                                {!! Form::btn_link(route('backend.productlist.create'), 'Thêm', 'bx bx-plus') !!}
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="card-body">
                            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Danh mục</label>
                                    <select name="category" class="single-select">
                                        <option value="" {{ old('status') == '' ? 'selected' : '' }}>
                                            Tất cả</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('category') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Trạng thái</label>
                                    <select name="status" class="single-select">
                                        <option value="" {{ old('status') == '' ? 'selected' : '' }}>
                                            Tất cả</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                            Hiện</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                            Ẩn
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Đặc biệt</label>
                                    <select name="special" class="single-select">
                                        <option value="" {{ old('special') == '' ? 'selected' : '' }}>
                                            Tất cả</option>
                                        <option value="1" {{ old('special') == '1' ? 'selected' : '' }}>
                                            Có</option>
                                        <option value="0" {{ old('special') == '0' ? 'selected' : '' }}>
                                            Không
                                        </option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {!! Form::btn_submit('', 'bx bx-search') !!}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card radius-10">
                    <div class="card-body">
                        {{-- <div class="d-flex align-items-center">
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
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        {{-- <th style="width: 10px"></th> --}}
                                        <th>Hình ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th>Giá bán</th>
                                        <th>Giảm giá</th>
                                        <th class="text-center">Thứ tự</th>
                                        <th>Trạng thái</th>
                                        <th>Đặc biệt</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody id="load-data">
                                    @foreach ($products as $item)
                                        <tr>
                                            {{-- <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="checkbox-{{ $item->id }}" name="checkbox[]"
                                                        value="{{ $item->id }}">
                                                    <label for="checkbox-{{ $item->id }}"
                                                        class="custom-control-label"></label>
                                                </div>
                                            </td> --}}
                                            <td>
                                                @if (isset($item->images[0]))
                                                    <a>
                                                        <img style="height: 83px"
                                                            src="{{ asset('images/' . $item->images[0]->image) }}">
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="text-wrap">{{ $item->name }}</td>
                                            <td class="text-center">{{ number_format($item->price) }} đ</td>
                                            <td class="text-center">{{ $item->sale }} %</td>
                                            <td class="text-center">{{ $item->ordering }}</td>
                                            <td class="text-center">
                                                @if ($item->status == 1)
                                                    <div
                                                        class="badge text-success bg-light-success p-1 text-uppercase px-2">
                                                        Hiện
                                                    </div>
                                                @elseif($item->status == 0)
                                                    <div class="badge text-danger bg-light-danger p-1 text-uppercase px-2">
                                                        Ẩn
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->special == 1)
                                                    <div
                                                        class="badge text-success bg-light-success p-1 text-uppercase px-2">
                                                        Có
                                                    </div>
                                                @elseif($item->special == 0)
                                                    <div class="badge text-danger bg-light-danger p-1 text-uppercase px-2">
                                                        Không
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex order-actions justify-content-center">
                                                    <a href="{{ route('backend.productimage.index', $item->id) }}"
                                                        class="bg-light-secondary text-secondary" title="Hình ảnh">
                                                        <i class="bx bx-images" aria-hidden="true"></i>
                                                    </a>
                                                    {!! Form::edit_destroy(route('backend.productlist.edit', $item->id), route('backend.productlist.destroy', $item->id)) !!}
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            @if ($products->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {!! Form::row_pagination(route('backend.productlist.index'), 'productlist_row', $products) !!}
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
