@extends("backend.layouts.app")
@section('style')
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Bài viết', ['Danh sách']) !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center table-responsive p-1">
                            <a href="{{ url()->current() }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i>
                            </a>
                            <form action="{{ route('backend.postlist.index') }}" method="GET">
                                <div class="d-flex">
                                    <input name="search_value" type="text" class="form-control ms-1"
                                        value="{{ old('search_value') }}" placeholder="Tìm theo tiêu đề ..."
                                        style="width: 260px;">
                                    <button type="button" class="btn btn-sm btn-tool" data-bs-toggle="collapse"
                                        href="#collapseExample" role="button" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        <i class="bx bx-plus text-option"></i></button>
                                </div>
                            </form>
                            <div class="ms-auto px-2">
                                {!! Form::btn_link(route('backend.postlist.create'), 'Thêm', 'bx bx-plus') !!}
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="card-body">
                            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Ngày bắt đầu</label>
                                    <input name="start" value="{{ old('start') }}" class="result form-control date"
                                        placeholder="Chọn ngày">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Ngày kết thúc</label>
                                    <input name="end" value="{{ old('end') }}" class="result form-control date"
                                        placeholder="Chọn ngày">
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
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Tác giả</label>
                                    <select name="author" class="single-select">
                                        <option value="">Tất cả</option>
                                        @foreach ($author as $item)
                                            <option value="{{ $item->author_name }}"
                                                {{ old('author') == $item->author_name ? 'selected' : '' }}>
                                                {{ $item->author_name }}</option>
                                        @endforeach
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
                                        <th>Hình ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Đặc biệt</th>
                                        <th>Thứ tự</th>
                                        <th>Tác giả</th>
                                        <th>Ngày Đăng</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody id="load-data">
                                    @foreach ($posts as $item)
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
                                                <img style="height: 83px;" src="{{ asset('images/' . $item->image) }}">
                                            </td>
                                            <td class="text-wrap">{{ $item->title }}</td>
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
                                            <td class="text-center">{{ $item->ordering }}</td>
                                            <td class="text-center">{{ $item->author_name }}</td>
                                            <td class="text-center">
                                                {{ date('d-m-Y', strtotime($item->created_at)) }}
                                            </td>
                                            <td class="text-center">
                                                {!! Form::edit_destroy(route('backend.postlist.edit', $item->id), route('backend.postlist.destroy', $item->id)) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($posts->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {!! Form::row_pagination(route('backend.postlist.index'), 'postlist_row', $posts) !!}
            </div>
        </div>
    </div>

@endsection

@section('script')
    <form id="destroy" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/locale/vi.js') }}"></script>
    <script
        src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}">
    </script>

    <script>
        $(function() {
            $('.date').bootstrapMaterialDatePicker({
                time: false,
                format: 'DD-MM-YYYY',
                lang: moment.locale('vi'),
                cancelText: 'Đóng',
                okText: 'Chọn',
            });
        });
    </script>
@endsection
