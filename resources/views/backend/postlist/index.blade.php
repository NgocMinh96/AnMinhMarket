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
                        <div class="d-flex align-items-center mb-2">
                            <span class="fw-bold fs-6 me-2">Tác vụ</span>
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" href="#"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Trạng thái
                                </a>
                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li><a class="dropdown-item" onclick="bulkAction('status', 1)">Hiện</a>
                                    </li>
                                    <li><a class="dropdown-item" onclick="bulkAction('status', 0)">Ẩn</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" href="#"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Nổi bật
                                </a>
                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li><a class="dropdown-item" onclick="bulkAction('special', 1)">Có</a>
                                    </li>
                                    <li><a class="dropdown-item" onclick="bulkAction('special', 0)">Không</a>
                                    </li>
                                </ul>
                            </div>
                            <button class="btn btn-sm" onclick="bulkAction('destroy')">Xóa</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="check-all"
                                                    name="checkbox[]" value="">
                                                <label for="check-all" class="form-check-label"></label>
                                            </div>
                                        </th>
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
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="checkbox-{{ $item->id }}" name="checkbox[]"
                                                        value="{{ $item->id }}">
                                                    <label for="checkbox-{{ $item->id }}"
                                                        class="form-check-label"></label>
                                                </div>
                                            </td>
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

        const bulkAction = (option, status = null) => {
            var ids = [];
            $.each($('input[name="checkbox[]"]:checked'), function() {
                ids.push($(this).val());
            })
            var url = ''
            if (ids.length <= 0) {
                round_noti('warning', 'Vui lòng chọn dữ liệu trước khi thực hiện')
            } else {
                switch (option) {
                    case 'destroy':
                        question = 'Bạn có đồng ý xóa các dữ liệu đã chọn?'
                        break;
                    case 'status':
                        question = 'Bạn có đồng thay đổi trạng thái bài viết?'
                        break;
                    case 'special':
                        question = 'Bạn có đồng ý thay đổi nổi bật bài viết?'
                        break;
                }

                return setSwal(question).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('backend.postlist.bulkAction') }}",
                            type: 'PATCH',
                            data: {
                                option: option,
                                ids: ids,
                                status: status
                            },
                            success: function(data) {
                                console.log(data)
                                window.location = "{{ route('backend.postlist.index') }}"
                            },
                            error: function(xhr, status, error) {
                                window.location = "{{ route('backend.postlist.index') }}"
                            },
                        })
                    }
                })
            }
        }
    </script>
@endsection
