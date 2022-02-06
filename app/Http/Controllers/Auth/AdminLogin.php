<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;

class AdminLogin extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string',
            'password' => 'required|min:0',
        ]);
    }

    public function login(Request $request)
    {
        // dd($request);
        if ($request->isMethod('post')) {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            if (Auth::guard('admin')->attempt([
                'username' => $request->username,
                'password' => $request->password,
                // 'status' => 1
            ])) {
                return redirect()->route('backend.dashboard');
            } else {
                return back()->withInput()->withErrors([
                    'loginfail' => ['Tài khoản hoặc mật khẩu không đúng']
                ]);
            }
        }
        return view('backend.login');
    }

    public function logout(Request $request)
    {
        // dd($request);
        Auth::guard('admin')->logout();
        return redirect()->route('backend.login');
    }
}
