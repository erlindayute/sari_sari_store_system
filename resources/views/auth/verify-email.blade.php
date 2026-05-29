<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify Email — TindaHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        :root{
            --ink:#0e0d0b;
            --paper:#faf8f4;
            --warm:#f5f0e8;
            --accent:#e8521a;
            --border:rgba(14,13,11,0.12);
            --text2:#5c5852;
            --text3:#9c9890;
            --r:10px;
        }

        body{
            font-family:'DM Sans',sans-serif;
            background:var(--warm);
            color:var(--ink);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:2rem;
        }

        body::before{
            content:'';
            position:fixed;
            inset:0;
            background-image:
                linear-gradient(var(--border) 1px,transparent 1px),
                linear-gradient(90deg,var(--border) 1px,transparent 1px);
            background-size:48px 48px;
            opacity:.4;
            pointer-events:none;
        }

        .auth-wrap{
            width:100%;
            max-width:420px;
            position:relative;
            z-index:1;
        }

        .auth-logo{
            font-family:'Playfair Display',serif;
            font-size:20px;
            font-weight:700;
            color:var(--ink);
            text-decoration:none;
            display:block;
            text-align:center;
            margin-bottom:2rem;
        }

        .auth-logo span{
            color:var(--accent);
        }

        .auth-card{
            background:#fff;
            border:1px solid var(--border);
            border-radius:16px;
            padding:2.5rem;
            box-shadow:0 4px 32px rgba(14,13,11,.06);
            text-align:center;
        }

        .auth-title{
            font-family:'Playfair Display',serif;
            font-size:1.75rem;
            margin-bottom:.4rem;
        }

        .auth-sub{
            font-size:14px;
            color:var(--text2);
            margin-bottom:2rem;
            line-height:1.6;
        }

        .success-icon{
            font-size:56px;
            margin-bottom:1rem;
        }

        .btn-submit{
            width:100%;
            padding:13px;
            border:none;
            border-radius:var(--r);
            background:var(--ink);
            color:#fff;
            font-size:15px;
            font-weight:500;
            cursor:pointer;
            transition:.2s;
            text-decoration:none;
            display:inline-block;
            margin-top:1rem;
        }

        .btn-submit:hover{
            background:var(--accent);
        }

        .alert{
            padding:12px 16px;
            border-radius:8px;
            margin-bottom:1rem;
            font-size:14px;
        }

        .alert-success{
            background:#d4edda;
            color:#155724;
            border:1px solid #c3e6cb;
        }
    </style>
</head>
<body>

<div class="auth-wrap">

    <a href="{{ route('welcome') }}" class="auth-logo">
        Tinda<span>Hub</span>
    </a>

    <div class="auth-card">

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="success-icon">✉️</div>
        <div class="auth-title">Verify your email</div>
        <div class="auth-sub">
            We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>. 
            Please check your email and click the link to verify your account.
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-submit">
                Resend verification email
            </button>
        </form>

        <p style="font-size:12px;color:var(--text3);margin-top:1.5rem">
            If you don't receive the email within a few minutes, check your spam folder or
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:var(--accent);cursor:pointer;text-decoration:underline;font-size:12px;">
                    sign out and try again
                </button>
            </form>
        </p>

    </div>

</div>

</body>
</html>
