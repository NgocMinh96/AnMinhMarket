@extends("backend.layouts.app")
@section('style')
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Quản lý mã giảm giá', ['Thêm mã giảm giá']) !!}
            <div clas="row">
                <div class="col-xl-7 mx-auto">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="card-title d-flex align-items-center">
                                <h4 class="mb-0m">Thêm mã giảm giá</h4>
                            </div>
                            <hr>
                            <form action="{{ route('backend.coupon.store') }}" method="POST"
                                class="row justify-content-center g-3">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tên mã giảm</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('name') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Mã giảm giá</label>
                                    <input name="coupon" type="text" class="form-control">
                                    @error('coupon')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('coupon') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Giá trị mã (số tiền giảm)</label>
                                    <input name="amount" type="number" class="form-control">
                                    @error('amount')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('amount') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Điều kiện đơn hàng đủ</label>
                                    <input name="condition" type="number" class="form-control">
                                    @error('condition')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('condition') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ngày bắt đầu</label>
                                    <input name="start_at" value="{{ old('start_at') }}" class="result form-control date"
                                        placeholder="Chọn ngày">
                                    @error('start_at')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('start_at') }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ngày kết thúc</label>
                                    <input name="end_at" value="{{ old('end_at') }}" class="result form-control date"
                                        placeholder="Chọn ngày">
                                    @error('end_at')
                                        <span class="invalid-feedback is-invalid d-block mt-2"
                                            role="alert">{{ $errors->first('end_at') }}
                                        </span>
                                    @enderror
                                </div>

                                {!! Form::submit_close(route('backend.coupon.index')) !!}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
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
