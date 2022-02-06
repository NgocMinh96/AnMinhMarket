<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (session('user_row') == null) $request->session()->put('user_row', env('PAGINATION'));
		if (isset($request->select_row)) $request->session()->put('user_row', $request->select_row);
		$query = Admin::orderBy('id', 'DESC')->select('*')->with('roles');
		if (isset($request->search_value)) $query->where("$request->search_type", 'like', "%$request->search_value%");
		$users = $query->paginate(session('user_row'));
		session()->flashInput($request->input());
		return view('backend.user.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$roles = Role::all();
		return view('backend.user.create', compact('roles'));
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
			'username.required'     => 'Bạn chưa nhập tài khoản',
			'username.unique'       => 'Tài khoản đã tồn tại',
			'name.required'         => 'Bạn chưa nhập họ tên',
			'password.required'     => 'Bạn chưa nhập mật khẩu',
			'role.required'         => 'Bạn chưa chọn vai trò',

		];
		$validator = Validator::make($request->all(), [
			'name' 		=> 'required|max:21',
			'username' 	=> 'required|unique:admins|max:21',
			// Rule::unique(Admin::class),
			'password' 	=> 'required',
			'role' 		=> 'required',
		], $errorMsgs);

		if ($validator->passes()) {
			$user = Admin::create([
				'username'  => $request->username,
				'name'      => $request->name,
				'password'  => Hash::make($request->password),
				'status'    => $request->status,
			]);
			$user->roles()->attach($request->role);

			return redirect()->route('backend.user.index')->with('success', 'Thêm mới thành công');
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
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$user   = Admin::find($id);
		$roles  = Role::all();
		return view('backend.user.edit', compact(['user', 'roles']));
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
			'role.required'         => 'Bạn chưa chọn vai trò',

		];
		$validator = Validator::make($request->all(), [
			'role' => 'required',
		], $errorMsgs);

		if ($validator->passes()) {
			$user = Admin::where('id', $id)->update([
				'status'    => $request->status,
			]);
			$user = Admin::find($id);
			$user->roles()->sync($request->role);

			return redirect()->route('backend.user.index')->with('success', 'Sửa thành công');
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
		if ($id == 1) {
			return redirect()->back()->with('error', 'Không thể xóa tài khoản này');
		} else {
			$user = Admin::find($id);
			$imagePath = 'images/' . $user->image;
			if (file_exists($imagePath)) {
				@unlink($imagePath);
			}
			Admin::destroy($id);
			return redirect()->back()->with('success', 'Xóa thành viên thành công');
		}
	}
}
