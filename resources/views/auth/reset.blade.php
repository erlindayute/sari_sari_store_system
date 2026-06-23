<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — TindaHub</title>
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
.fg{margin-bottom:1.25rem}
label{display:block;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:6px}
.pw-wrap{position:relative}
.fc{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r);font-size:14px;color:var(--ink);background:var(--paper);font-family:'DM Sans',sans-serif;transition:border-color .2s;outline:none}
.fc:focus{border-color:var(--ink);box-shadow:0 0 0 3px rgba(14,13,11,.05)}
.fc.err{border-color:var(--red)!important}
.pw-wrap .fc{padding-right:42px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3);font-size:16px;padding:0;line-height:1}
.ferr{font-size:12px;color:var(--red);margin-top:4px}
/* strength bar */
.strength-bar{height:3px;background:var(--border);border-radius:2px;overflow:hidden;margin-top:6px}
.strength-fill{height:100%;border-radius:2px;transition:width .3s,background .3s;width:0}
.strength-label{font-size:11px;color:var(--text3);margin-top:3px}
.btn{width:100%;padding:13px;background:var(--ink);color:white;border:none;border-radius:var(--r);font-size:15px;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .2s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:.5rem}
.btn:hover{background:var(--accent)}
.btn:disabled{opacity:.6;cursor:not-allowed}
.spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:white;border-radius:50%;animation:spin .65s linear infinite;display:none}
.btn.loading .spinner{display:inline-block}
.btn.loading .btn-label{display:none}
@keyframes spin{to{transform:rotate(360deg)}}
.alert-error{background:#fff1f1;border:1px solid #f7c1c1;color:#a32d2d;padding:.75rem 1rem;border-radius:8px;font-size:13px;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.6rem}
.back{display:flex;align-items:center;gap:5px;font-size:13px;color:var(--text2);text-decoration:none;margin-top:1.25rem;justify-content:center}
.back:hover{color:var(--ink)}
</style>
</head>
<body>
<div class="wrap">
  <a href="{{ route('login') }}" class="logo">Tinda<span>Hub</span></a>

  <div class="card">
    <h1>Set new password</h1>
    <p class="sub">Choose a strong password for your account.</p>

    @if($errors->any())
      <div class="alert-error">
        <span>⚠</span>
        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" id="resetForm">
      @csrf

      {{-- Hidden fields required by Laravel's Password::reset() broker --}}
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="fg">
        <label for="email">Email address</label>
        <input
          type="email"
          name="email"
          id="email"
          class="fc @error('email') err @enderror"
          value="{{ old('email', $email ?? '') }}"
          placeholder="you@example.com"
          autocomplete="email"
          required
        >
        @error('email')<div class="ferr">{{ $message }}</div>@enderror
      </div>

      <div class="fg">
        <label for="password">New password</label>
        <div class="pw-wrap">
          <input
            type="password"
            name="password"
            id="password"
            class="fc @error('password') err @enderror"
            placeholder="At least 8 characters"
            autocomplete="new-password"
            required
            oninput="checkStrength(this.value)"
          >
          <button type="button" class="pw-toggle" onclick="togglePw('password',this)">👁</button>
        </div>
        <div class="strength-bar"><div class="strength-fill" id="strFill"></div></div>
        <div class="strength-label" id="strLabel">Enter a password</div>
        @error('password')<div class="ferr">{{ $message }}</div>@enderror
      </div>

      <div class="fg">
        <label for="password_confirmation">Confirm new password</label>
        <div class="pw-wrap">
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="fc"
            placeholder="Repeat password"
            autocomplete="new-password"
            required
          >
          <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation',this)">👁</button>
        </div>
      </div>

      <button type="submit" class="btn" id="submitBtn">
        <span class="btn-label">Reset password</span>
        <span class="spinner"></span>
      </button>
    </form>

    <a href="{{ route('login') }}" class="back">← Back to sign in</a>
  </div>
</div>

<script>
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type  = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'text' ? '🙈' : '👁';
}

function checkStrength(pw) {
  const fill  = document.getElementById('strFill');
  const label = document.getElementById('strLabel');
  if (!pw) { fill.style.width = '0'; label.textContent = 'Enter a password'; label.style.color = ''; return; }
  let score = 0;
  if (pw.length >= 8)           score++;
  if (/[A-Z]/.test(pw))         score++;
  if (/[0-9]/.test(pw))         score++;
  if (/[^A-Za-z0-9]/.test(pw))  score++;
  const levels = [
    { w:'20%', c:'#e24b4a', t:'Too weak'    },
    { w:'40%', c:'#e24b4a', t:'Weak'        },
    { w:'65%', c:'#ef9f27', t:'Fair'        },
    { w:'85%', c:'#1d9e75', t:'Strong'      },
    { w:'100%',c:'#1d9e75', t:'Very strong' },
  ];
  const l = levels[Math.min(score, 4)];
  fill.style.width      = l.w;
  fill.style.background = l.c;
  label.textContent     = l.t;
  label.style.color     = l.c;
}

document.getElementById('resetForm').addEventListener('submit', function () {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.classList.add('loading');
});
</script>
</body>
</html>
