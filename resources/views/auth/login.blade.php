<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Sign In — TindaHub</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

@vite([
    'resources/css/login.css',
    'resources/js/login.js'
])

</head>

<body>

<div class="auth-wrap">

    <a href="{{ route('welcome') }}" class="auth-logo">
        Tinda<span>Hub</span>
    </a>

    <div class="auth-card">

        <div class="auth-title">Welcome back</div>

        <div class="auth-sub">
            Don't have an account?
            <a href="{{ route('register') }}">Sign up free</a>
        </div>

        <!-- LOGIN FORM -->
        <form method="POST" action="{{ route('login.submit') }}" onsubmit="validateLoginForm(event)">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input"
                    placeholder="maria@example.com"
                    required
                >
            </div>

            <!-- Password -->
            <div class="form-group">

                <label for="password">Password</label>

                <div class="pw-wrap">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Your password"
                        required
                    >

                    <button
                        type="button"
                        class="pw-toggle"
                        onclick="togglePw('password', this)"
                    >
                        👁
                    </button>

                </div>

            </div>

            <!-- Forgot -->
            <a href="{{ route('password.request') }}" class="forgot">
                Forgot password?
            </a>

            <!-- Remember -->
            <div class="remember-wrap">

                <input type="checkbox" id="rememberMe" name="remember">

                <label for="rememberMe">
                    Keep me signed in
                </label>

            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit" id="loginBtn">
                Sign In

                <div class="btn-loader">
                    <div class="spinner"></div>
                </div>
            </button>

        </form>

    </div>

</div>


</body>
</html>