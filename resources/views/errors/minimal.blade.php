<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('client/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/custom/main.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/custom/error.css') }}">
</head>

<body>
    <section class="error-part">
        <div class="container">
            <h1>@yield('code') | @yield('message')</h1>
            <img class="img-fluid" src="{{ asset('client/images/error.png') }}" alt="error">
            <h3>ooopps! this page can't be found.</h3>
            <p>It looks like nothing was found at this location.</p>
            <a href="{{ route('frontend.shop.index') }}">Quay lại</a>
        </div>
    </section>
</body>

</html>
