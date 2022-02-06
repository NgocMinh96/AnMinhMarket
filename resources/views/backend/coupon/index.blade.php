@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Quản lý mã giảm giá') !!}

            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center table-responsive p-1">
                            {{-- <button type="button" class="btn btn-sm btn-tool" data-bs-toggle="collapse"
                                href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus text-option"></i></button> --}}
                            <a href="{{ route('backend.coupon.index') }}" class="btn btn-tool">
                                <i class="lni lni-spinner-arrow bx-spin-hover text-option"></i>
                            </a>
                            {{-- <form action="{{ route('backend.coupon.index') }}" method="GET">
                                <div class="d-flex">
                                    <input name="search_value" type="text" class="form-control ms-1"
                                        value="{{ old('search_value') }}" placeholder="Tìm kiếm ..."
                                        style="width: 260px;">
                                </div> --}}
                            </form>
                            <div class="ms-auto px-2">
                                {!! Form::btn_link(route('backend.coupon.create'), 'Thêm', 'bx bx-plus') !!}
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
                                        <th>Tên mã giảm</th>
                                        <th class="text-center">Mã</th>
                                        <th class="text-center">Giá trị giảm</th>
                                        <th class="text-center">Điều kiện đủ</th>
                                        <th class="text-center">Thời gian kích hoạt</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody id="load-data">
                                    @foreach ($coupons as $item)
                                        <tr>
                                            <td class="text-wrap">{{ $item->name }}</td>
                                            <td class="text-center">{{ $item->coupon }}</td>
                                            <td class="text-center">{{ number_format($item->amount) }} đ</td>
                                            <td class="text-center">{{ number_format($item->condition) }} đ</td>
                                            <td class="text-center">
                                                {{ date('d-m-Y', strtotime($item->start_at)) }}
                                                đến
                                                {{ date('d-m-Y', strtotime($item->end_at)) }}
                                            </td>
                                            <td class="text-center">
                                                {!! Form::edit_destroy(route('backend.coupon.edit', $item->id), route('backend.coupon.destroy', $item->id)) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($coupons->isEmpty())
                                <div class="text-center mt-4">
                                    <h3> Không có dữ liệu</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- {!! Form::row_pagination(route('backend.coupon.index'), 'coupon_row', $coupons) !!} --}}

            </div>
        </div>

    @endsection

    @section('script')
        <form id="destroy" method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endsection
