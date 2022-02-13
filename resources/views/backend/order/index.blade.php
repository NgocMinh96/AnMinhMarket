@extends("backend.layouts.app")
@section('style')
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>


    </style>
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Đơn hàng') !!}
            <div class="col-lg-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center table-responsive p-1">
                            <a href="{{ route('backend.order.index') }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i>
                            </a>
                            <form action="{{ route('backend.order.index') }}" method="GET" class="d-flex w-100">
                                <select name="search_type" class="single-select" style="width: 120px;">
                                    <option value="order_id" {{ old('search_type') == 'order_id' ? 'selected' : '' }}>
                                        Mã đơn</option>
                                    <option value="phone" {{ old('search_type') == 'phone' ? 'selected' : '' }}>Điện
                                        thoại
                                    </option>
                                </select>
                                <input name="search_value" type="text" class="form-control ms-1"
                                    value="{{ old('search_value') }}" placeholder="Tìm kiếm ..." style="width: 260px;">
                                <button type="button" class="btn btn-sm btn-tool" data-bs-toggle="collapse"
                                    href="#collapseExample" role="button" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <i class="bx bx-plus text-option"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="card-body">
                            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Từ ngày</label>
                                    <input name="start" value="{{ old('start') }}" class="result form-control date"
                                        placeholder="Chọn ngày">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Đến ngày</label>
                                    <input name="end" value="{{ old('end') }}" class="result form-control date"
                                        placeholder="Chọn ngày">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Trạng thái thanh toán</label>
                                    <select name="payment_status" class="single-select">
                                        <option value="" {{ old('payment_status') == '' ? 'selected' : '' }}>
                                            Tất cả</option>
                                        <option value="0" {{ old('payment_status') == '0' ? 'selected' : '' }}>
                                            Chưa thanh toán</option>
                                        <option value="1" {{ old('payment_status') == '1' ? 'selected' : '' }}>
                                            Đã thanh toán
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Trạng thái đơn hàng</label>
                                    <select name="order_status" class="single-select">
                                        <option value="" {{ old('order_status') == '' ? 'selected' : '' }}>
                                            Tất cả</option>
                                        <option value="0" {{ old('order_status') == '0' ? 'selected' : '' }}>
                                            Đang xử lý</option>
                                        <option value="1" {{ old('order_status') == '1' ? 'selected' : '' }}>
                                            Hoàn thành
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
                        <div class="d-flex align-items-center mb-2">
                            <span class="fw-bold fs-6 me-2">Tác vụ</span>
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" href="#"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Thanh toán
                                </a>
                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li><a class="dropdown-item" onclick="bulkAction('payment_status', 1)">Đã thanh
                                            toán</a>
                                    </li>
                                    <li><a class="dropdown-item" onclick="bulkAction('payment_status', 0)">Chưa thanh
                                            toán</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" href="#"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Đơn hàng
                                </a>
                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li><a class="dropdown-item" onclick="bulkAction('order_status', 1)">Hoàn thành</a>
                                    </li>
                                    <li><a class="dropdown-item" onclick="bulkAction('order_status', 0)">Đang xử lý</a>
                                    </li>
                                </ul>
                            </div>
                            <button class="btn btn-sm" onclick="bulkAction('destroy')">Xóa</button>
                        </div>
                        <div class="table-responsive scroll-touch">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="align-middle">
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="check-all"
                                                    name="checkbox[]" value="">
                                                <label for="check-all" class="form-check-label"></label>
                                            </div>
                                        </th>
                                        <th class="text-center">Mã đơn hàng</th>
                                        <th class="">Thông tin khách hàng</th>
                                        <th class="text-center">Sản phẩm</th>
                                        <th class="text-center">Giảm giá</th>
                                        <th class="text-center">Tổng tiền</th>
                                        <th class="text-center text-wrap">Phương thức thanh toán</th>
                                        <th class="text-center text-wrap">Trạng thái thanh toán</th>
                                        <th class="text-center text-wrap">Trạng thái đơn hàng</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $item)
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
                                                <p class="">#{{ $item->order_id }}</p>
                                                <p class="text-center mb-0">
                                                    {{ date('d-m-Y', strtotime($item->created_at)) }}</p>
                                                <p class="text-center">
                                                    {{ date('H:i:s', strtotime($item->created_at)) }}</p>
                                            </td>
                                            <td class="text-wrap">
                                                <ul>
                                                    <li>Họ, tên: <span>{{ $item->name }}</span></li>
                                                    <li>Điện thoại: <span>{{ $item->phone }}</span></li>
                                                    <li>Địa chỉ: <span>{{ $item->address }}</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($item->products as $product)
                                                        <li>
                                                            <span class="fw-bold">
                                                                {{ $product->name }}
                                                            </span>
                                                            <p class="mb-0">
                                                                {{ number_format($product->price) }} x
                                                                {{ $product->quantity }} =
                                                                {{ number_format($product->price * $product->quantity) }}
                                                            </p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-center">{{ number_format($item->discount) }}</td>
                                            <td class="text-center">{{ number_format($item->payment_price) }} đ</td>
                                            <td>
                                                @if ($item->payment_method == 1)
                                                    <p class="text-wrap">Tiền mặt khi nhận hàng</p>
                                                @endif
                                            </td>
                                            <td>
                                                <select name="payment_status" class="single-select"
                                                    onchange="changePaymentStatus({{ $item->id }},this);">
                                                    <option value="0" {{ $item->payment_status == 0 ? 'selected' : '' }}>
                                                        Chưa
                                                        thanh toán</option>
                                                    <option value="1" {{ $item->payment_status == 1 ? 'selected' : '' }}>
                                                        Đã
                                                        thanh toán</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="order_status-{{ $item->id }}" class="single-select"
                                                    onchange="changeOrderStatus({{ $item->id }},this);">
                                                    <option value="0" {{ $item->order_status == 0 ? 'selected' : '' }}>
                                                        Đang
                                                        xử lý</option>
                                                    <option value="1" {{ $item->order_status == 1 ? 'selected' : '' }}>
                                                        Hoàn
                                                        thành</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex order-actions justify-content-center align-items-center">
                                                    <a href="{{ route('backend.order.show', $item->id) }}"
                                                        class="text-secondary">
                                                        <i class="bx bxs-show" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="#"
                                                        onclick="destroy('{{ route('backend.order.destroy', $item->id) }}')"
                                                        class="text-danger">
                                                        <i class="bx bxs-trash" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($orders->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {!! Form::row_pagination(route('backend.order.index'), 'order_row', $orders) !!}
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

    <script>
        function ajaxToken() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function changePaymentStatus(id, status) {
            ajaxToken()
            $.ajax({
                url: "{{ route('backend.order.changePaymentStatus') }}",
                type: 'PUT',
                data: {
                    id: id,
                    status: status.value
                },
                success: function(data) {
                    round_noti('info', 'Đã cập nhật trạng thái thanh toán')
                },
                error: function(xhr, status, error) {
                    round_noti('warning', 'Bạn chưa được cấp quyền thực hiện')
                },
            })
        }

        function changeOrderStatus(id, status) {
            ajaxToken()
            $.ajax({
                url: "{{ route('backend.order.changeOrderStatus') }}",
                type: 'PUT',
                data: {
                    id: id,
                    status: status.value
                },
                success: function(data) {
                    round_noti('info', 'Đã cập nhật trạng thái đơn hàng')
                },
                error: function(xhr, status, error) {
                    round_noti('warning', 'Bạn chưa được cấp quyền thực hiện')
                },
            })
        }

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
                    case 'payment_status':
                        question = 'Bạn có đồng thay đổi trạng thái thanh toán?'
                        break;
                    case 'order_status':
                        question = 'Bạn có đồng ý thay đổi trạng thái đơn hàng?'
                        break;
                }

                return setSwal(question).then((result) => {
                    if (result.isConfirmed) {
                        ajaxToken()
                        $.ajax({
                            url: "{{ route('backend.order.bulkAction') }}",
                            type: 'PATCH',
                            data: {
                                option: option,
                                ids: ids,
                                status: status
                            },
                            success: function(data) {
                                window.location = "{{ route('backend.order.index') }}"
                            },
                            error: function(xhr, status, error) {
                                window.location = "{{ route('backend.order.index') }}"
                            },
                        })
                    }
                })
            }
        }
    </script>
@endsection
