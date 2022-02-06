<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Auth\User;

class UserLogin extends Controller
{
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'email' => 'required|string',
            'password' => 'required|min:0',
        ]);
    }

    public function login(Request $request)
    {
        // dd(url()->previous());
        $arr = explode('/', url()->previous());
        $arr = end($arr);
        // dd($arr);
        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            if (Auth::guard('web')->attempt($credentials)) {
                return redirect()->route('frontend.home');
            } else {
                return back()->withInput()->withErrors([
                    'loginfail' => ['Email hoặc mật khẩu không chính xác']
                ]);
            }
        }
        return view('frontend.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('frontend.home');
    }

    public function register(Request $request)
    {
        $errorMsgs = [
            'email.required'                    => 'Bạn chưa nhập email',
            'email.email'                       => 'Email không phù hợp',
            'email.unique'                      => 'Email đã tồn tại',
            'name.required'                     => 'Bạn chưa nhập họ tên',
            're_password.required'              => 'Mật khẩu không được rỗng',
            're_password.min'                   => 'Mật khẩu không được ít hơn 6 ký tự',
            'password_confirmation.required'    => 'Nhập lại mật khẩu không đúng',
            'password_confirmation.same'        => 'Nhập lại mật khẩu không chính xác',

        ];

        $rule = [
            'email'   => [
                'required',
                'email',
                'max:50',
                Rule::unique(User::class),
            ],
            'name' => [
                'required',
                'max:20',
            ],
            're_password'   => [
                'required',
                'min:6'
            ],
            'password_confirmation' => [
                'required',
                'same:re_password'
            ]
        ];

        $validator = Validator::make($request->all(), $rule, $errorMsgs);

        if ($validator->fails()) {
            session()->flash('active', 'active');
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $data = [
                'email' => $request->re_email,
                'name'  => $request->name,
                'password' => bcrypt($request->re_password),
            ];
            DB::table('users')->insert($data);
            session()->flash('active', 'active');
            session()->flash('register-success', 'Đăng ký thành công, vui lòng kiểm tra email kích hoạt.');
            return redirect()->route('frontend.login');
        }
    }

    public function update(Request $request)
    {
    }
}
