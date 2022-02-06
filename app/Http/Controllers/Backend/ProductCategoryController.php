<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductList;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (session('productcategory_row') == null) $request->session()->put('productcategory_row', env('PAGINATION'));
		if (isset($request->select_row)) $request->session()->put('productcategory_row', $request->select_row);
		$query = ProductCategory::orderBy('ordering', 'ASC')->select('*');
		if (isset($request->search_value)) $query->where("name", 'like', "%$request->search_value%");
		$categories = $query->paginate(session('productcategory_row'));
		session()->flashInput($request->input());
		return view('backend.productcategory.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		return view('backend.productcategory.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$errorMsgs = [
			'name.required'         => 'Bạn chưa nhập tên danh mục',
			'name.unique'			=> 'Tên danh mục đã tồn tại',
			'ordering.required'     => 'Bạn chưa nhập mô tả',
			'ordering.numeric'      => 'Chỉ được nhập số từ 0 đến 100',
			'ordering.min'          => 'Chỉ được nhập số từ 0 đến 100',
			'ordering.max'          => 'Chỉ được nhập số từ 0 đến 100',
		];
		$validator = Validator::make($request->all(), [
			'name'          => 'required|unique:product_categories',
			'ordering'      => 'required|numeric|min:0|max:100',
		], $errorMsgs);

		if ($validator->passes()) {
			ProductCategory::create([
				'name'          => $request->name,
				'slug'          => Str::slug($request->name),
				'status'        => $request->status,
				'ordering'      => $request->ordering,
			]);

			return redirect()->route('backend.productcategory.index')->with('success', 'Thêm mới thành công');
		} else {
			return back()->withErrors($validator->errors())->withInput();
		}
	}

	/**	
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$category = ProductCategory::find($id);
		return view('backend.productcategory.edit', compact('category'));
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
			'name.required'         => 'Bạn chưa nhập tên danh mục',
			'ordering.required'     => 'Bạn chưa nhập mô tả',
			'ordering.numeric'      => 'Chỉ được nhập số từ 0 đến 100',
			'ordering.min'          => 'Chỉ được nhập số từ 0 đến 100',
			'ordering.max'          => 'Chỉ được nhập số từ 0 đến 100',
		];
		$validator = Validator::make($request->all(), [
			'name'          => 'required',
			'ordering'      => 'required|numeric|min:0|max:100',
		], $errorMsgs);

		if ($validator->passes()) {
			ProductCategory::where('id', $id)->update([
				'name'          => $request->name,
				'slug'          => Str::slug($request->name),
				'status'        => $request->status,
				'ordering'      => $request->ordering,
			]);

			return redirect()->route('backend.productcategory.index')->with('success', 'Sửa thành công');
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
		$category = ProductCategory::find($id);
		$product = $category->products;

		foreach ($product as $value) {
			$item = ProductList::find($value->id);
			foreach ($item->images as $value) {
				$image_path = 'images/' . $value->image;
				if (file_exists($image_path)) {
					@unlink($image_path);
				}
			}
			ProductImage::destroy($item->images);
		}
		ProductList::destroy($category->products);
		$category->delete();
		return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
	}
}
