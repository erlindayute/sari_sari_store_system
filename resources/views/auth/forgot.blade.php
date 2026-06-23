<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password — TindaHub</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--ink:#0e0d0b;--paper:#faf8f4;--warm:#f5f0e8;--accent:#e8521a;--border:rgba(14,13,11,.12);--text2:#5c5852;--text3:#9c9890;--r:10px;--green:#1d9e75;--red:#d94040}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--ink);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(var(--border) 1px,transparent 1px),linear-gradient(90deg,var(--border) 1px,transparent 1px);background-size:48px 48px;opacity:.4;pointer-events:none}
.wrap{width:100%;max-width:420px;position:relative;z-index:1}
.logo{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--ink);text-decoration:none;display:block;text-align:center;margin-bottom:2rem}
.logo span{color:var(--accent)}
.card{background:white;border:1px solid var(--border);border-radius:16px;padding:2.5rem;box-shadow:0 4px 32px rgba(14,13,11,.06)}
h1{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;margin-bottom:.4rem}
.sub{font-size:14px;color:var(--text2);margin-bottom:2rem;line-height:1.6}
.sub a{color:var(--accent);text-decoration:none}
.fg{margin-bottom:1.25rem}
label{display:block;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:6px}
.fc{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r);font-size:14px;color:var(--ink);background:var(--paper);font-family:'DM Sans',sans-serif;transition:border-color .2s;outline:none}
.fc:focus{border-color:var(--ink);box-shadow:0 0 0 3px rgba(14,13,11,.05)}
.fc.err{border-color:var(--red)!important}
.btn{width:100%;padding:13px;background:var(--ink);color:white;border:none;border-radius:var(--r);font-size:15px;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .2s;display:flex;align-items:center;justify-content:center;gap:8px}
.btn:hover{background:var(--accent)}
.btn:disabled{opacity:.6;cursor:not-allowed}
.spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:white;border-radius:50%;animation:spin .65s linear infinite;display:none}
.btn.loading .spinner{display:inline-block}
.btn.loading .btn-label{display:none}
@keyframes spin{to{transform:rotate(360deg)}}
.alert{padding:.75rem 1rem;border-radius:8px;font-size:13px;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.6rem}
.alert-success{background:#e1f5ee;border:1px solid #9fe1cb;color:#0f6e56}
.alert-error{background:#fff1f1;border:1px solid #f7c1c1;color:#a32d2d}
.ferr{font-size:12px;color:var(--red);margin-top:4px}
.back{display:flex;align-items:center;gap:5px;font-size:13px;color:var(--text2);text-decoration:none;margin-top:1.25rem;justify-content:center;transition:color .2s}
.back:hover{color:var(--ink)}
/* success panel */
.success-panel{display:none;text-align:center;padding:.5rem 0}
.success-panel.show{display:block}
.success-ico{font-size:52px;display:block;margin-bottom:1rem;animation:pop .4s cubic-bezier(.34,1.56,.64,1)}
@keyframes pop{from{transform:scale(.5);opacity:0}to{transform:scale(1);opacity:1}}
</style>
</head>
<body>
<div class="wrap">
  <a href="{{ route('login') }}" class="logo">Tinda<span>Hub</span></a>

  <div class="card">

    {{-- Status from controller (success) --}}
    @if(session('status'))
      <div class="alert alert-success">
        <span>✓</span> <span>{{ session('status') }}</span>
      </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
      <div class="alert alert-error">
        <span>⚠</span>
        <div>
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Form panel (hidden once we have a status) --}}
    <div id="formPanel" @if(session('status')) style="display:none" @endif>
      <h1>Forgot password?</h1>
      <p class="sub">
        Enter the email linked to your account and we'll send a reset link.
        Remember it? <a href="{{ route('login') }}">Sign in</a>
      </p>

      <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
        @csrf
        <div class="fg">
          <label for="email">Email address</label>
          <input
            type="email"
            name="email"
            id="email"
            class="fc @error('email') err @enderror"
            value="{{ old('email') }}"
            placeholder="you@example.com"
            autocomplete="email"
            required
            autofocus
          >
          @error('email')
            <div class="ferr">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn" id="submitBtn">
          <span class="btn-label">Send reset link</span>
          <span class="spinner"></span>
        </button>
      </form>
    </div>

    {{-- Success panel (shown after status) --}}
    @if(session('status'))
    <div class="success-panel show">
      <span class="success-ico">📬</span>
      <h1 style="margin-bottom:.5rem">Check your inbox</h1>
      <p style="font-size:14px;color:var(--text2);line-height:1.7;margin-bottom:1.75rem">
        {{ session('status') }}
      </p>
      <a href="{{ route('login') }}" class="btn" style="text-decoration:none">Back to sign in</a>
      <div style="margin-top:1rem;font-size:12px;color:var(--text3)">
        Didn't get it?
        <form method="POST" action="{{ route('password.email') }}" style="display:inline">
          @csrf
          <input type="hidden" name="email" value="{{ old('email') }}">
          <button type="submit" style="background:none;border:none;color:var(--accent);font-size:12px;cursor:pointer;font-family:'DM Sans',sans-serif;padding:0">
            Resend email
          </button>
        </form>
      </div>
    </div>
    @endif

    <a href="{{ route('login') }}" class="back">← Back to sign in</a>
  </div>
</div>

<script>
document.getElementById('forgotForm')?.addEventListener('submit', function() {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.classList.add('loading');
});
</script>
</body>
</html>
