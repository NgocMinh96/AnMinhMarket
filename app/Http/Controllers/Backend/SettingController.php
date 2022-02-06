<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
	public function index()
	{
		return view('backend.setting.index');
	}

	public function update(Request $request)
	{
		$update_for = $request->update_for;

		$errorMsgs = [
			'favicon.required'        => 'Bạn chưa chọn hình ảnh',
			'favicon.mimes'           => 'Định dạng hình là jpeg,png,jpg',
			'favicon.image'           => 'Chỉ được tải lên tệp hình ảnh',
			'logo.required'           => 'Bạn chưa chọn hình ảnh',
			'logo.mimes'              => 'Định dạng hình là jpeg,png,jpg',
			'logo.image'              => 'Chỉ được tải lên tệp hình ảnh',
			'banner.required'         => 'Bạn chưa chọn hình ảnh',
			'banner.mimes'            => 'Định dạng hình là jpeg,png,jpg',
			'banner.image'            => 'Chỉ được tải lên tệp hình ảnh',
			'brand.required'          => 'Thương hiệu không được trống',
			'color.required'          => 'Màu sắc không được trống',
			'phone.required'          => 'Số điện thoại không được trống',
		];

		switch ($update_for) {
			case 'favicon':
				$rule_favicon = [
					'favicon'         => 'required',
					'favicon.*'       => 'image|mimes:jpeg,png,jpg',
				];
				$validator = Validator::make($request->all(), $rule_favicon, $errorMsgs);
				if ($validator->passes()) {
					if ($request->file('favicon') != null) {
						$imageName = time() . '.' . $request->file('favicon')->getClientOriginalName();
						$request->favicon->move(public_path('images'), $imageName);
						$data = DB::table('settings')->select('favicon')->first();
						$this->unPath($data->favicon);
					}
					DB::table('settings')->update(['favicon' => $imageName]);
					return redirect()->route('backend.setting.index')->with('success', 'Thay đổi favicon thành công');
				} else {
					return back()->withErrors($validator->errors())->withInput();
				}
				break;

			case 'logo':
				$rule_logo = [
					'logo'            => 'required',
					'logo.*'          => 'image|mimes:jpeg,png,jpg',
				];
				$validator = Validator::make($request->all(), $rule_logo, $errorMsgs);
				if ($validator->passes()) {
					if ($request->file('logo') != null) {
						$imageName = time() . '.' . $request->file('logo')->getClientOriginalName();
						$request->logo->move(public_path('images'), $imageName);
						$data = DB::table('settings')->select('logo')->first();
						$this->unPath($data->logo);
					}
					DB::table('settings')->update(['logo' => $imageName]);
					return redirect()->route('backend.setting.index')->with('success', 'Thay đổi logo thành công');
				} else {
					return back()->withErrors($validator->errors())->withInput();
				}
				break;

			case 'banner':
				$rule_banner = [
					'banner.*'          => 'image|mimes:jpeg,png,jpg',
				];
				$validator = Validator::make($request->all(), $rule_banner, $errorMsgs);
				if ($validator->passes()) {
					if ($request->file('banner') != null) {
						$imageName = time() . '.' . $request->file('banner')->getClientOriginalName();
						$request->banner->move(public_path('images'), $imageName);
						$data = DB::table('settings')->select('banner')->first();
						$this->unPath($data->banner);
						DB::table('settings')->update([
							'banner' => $imageName,
						]);
					}
					DB::table('settings')->update([
						'title'  => $request->title,
						'description' => $request->description
					]);
					return redirect()->route('backend.setting.index')->with('success', 'Thay đổi banner thành công');
				} else {
					return back()->withErrors($validator->errors())->withInput();
				}
				break;

			case 'info':
				$rule_banner = [
					'brand' => 'required',
					'color' => 'required',
					'phone' => 'required',

				];
				$validator = Validator::make($request->all(), $rule_banner, $errorMsgs);
				if ($validator->passes()) {
					$data = [
						'brand' 	=> $request->brand,
						'color' 	=> $request->color,
						'phone' 	=> $request->phone,
						'email' 	=> $request->email,
						'address' 	=> $request->address,
						'map' 		=> $request->map,
						'facebook' 	=> $request->facebook,
						'messenger' => $request->messenger,
						'youtube' 	=> $request->youtube,
						'keyword'	=> $request->keyword
					];

					DB::table('settings')->update($data);

					return redirect()->route('backend.setting.index')->with('success', 'Thay đổi thông tin thành công');
				} else {
					return back()->withErrors($validator->errors())->withInput();
				}
				break;
		}
	}

	public function unPath($data)
	{
		$path = 'images/' . $data;
		if (file_exists($path)) {
			@unlink($path);
		}
	}
}
