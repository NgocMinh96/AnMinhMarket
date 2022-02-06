<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ProductList;
use App\Models\ProductCategory;
use App\Models\ProductImage;


class ProductListController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$categories = ProductCategory::all();
		if (session('productlist_row') == null) $request->session()->put('productlist_row', env('PAGINATION'));
		if (isset($request->select_row)) $request->session()->put('productlist_row', $request->select_row);
		$query = ProductList::select('*')->orderBy('id', 'DESC');

		if (isset($request->category)) {
			$data = ProductCategory::where('id', $request->category)->select('*')->firstOrFail();
			if (!$data) return redirect()->back();
			$query = $data->products();
		};

		if (isset($request->search_value)) $query->where($request->search_type, 'like', "%$request->search_value%");
		if ($request->status != '') $query->where('status', $request->status);
		if ($request->special != '') $query->where('special', $request->special);

		$products = $query->paginate(session('productlist_row'));
		session()->flashInput($request->input());

		return view('backend.productlist.index', compact('products', 'categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = ProductCategory::all();
		return view('backend.productlist.create', compact('categories'));
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
			'category.required'     => 'Danh mục chọn khác giá trị mặc định',
			'name.required'         => 'Bạn chưa nhập tên sản phẩm',
			'name.unique'           => 'Tên sản phẩm đã tồn tại',
			'price.required'        => 'Bạn chưa nhập giá bán',
			'price.numeric'         => 'Giá bán chỉ được nhập số',
			'price.min'             => 'Giá bán không được nhỏ hơn 0',
			'sale.required'         => 'Bạn chưa nhập giảm giá',
			'sale.numeric'          => 'Chỉ được nhập số từ 1 dến 100',
			'sale.min'              => 'Chỉ được nhập số từ 1 dến 100',
			'sale.max'              => 'Chỉ được nhập số từ 1 dến 100',
			'label.max'             => 'Không được nhập quá 30 ký tự',
			'description.required'  => 'Bạn chưa nhập mô tả',
			'image.required'        => 'Bạn chưa chọn hình ảnh',
			'image.mimes'           => 'Định dạng hình là jpeg,png,jpg',
			'image.image'           => 'Chỉ được tải lên tệp hình ảnh',
		];

		$rule = [
			'category'      => 'required|not_in:0',
			'name'          => 'required|unique:product_lists',
			'price'         => 'required|numeric|min:0',
			'sale'          => 'required|numeric|min:0|max:100',
			'label'         => 'max:100',
			'description'   => 'required',
			'image'         => 'required',
			'image.*'       => 'image|mimes:jpeg,png,jpg',
		];

		$validator = Validator::make($request->all(), $rule, $errorMsgs);

		if ($validator->passes()) {
			$data = [
				'name'          => $request->name,
				'slug'          => Str::slug($request->name, '-'),
				'price'         => $request->price,
				'sale'          => $request->sale,
				'label'         => $request->label,
				'description'   => $request->description,
				'status'        => $request->status,
				'special'       => $request->special,
				'video'         => $request->video
			];

			$product = ProductList::create($data);
			$product->categories()->attach($request->category);

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
				$image->products()->attach($product->id);
			}

			return redirect()->route('backend.productlist.index')->with('success', 'Thêm mới thành công');
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
		$product = ProductList::find($id);
		$categories = ProductCategory::all();
		return view('backend.productlist.edit', compact(['product', 'categories']));
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
			'category.required'     => 'Danh mục chọn khác giá trị mặc định',
			'name.required'         => 'Bạn chưa nhập tiêu đề',
			'price.required'        => 'Bạn chưa nhập giá bán',
			'price.numeric'         => 'Giá bán chỉ được nhập số',
			'price.min'             => 'Giá bán không được nhỏ hơn 0',
			'sale.required'         => 'Bạn chưa nhập giảm giá',
			'sale.numeric'          => 'Chỉ được nhập số từ 1 dến 100',
			'sale.min'              => 'Chỉ được nhập số từ 1 dến 100',
			'sale.max'              => 'Chỉ được nhập số từ 1 dến 100',
			'description.required'  => 'Bạn chưa nhập mô tả',
			'image.required'        => 'Bạn chưa chọn hình ảnh',
			'image.mimes'           => 'Định dạng hình là jpeg,png,jpg',
			// 'image.image'           => 'Chỉ được tải lên tệp hình ảnh',
		];

		$rule = [
			'category'      => 'required|not_in:0',
			'name'          => 'required',
			'price'         => 'required|numeric|min:0',
			'sale'          => 'required|numeric|min:0|max:100',
			'description'   => 'required',
			// 'image.*'       => 'image|mimes:jpeg,png,jpg',
		];

		$validator = Validator::make($request->all(), $rule, $errorMsgs);

		if ($validator->passes()) {
			$data = [
				'name'          => $request->name,
				'slug'          => Str::slug($request->name, '-'),
				'price'         => $request->price,
				'sale'          => $request->sale,
				'label'         => $request->label,
				'description'   => $request->description,
				'status'        => $request->status,
				'special'       => $request->special,
				'video'         => $request->video
			];

			ProductList::where('id', $id)->update($data);
			ProductList::find($id)->categories()->sync($request->category);

			return redirect()->route('backend.productlist.index')->with('success', 'Sửa thành công');
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
		$product = ProductList::find($id);
		foreach ($product->images as $value) {
			$image_path = 'images/' . $value->image;
			if (file_exists($image_path)) {
				@unlink($image_path);
			}
		}
		ProductImage::destroy($product->images);
		$product->delete();

		return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
	}
}
