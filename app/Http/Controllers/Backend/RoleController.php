<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (session('role_row') == null) $request->session()->put('role_row', env('PAGINATION'));
		if (isset($request->select_row)) $request->session()->put('role_row', $request->select_row);
		$query = Role::orderBy('id', 'DESC')->select('*')->with('permissions');
		if (isset($request->search_value)) $query->where("slug", 'like', "%$request->search_value%");
		$roles = $query->paginate(session('role_row'));
		session()->flashInput($request->input());
		return view('backend.role.index', compact('roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$permissions  = Permission::all();
		return view('backend.role.create', compact('permissions'));
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
			'name.required'           => 'Bạn chưa nhập tên vai trò',
			'permission.required'     => 'Bạn chưa chọn vai trò',

		];
		$validator = Validator::make($request->all(), [
			'name' 			=> 'required|unique:roles|max:21',
			'permission' 	=> 'required',
		], $errorMsgs);

		if ($validator->passes()) {
			$role = Role::create([
				'name'      => $request->name,
				'slug'      => Str::slug($request->name)
			]);

			$role->permissions()->attach($request->permission);

			return redirect()->route('backend.role.index')->with('success', 'Thêm mới thành công');
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
		$role   = Role::find($id);
		$permissions  = Permission::all();
		return view('backend.role.edit', compact(['role', 'permissions']));
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
			'permission.required'         => 'Bạn chưa chọn vai trò',

		];
		$validator = Validator::make($request->all(), [
			'permission' => 'required',
		], $errorMsgs);

		if ($validator->passes()) {
			Role::where('id', $id)->update([
				'name'      => $request->name,
				'slug'      => Str::slug($request->name)
			]);
			Role::find($id)->permissions()->sync($request->permission);

			return redirect()->route('backend.role.index')->with('success', 'Sửa thành công');
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
		Role::destroy($id);
		return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
	}
}
