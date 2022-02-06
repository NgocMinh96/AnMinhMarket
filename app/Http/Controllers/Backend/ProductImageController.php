<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
	public function index(Request $request, $product_id)
	{
		$data = ProductList::where('id', $product_id)->first();
		return view('backend.productimage.index', compact('data'));
	}

	public function store(Request $request, $product_id)
	{
		$errorMsgs = [
			'image.required'     => 'Bạn chưa chọn hình ảnh',
			'image.mimes'        => 'Định dạng hình ảnh là jpeg,png,jpg',
			'image.image'        => 'Chỉ được tải lên tệp hình ảnh',
		];

		$rule = [
			'ordering'          => 'numeric|min:0',
			'image'             => 'required',
			'image.*'           => 'image|mimes:jpeg,png,jpg',
		];

		$validator = Validator::make($request->all(), $rule, $errorMsgs);

		if ($validator->passes()) {
			foreach ($request->file('image') as $item) {
				$imageName = time() . '.' . $item->getClientOriginalName();
				$item->move(public_path('images'), $imageName);
				$arr[] = $imageName;
			}
			foreach ($arr as $key => $value) {
				$image = ProductImage::create([
					'image' => $value,
					'ordering' => $key,
				]);
				$image->products()->attach($product_id);
			}
			return redirect()->route('backend.productimage.index', $product_id)->with('success', 'Thêm mới thành công');
		} else {
			return back()->withErrors($validator->errors())->withInput();
		}
	}

	public function update(Request $request, $id, $product_id)
	{
		$errorMsgs = [
			'image.mimes'        => 'Định dạng hình là jpeg,png,jpg',
			'image.image'        => 'Chỉ được tải lên tệp hình ảnh',
			'ordering.numeric'   => 'Chỉ được nhập số lớn hơn 0',
			'ordering.min'       => 'Chỉ được nhập số lớn hơn 0'
		];

		$rule = [
			'ordering'      => 'numeric|min:0',
			'image'         => 'image|mimes:jpeg,png,jpg',
		];

		$validator = Validator::make($request->all(), $rule, $errorMsgs);

		if ($validator->passes()) {
			$data = [
				'ordering' => $request->ordering,
			];

			if ($request->file('image') != null) {
				$imageName = time() . '.' . $request->file('image')->getClientOriginalName();
				$request->image->move(public_path('images'), $imageName);
				$data = $data + ['image' => $imageName];
				$item = ProductImage::find($id);
				$image_path = 'images/' . $item->image;
				if (file_exists($image_path)) {
					@unlink($image_path);
				}
			}

			ProductImage::where('id', $id)->update($data);

			return redirect()->route('backend.productimage.index', $product_id)->with('success', 'Thay đổi thành công');
		} else {
			return back()->withErrors($validator->errors())->withInput();
		}
	}
	public function destroy($id, $product_id)
	{
		$item = ProductImage::find($id);
		$image_path = 'images/' . $item->image;
		if (file_exists($image_path)) {
			@unlink($image_path);
		}
		$item->delete();

		return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
	}
}
