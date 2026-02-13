<!DOCTYPE html>
<html lang="en">

<head>

    @include('layout.header')

    <title>Login</title>

    <!-- Only for Login Page -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>

<body>

    <div class="container">

        <!-- LEFT IMAGE PANEL -->
        <div class="left"></div>

        <!-- RIGHT FORM PANEL -->
        <div class="right">

            <div class="form-box">

                <h2>Login</h2>

                @if (session('error'))
                    <p class="error">{{ session('error') }}</p>
                @endif

                <!-- SERP LOGIN FORM -->
                <form method="POST" action="{{ url('/serp-login') }}">
                    @csrf

                    <input type="text" name="username" placeholder="ERP ID" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">
                        Login
                    </button>
                </form>

            </div>

        </div>

    </div>

</body>

</html>
