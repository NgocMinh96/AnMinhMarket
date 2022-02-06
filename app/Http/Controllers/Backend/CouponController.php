<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::all();
        return view('backend.coupon.index', compact('coupons'));
    }

    public function create(Request $request)
    {
        return view('backend.coupon.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $errorMsgs = [
            'name.required'             => 'Bạn chưa nhập tên mã',
            'name.max'                  => 'Tên mã không quá 50 ký tự',
            'coupon.required'           => 'Bạn chưa nhập mã',
            'coupon.max'                => 'Mã không được quá 10 ký tự',
            'amount.required'            => 'Bạn chưa nhập giá trị mã',
            'amount.numeric'             => 'Giá trị mã là số tiền giảm',
            'condition.required'        => 'Bạn chưa nhập điều kiện',
            'condition.numeric'         => 'Điều kiện là số tiền tối thiểu đơn hàng sẽ được áp dụng',
            'start_at.required'         => 'Bạn chưa chọn ngày bắt đầu',
            'end_at.required'           => 'Bạn chưa chọn ngày kết thúc',
            'end_at.after_or_equal'     => 'Ngày kết thúc không được nhỏ hơn ngày bắt đầu'
        ];

        $rule = [
            'name'              => 'required|max:50',
            'coupon'            => 'required|max:20',
            'amount'            => 'required|numeric',
            'condition'         => 'required|numeric',
            'start_at'          => 'required',
            'end_at'            => 'required|after_or_equal:start_at'
        ];

        $validator = Validator::make($request->all(), $rule, $errorMsgs);

        if ($validator->passes()) {
            $data = [
                'name'          => $request->name,
                'coupon'        => $request->coupon,
                'amount'         => $request->amount,
                'condition'     => $request->condition,
                'start_at'      => date('Y-m-d H:i:s', strtotime($request->start_at)),
                'end_at'        => date('Y-m-d 23:59:59', strtotime($request->end_at)),
            ];
            Coupon::create($data);

            return redirect()->route('backend.coupon.index')->with('success', 'Thêm mới thành công');
        } else {
            return back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        return view('backend.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errorMsgs = [
            'name.required'             => 'Bạn chưa nhập tên mã',
            'name.max'                  => 'Tên mã không quá 50 ký tự',
            'coupon.required'           => 'Bạn chưa nhập mã',
            'coupon.max'                => 'Mã không được quá 10 ký tự',
            'amount.required'            => 'Bạn chưa nhập giá trị mã',
            'amount.numeric'             => 'Giá trị mã là số tiền giảm',
            'condition.required'        => 'Bạn chưa nhập điều kiện',
            'condition.numeric'         => 'Điều kiện là số tiền tối thiểu đơn hàng sẽ được áp dụng',
            'start_at.required'         => 'Bạn chưa chọn ngày bắt đầu',
            'end_at.required'           => 'Bạn chưa chọn ngày kết thúc',
            'end_at.after_or_equal'     => 'Ngày kết thúc không được nhỏ hơn ngày bắt đầu'
        ];

        $rule = [
            'name'              => 'required|max:50',
            'coupon'            => 'required|max:20',
            'amount'            => 'required|numeric',
            'condition'         => 'required|numeric',
            'start_at'          => 'required',
            'end_at'            => 'required|after_or_equal:start_at'
        ];

        $validator = Validator::make($request->all(), $rule, $errorMsgs);

        if ($validator->passes()) {
            $data = [
                'name'          => $request->name,
                'coupon'        => $request->coupon,
                'condition'     => $request->condition,
                'start_at'      => date('Y-m-d 00:00:00', strtotime($request->start_at)),
                'end_at'        => date('Y-m-d 23:59:59', strtotime($request->end_at)),
            ];
            Coupon::where('id', $id)->update($data);

            return redirect()->route('backend.coupon.index')->with('success', 'Sửa thành công');
        } else {
            return back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Coupon::destroy($id);
        return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
    }
}
