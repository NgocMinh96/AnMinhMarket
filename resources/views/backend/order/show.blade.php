@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Xem đơn hàng') !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm btn-secondary" onclick="print('{{ $order->order_id }}')">In hóa
                                đơn</button>
                        </div>
                        <div id="invoice">
                            <div>
                                <img style="width: 240px" src="{{ asset('images/logo.png') }}" alt="">
                            </div>
                            <div class="row justify-content-center">
                                <div class="fw-bold fs-4 text-center">HÓA ĐƠN BÁN HÀNG</div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="text-center">
                                    {{ 'Ngày ' . date('d', strtotime($order->created_at)) . ' tháng ' . date('m', strtotime($order->created_at)) . ' năm ' . date('Y', strtotime($order->created_at)) }}
                                </div>
                            </div>
                            <div class="my-2">
                                <p class="mb-0">Đơn vị bán hàng: <span class="text-custom fw-bold">CÔNG TY TNHH
                                        MTV
                                        THƯƠNG MẠI AN MINH</span></p>
                                <p class="mb-0">Mã số thuế: <span>1234567899</span></p>
                                <p class="mb-0">Địa chỉ: <span>175/12 đường số 4, Phường 16, Quận Gò Vấp</span>
                                </p>
                                <p class="mb-0">Số điện thoại: <span>0936454609</span></p>
                            </div>
                            <div>
                                <p class="mb-0">Người mua hàng: <span
                                        class="fw-bold">{{ $order->name }}</span></p>
                                <p class="mb-0">Địa chỉ: <span>{{ $order->address }}</span>
                                </p>
                                <p class="mb-0">Số điện thoại: <span>{{ $order->phone }}</span></p>
                            </div>
                            <table class="table align-middle table-bordered mt-2">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="text-center" style="width: 5%">STT</th>
                                        <th class="text-center" style="width: 50%">Tên sản phẩm</th>
                                        <th class="text-center" style="width: 15%">Số lượng</th>
                                        <th class="text-center" style="width: 15%">Đơn giá</th>
                                        <th class="text-center" style="width: 25%">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($total_item = 0)
                                    @foreach ($order->products as $key => $item)
                                        <tr>
                                            <td class="text-center">
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($item->price) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($item->price * $item->quantity) }}
                                            </td>
                                        </tr>
                                        {{ $total_item += $item->quantity }}
                                    @endforeach
                                    <tr>
                                        <td class="fw-bold" colspan="4">Giảm giá</td>
                                        <td class="text-end">{{ number_format($order->discount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" colspan="2">Tổng cộng</td>
                                        <td class="text-center">
                                            {{ number_format($total_item) }}
                                        </td>
                                        <td></td>
                                        <td class="text-end">
                                            {{ number_format($order->payment_price) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <span id="tienchu" class="fw-bold"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <p class="text-center mb-0">Người mua hàng</p>
                                    <p class="text-center fst-italic fw-light">(Ký, ghi họ tên)</p>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <p class="text-center mb-0">
                                        Người bán hàng
                                    </p>
                                    <p class="text-center fst-italic fw-light">(Ký, ghi họ tên)</p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function print(order_id) {
            var element = document.getElementById('invoice');
            var opt = {
                margin: 0.5,
                filename: order_id + '.pdf',
                html2canvas: {
                    scale: 2,
                    dpi: 192,
                },
                jsPDF: {
                    unit: 'cm',
                    format: 'a4',
                    orientation: 'portrait',
                }
            };
            html2pdf().set(opt).from(element).save();
        }

        $('#tienchu').html('Tiền viết bằng chữ : ' + chuyenso('{{ $order->payment_price }}'))
    </script>
@endsection
