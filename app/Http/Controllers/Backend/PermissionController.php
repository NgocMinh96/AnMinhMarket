<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (session('permission_row') == null) $request->session()->put('permission_row', env('PAGINATION'));
		if (isset($request->select_row)) $request->session()->put('permission_row', $request->select_row);
		$query = Permission::orderBy('id', 'DESC')->select('*');
		if (isset($request->search_value)) $query->where("slug", 'like', "%$request->search_value%");
		$data = $query->paginate(session('permission_row'));
		session()->flashInput($request->input());
		return view('backend.permission.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('backend.permission.create');
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
			'name.required'             => 'Bạn chưa nhập tên chức năng',
			'description.required'      => 'Bạn chưa nhập mô tả',

		];
		$validator = Validator::make($request->all(), [
			'name'          => 'required',
			'description'   => 'required',
		], $errorMsgs);

		if ($validator->passes()) {
			Permission::create([
				'name'          => $request->name,
				'slug'          => Str::slug($request->name),
				'description'   => $request->description,
			]);

			return redirect()->route('backend.permission.index')->with('success', 'Sửa thành công');
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
		$data = Permission::find($id);
		return view('backend.permission.edit', compact('data'));
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
			'name.required'             => 'Bạn chưa nhập tên chức năng',
			'description.required'      => 'Bạn chưa nhập mô tả',

		];
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'description' => 'required',
		], $errorMsgs);

		if ($validator->passes()) {
			Permission::where('id', $id)->update([
				'name'          => $request->name,
				'slug'          => Str::slug($request->name),
				'description'   => $request->description,
			]);

			return redirect()->route('backend.permission.index')->with('success', 'Sửa thành công');
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
		Permission::destroy($id);
		return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
	}
}
