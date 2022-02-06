@extends("backend.layouts.app")
@section('style')

@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            {!! Form::breadcrumb('Hình ảnh', ['' . $data->name]) !!}
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body">
                        <h5>Thêm hình</h5>
                        <hr>
                        <form action="{{ route('backend.productimage.store', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex table-responsive">
                                <div class="">
                                    <input name="image[]" type="file" class="form-control" multiple>
                                </div>
                                <div class="ms-3">
                                    {!! Form::btn_submit('', 'bx bx-save') !!}
                                </div>
                            </div>
                            @error('image')
                                <span class="invalid-feedback is-invalid d-block mt-2"
                                    role="alert">{{ $errors->first('image') }}
                                </span>
                            @enderror
                        </form>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-4">
                    @foreach ($data->images as $item)
                        <div class="col">
                            <div class="card radius-10">
                                <div class="text-center p-2">
                                    <img src="{{ asset('images/' . $item->image) }}" width="100%" >
                                </div>
                                <div class="card-body pt-2">
                                    {{-- <hr> --}}
                                    <form action="{{ route('backend.productimage.update', [$item->id, $data->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label pe-0">Vị trí</label>
                                            <div class="col-sm-8">
                                                <input name="ordering" type="text" class="form-control form-control-sm"
                                                    value='{{ $item->ordering }}'>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label  pe-0">Đổi hình</label>
                                            <div class="col-sm-8">
                                                <input name="image" type="file" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {!! Form::btn_submit('', 'bx bx-save', '') !!}
                                            <button type="button"
                                                onclick="destroy('{{ route('backend.productimage.destroy', [$item->id, $data->id]) }}')"
                                                class="btn btn-sm btn-danger ms-2"><i class="bx bx-trash"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
