<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserInfoController extends Controller
{
    public function index()
    {
        return view('backend.userinfo.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $errorMsgs = [
            'image.mimes'        => 'Định dạng hình là jpeg,png,jpg',
            'image.image'        => 'Chỉ được tải lên tệp hình ảnh',
            'password.required'  => 'Bạn chưa nhập mật khẩu',
            'password.confirmed' => 'Nhập lại mật khẩu không chính xác',
        ];

        switch ($request->update_for) {
            case 'info':
                Admin::where('id', $request->user()->id)
                    ->update(['name' => $request->name]);
                $rule_image = [
                    'image'     => 'image|mimes:jpeg,png,jpg',
                ];
                $validator = Validator::make($request->all(), $rule_image, $errorMsgs);
                if ($validator->passes() && $request->file('image') != null) {
                    $imageName = time() . '.' . $request->file('image')->getClientOriginalName();
                    $request->image->move(public_path('images'), $imageName);
                    $imagePath = 'images/' . $request->user()->image;
                    if (file_exists($imagePath)) {
                        @unlink($imagePath);
                    }
                    Admin::where('id', $request->user()->id)
                        ->update(['image' => $imageName]);
                    return redirect()->route('backend.userinfo.index')->with('success', 'Cập nhật thành công');
                } else {
                    return back()->withErrors($validator->errors())->withInput();
                }
                break;

            case 'password':
                $rule_password = [
                    'password' => 'required|confirmed',
                ];
                $validator = Validator::make($request->all(), $rule_password, $errorMsgs);
                if ($validator->passes()) {
                    Admin::where('id', $request->user()->id)
                        ->update(['password' =>   Hash::make($request->password)]);
                    return back()->with('success', 'Cập nhật thành công');
                } else {
                    return back()->withErrors($validator->errors())->withInput();
                }
                break;
        }
    }
}
