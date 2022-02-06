<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $webInfo->brand }}</title>
    <link rel="icon" href="{{ asset('images/' . $webInfo->favicon) }}">
    <link rel="stylesheet" href="{{ asset('client/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/custom/main.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/custom/user-form.css') }}">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <style>
        :root {
            --color-custom: {{ $webInfo->color }};
            --color-custom-light: {{ str_replace(',', '', str_replace(')', ' /.12)', $webInfo->color)) }};
        }

        *:focus {
            box-shadow: 0 0 0 3px var(--color-custom-light), 0 2px 5px 0 var(--color-custom-light), 0 1px 1.5px 0 rgb(0 0 0 / 7%), 0 1px 2px 0 rgb(0 0 0 / 8%) !important;
        }

        .bg-login {
            background-image: url(images/bg-login.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

    </style>
</head>
<body class="bg-login">
    <section class="user-form-part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-4">
                    <div class="user-form-card shadow-sm">
                        <div class="user-form-logo">
                            <a href="#">
                                <img src="{{ asset('images/' . $webInfo->logo) }}" height="100%" width="100%" />
                            </a>
                        </div>
                        <form class="user-form" action="{{ route('backend.login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="username" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" autofocus placeholder="Tài Khoản">
                                @error('username')
                                    <span class="invalid-feedback is-invalid d-block mt-2" role="alert">{{ $message }}
                                        tài
                                        khoản</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" value=""
                                    placeholder="Mật Khẩu">
                                @error('password')
                                    <span class="invalid-feedback is-invalid d-block mt-2" role="alert">{{ $message }}
                                        mật
                                        khẩu</span>
                                @enderror
                                @error('loginfail')
                                    <span class="invalid-feedback is-invalid d-block mt-2"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-secondary-soft">ĐĂNG NHẬP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('client/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/bootstrap.min.js') }}"></script>
</body>

</html>
