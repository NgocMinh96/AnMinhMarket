<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\ProductList;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $province = Province::all();
        return view('frontend.cart.index', compact('province'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $product = ProductList::select('*')->where('id', $id)->first();
        $price = $product->price - ($product->price * ($product->sale / 100));

        $cart = [];
        if ($request->session()->has('cart') == false) {
            $cart[$id] = [
                'id'        => $id,
                'name'      => $product->name,
                'image'     => $product->images[0]['image'],
                'price'     => $price,
                'quantity'  => 1,
            ];
        } else {
            $cart = $request->session()->get('cart');
            if (array_key_exists($id, $cart)) {
                $cart[$id] = [
                    'id'        => $id,
                    'name'      => $product->name,
                    'image'     => $product->images[0]['image'],
                    'price'     => $price,
                    'quantity'  => $cart[$id]['quantity'] + 1,
                ];
            } else {
                $cart[$id] = [
                    'id'        => $id,
                    'name'      => $product->name,
                    'image'     => $product->images[0]['image'],
                    'price'     => $price,
                    'quantity'  => 1,
                ];
            }
        }
        Session::put('cart', $cart);

        $cart           = $request->session()->get('cart');
        $totalProduct   = $this->calItem($cart);
        $totalPrice     = $this->calPrice($cart);

        return response()->json([
            'cart'          => $cart,
            'totalProduct'  => $totalProduct,
            'totalPrice'    => $totalPrice,
        ]);
    }

    public function update(Request $request)
    {
        $id     = $request->id;
        $cart   = $request->session()->get('cart');

        if ($request->type == 'minus' && ($cart[$id]['quantity'] > 1)) {
            $cart[$id] = [
                'id'        => $cart[$id]['id'],
                'name'      => $cart[$id]['name'],
                'image'     => $cart[$id]['image'],
                'price'     => $cart[$id]['price'],
                'quantity'  => $cart[$id]['quantity'] - 1,
            ];
            Session::forget('lastPrice');
        } else if ($request->type == 'plus') {
            $cart[$id] = [
                'id'        => $cart[$id]['id'],
                'name'      => $cart[$id]['name'],
                'image'     => $cart[$id]['image'],
                'price'     => $cart[$id]['price'],
                'quantity'  => $cart[$id]['quantity'] + 1,
            ];
            Session::forget('lastPrice');
        }
        Session::put('cart', $cart);

        $cart       = $request->session()->get('cart');

        return response()->json([
            'cart'          => $cart[$id],
            'totalProduct'  => $this->calItem($cart),
            'totalPrice'    => $this->calPrice($cart)
        ]);
    }


    public function destroy(Request $request)
    {
        Session::forget('cart.' . $request->id . '');
        Session::forget('lastPrice');

        $cart           = $request->session()->get('cart');
        if (empty($cart)) Session::forget('cart');
        $totalProduct   = $this->calItem($cart);
        $totalPrice     = $this->calPrice($cart);

        return response()->json([
            'cart'             => $cart,
            'totalProduct'     => $totalProduct,
            'totalPrice'       => $totalPrice,
        ]);
    }

    function calItem($cart)
    {
        $totalProduct = 0;
        foreach ($cart as $item) {
            $totalProduct += $item['quantity'];
        }
        Session::put('totalProduct', $totalProduct);
        return $totalProduct;
    }

    function calPrice($cart)
    {
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        Session::put('totalPrice', $totalPrice);
        return $totalPrice;
    }

    function applyCoupon(Request $request)
    {
        $coupon =  Coupon::where('coupon', $request->coupon)->first();
        $error = '';
        $success = false;
        $totalPrice = session()->get('totalPrice');
        $lastPrice = $totalPrice;

        if ($coupon == null) {
            $error = 'Mã không hợp lệ';
        } elseif ($coupon != null) {
            $now = date('Y-m-d H:i:s', strtotime(now()));
            if ($now < $coupon->start_at) $error = 'Mã không hợp lệ';
            if ($now > $coupon->end_at) $error = 'Mã đã hết hạn sử dụng';
            if (($now >= $coupon->start_at) && ($now <= $coupon->end_at)) {
                if ($totalPrice < $coupon->condition) $error = 'Đơn hàng chưa đủ ' . number_format($coupon->condition) . ' đ để áp dụng mã';
                if ($totalPrice >= $coupon->condition) {
                    $success = true;
                    $lastPrice = $totalPrice - $coupon->amount;
                    Session::put('lastPrice', $lastPrice);
                    Session::put('discount', $coupon->amount);
                }
            }
        }

        return response()->json([
            'error'           => $error,
            'success'         => $success,
            'coupon'          => $coupon,
            'lastPrice'       => $lastPrice
        ]);
    }

    function getDistrict(Request $request)
    {
        $province = Province::where('id', $request->id)->first();
        return response()->json([
            'district' => $province->districts
        ]);
    }

    function getWard(Request $request)
    {
        $district = District::where('id', $request->id)->first();
        return response()->json([
            'ward' => $district->wards
        ]);
    }
}
