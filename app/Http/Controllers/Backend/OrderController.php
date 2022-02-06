<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use Illuminate\Support\Facades\Validator;
use App\Models\Province;
use App\Models\District;
use App\Models\OrderList;
use App\Models\OrderProduct;
use App\Models\Ward;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (session('order_row') == null) $request->session()->put('order_row', env('PAGINATION'));
        if (isset($request->select_row)) $request->session()->put('order_row', $request->select_row);
        $query = OrderList::orderBy('id', 'DESC');
        if (isset($request->search_value)) $query->where("$request->search_type", 'like', "%$request->search_value%");
        if ($request->start != '' && $request->end != '') {
            $start = date('Y-m-d H:i:s', strtotime($request->start));
            $end   = date('Y-m-d 23:59:59', strtotime($request->end));
            $query->whereBetween('created_at', [$start, $end]);
        }
        if ($request->payment_status != '') $query->where('payment_status', $request->payment_status);
        if ($request->order_status != '') $query->where('order_status', $request->order_status);
        $orders = $query->paginate(session('order_row'));
        session()->flashInput($request->input());

        return view('backend.order.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = OrderList::find($id);
        return view('backend.order.show', compact('order'));
    }

    public function store(Request $request)
    {
        $errorMsgs = [
            'name.required'             => 'Thông tin bắt buộc',
            'name.max'                  => 'Họ và tên không quá 30 ký tự',
            'phone.required'            => 'Thông tin bắt buộc',
            'phone.numeric'             => 'Số điện thoại không hợp lệ',
            'phone.digits'              => 'Số điện thoại không hợp lệ',
            'province.required'         => 'Thông tin bắt buộc',
            'district.required'         => 'Thông tin bắt buộc',
            'ward.required'             => 'Thông tin bắt buộc',
            'address.required'          => 'Thông tin bắt buộc',
            'payment_method.required'   => 'Vui lòng chọn phương thức thanh toán',
        ];

        $rule = [
            'name'              => 'required|max:30',
            'phone'             => 'required|numeric|digits:10',
            'province'          => 'required',
            'district'          => 'required',
            'ward'              => 'required',
            'address'           => 'required',
            'payment_method'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rule, $errorMsgs);

        if ($request->province != null) {
            $province = Province::where('id', $request->province)->first();
            $district = $province->districts;
            Session::put('district', $district);
        }
        if ($request->district != null) {
            $district = District::where('id', $request->district)->first();
            $ward     = $district->wards;
            Session::put('ward', $ward);
        }

        if ($validator->passes()) {
            $ward = Ward::select('name')->where('id', $request->ward)->first();
            $fullAddress = $request->address . ', ' . $ward->name . ', ' . $district->name . ', ' . $province->name;

            $paymentPrice = session()->has('lastPrice') ? session()->get('lastPrice') : session()->get('totalPrice');
            $discount = session()->has('discount') ? session()->get('discount') : 0;
            $orderID = Str::random(2) . time();

            $order = [
                'order_id'          => $orderID,
                'name'              => $request->name,
                'phone'             => $request->phone,
                'address'           => $fullAddress,
                'discount'          => $discount,
                'payment_price'     => $paymentPrice,
                'payment_method'    => $request->payment_method,
                'payment_status'    => 0,
                'order_status'      => 0
            ];

            $orderList = OrderList::create($order);

            foreach (session()->get('cart') as $item) {
                OrderProduct::create([
                    'order_list_id' => $orderList->id,
                    'product_id'    => $item['id'],
                    'name'          => $item['name'],
                    'price'         => $item['price'],
                    'quantity'      => $item['quantity']
                ]);
            }

            Session::forget('cart');
            Session::forget('lastPrice');
            Session::forget('totalProduct');
            Session::forget('totalPrice');
            Session::forget('discount');

            return redirect()->route('frontend.cart.index')->with('order_compelete', $orderList->order_id);
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
    public function destroy($id)
    {
        OrderList::destroy($id);
        return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
    }
    public function changePaymentStatus(Request $request)
    {
        OrderList::where('id', $request->id)->update([
            'payment_status' => $request->status
        ]);
    }
    public function changeOrderStatus(Request $request)
    {
        OrderList::where('id', $request->id)->update([
            'order_status' => $request->status
        ]);
    }
}
