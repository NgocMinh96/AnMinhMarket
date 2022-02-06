<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductList;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $category = ProductCategory::orderBy('ordering', 'ASC')->select('*')->get();
        $product = ProductList::select('*');
        if (isset($request->category_id)) {
            $data = ProductCategory::where('id', $request->category_id)->select('*')->firstOrFail();
            if (!$data) return view('error.404');
            $product = $data->products();
        };
        if (isset($request->search_value)) $product->where("name", 'like', "%$request->search_value%");
        if (isset($request->sort_price)) $product->orderBy('price', $request->sort_price);
        if (isset($request->sort_sale)) $product->where('sale', '>', 0)->orderBy('sale', 'DESC');

        $product = $product->paginate(9);
        session()->flashInput($request->input());
        return view('frontend.shop.index', compact('category', 'product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductList::select('*')->where('id', $id)->first();
        // dd($product->categories[0]->name);
        $product_previous =  ProductList::select('*')->where('id', '<',$id)->orderBy('id','desc')->first();
        $product_next =  ProductList::select('*')->where('id', '>',$id)->orderBy('id','asc')->first();
        return view('frontend.shop.show', compact('product', 'product_previous', 'product_next'));
    }

    public function modal(Request $request)
    {
        $product = ProductList::where('id', $request->id)->first();

        $ximg = '';
        foreach ($product->images as $key => $item) {
            if ($key <= 3) {
                $ximg .= '<li><img src="' . asset('images/' . $item->image) . '" alt="' . $product->name . '"></li>';
            }
        };

        $label = $product->label != null ? '<label class="view-label new">' . $product->label . '</label>' : '';
        $labelSale = $product->sale > 0 ? '<label class="view-label off">-' . $product->sale . ' %</label>' : '';

        $info = DB::table('settings')->first();

        $xhtml = '
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="view-gallery">
                        ' . $label . '
                        <ul class="preview-slider slider-arrow">
                            ' . $ximg . '
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="view-details">
                        <h3 class="view-name d-flex align-items-center">
                            <span>' . $product->name . '</span>
                        </h3>
                        <h3 class="view-price d-flex align-items-center">
                            <span>' . number_format($product->price - ($product->price * ($product->sale / 100))) . ' đ</span>
                            ' . $labelSale . '
                        </h3>
                    </div>
                </div>
            </div>';

        return response()->json([
            'xhtml'      => $xhtml,
        ]);
    }
}
