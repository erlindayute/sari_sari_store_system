<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SariSari Store System</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;1,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--ink:#0e0d0b;--paper:#faf8f4;--warm:#f5f0e8;--accent:#e8521a;--border:rgba(14,13,11,0.12);--text2:#5c5852;--text3:#9c9890;--r:10px;--green:#1d9e75;--red:#d94040}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--ink);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(var(--border) 1px,transparent 1px),linear-gradient(90deg,var(--border) 1px,transparent 1px);background-size:48px 48px;opacity:.4;pointer-events:none}
.auth-wrap{width:100%;max-width:420px;position:relative;z-index:1}
.auth-logo{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--ink);text-decoration:none;display:block;text-align:center;margin-bottom:2rem}
.auth-logo span{color:var(--accent)}
.auth-card{background:white;border:1px solid var(--border);border-radius:16px;padding:2.5rem;box-shadow:0 4px 32px rgba(14,13,11,.06)}
.auth-title{font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:700;margin-bottom:.4rem}
.auth-sub{font-size:14px;color:var(--text2);margin-bottom:2rem}
.auth-sub a{color:var(--accent);text-decoration:none}
.form-group{margin-bottom:1.25rem}
label{display:block;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:6px}
.form-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r);font-size:14px;color:var(--ink);background:var(--paper);font-family:'DM Sans',sans-serif;transition:border-color .2s,box-shadow .2s;outline:none}
.form-input:focus{border-color:var(--ink);box-shadow:0 0 0 3px rgba(14,13,11,.06)}
.form-input.error{border-color:var(--red)}
.pw-wrap{position:relative}
.pw-wrap .form-input{padding-right:40px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3);font-size:16px;padding:2px}
.forgot{font-size:13px;color:var(--accent);text-decoration:none;display:block;text-align:right;margin-top:-1rem;margin-bottom:1.25rem}
.btn-submit{width:100%;padding:13px;background:var(--ink);color:white;border:none;border-radius:var(--r);font-size:15px;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s;position:relative;overflow:hidden;margin-top:.5rem}
.btn-submit:hover{background:var(--accent)}
.btn-submit:disabled{opacity:.6;cursor:not-allowed}
.btn-loader{display:none;position:absolute;inset:0;background:var(--ink);align-items:center;justify-content:center}
.btn-submit.loading .btn-loader{display:flex}
.spinner{width:20px;height:20px;border:2px solid rgba(255,255,255,.3);border-top-color:white;border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
.alert{padding:.75rem 1rem;border-radius:var(--r);font-size:13px;margin-bottom:1.25rem;display:none;align-items:flex-start;gap:.6rem}
.alert.show{display:flex}
.alert-error{background:#fff1f1;border:1px solid #f7c1c1;color:#a32d2d}
.alert-success{background:#e1f5ee;border:1px solid #9fe1cb;color:#0f6e56}
.remember-wrap{display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem}
.remember-wrap input{accent-color:var(--ink)}
.remember-wrap label{font-size:13px;color:var(--text2);cursor:pointer}
.divider{display:flex;align-items:center;gap:.75rem;margin:1.25rem 0;color:var(--text3);font-size:12px}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}
.demo-btn{width:100%;padding:12px;background:var(--warm);border:1.5px solid var(--border);border-radius:var(--r);font-size:14px;cursor:pointer;font-family:'DM Sans',sans-serif;color:var(--ink);transition:all .2s}
.demo-btn:hover{border-color:var(--ink)}
</style>
</head>
<body>
<div class="auth-wrap">
  <a href="{{ route('welcome') }}" class="auth-logo">Tinda<span>Hub</span></a>
  <div class="auth-card">
    <div class="auth-title">Welcome back</div>
    <div class="auth-sub">Don't have an account? <a href="{{ route('register') }}">Sign up free</a></div>
 
    <div class="alert alert-error" id="alertError"><span>⚠</span><span id="errMsg">Invalid email or password.</span></div>
    <div class="alert alert-success" id="alertSuccess"><span>✓</span><span id="successMsg">Password reset! Please sign in.</span></div>
 
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" id="email" class="form-input" placeholder="maria@example.com" autocomplete="email">
    </div>
 
    <div class="form-group">
      <label for="password">Password</label>
      <div class="pw-wrap">
        <input type="password" id="password" class="form-input" placeholder="Your password" autocomplete="current-password" onkeydown="if(event.key==='Enter')doLogin()">
        <button class="pw-toggle" type="button" onclick="togglePw()">👁</button>
      </div>
    </div>
 
    <a href="" class="forgot">Forgot password?</a>
 
    <div class="remember-wrap">
      <input type="checkbox" id="rememberMe" checked>
      <label for="rememberMe">Keep me signed in</label>
    </div>
 
    <button class="btn-submit" id="loginBtn" onclick="doLogin()">
      Sign in
      <div class="btn-loader"><div class="spinner"></div></div>
    </button>
 
    <div class="divider">or try a demo account</div>
    <button class="demo-btn" onclick="demoLogin()">🏪 Sign in as Demo Store Owner</button>
  </div>
</div>
 
<script>
function togglePw() {
  const inp = document.getElementById('password');
  inp.type = inp.type === 'password' ? 'text' : 'password';
}
 
function showError(msg) {
  document.getElementById('errMsg').textContent = msg;
  document.getElementById('alertError').classList.add('show');
  document.getElementById('alertSuccess').classList.remove('show');
}
 
function doLogin() {
  const email = document.getElementById('email').value.trim();
  const pw = document.getElementById('password').value;
  document.getElementById('alertError').classList.remove('show');
 
  if (!email || !/^[^@]+@[^@]+\.[^@]+$/.test(email)) { showError('Enter a valid email address.'); return; }
  if (!pw) { showError('Please enter your password.'); return; }
 
  const btn = document.getElementById('loginBtn');
  btn.classList.add('loading'); btn.disabled = true;
 
  setTimeout(() => {
    btn.classList.remove('loading'); btn.disabled = false;
    // Simulate auth — accept any non-empty credentials for demo
    const user = {
      name: 'Maria Santos',
      email: email,
      storeName: "Aling Maria's Store",
      role: 'owner',
      plan: 'pro',
      emailVerified: true,
      onboardingCompleted: true
    };
    sessionStorage.setItem('tindahub_user', JSON.stringify(user));
    window.location.href = '{{ route("inventory.index") }}';
  }, 1200);
}
 
function demoLogin() {
  const user = {
    name: 'Demo Owner',
    email: 'demo@tindahub.app',
    storeName: "Demo Sari-Sari Store",
    role: 'owner',
    plan: 'pro',
    emailVerified: true,
    onboardingCompleted: true
  };
  sessionStorage.setItem('tindahub_user', JSON.stringify(user));
  window.location.href = '{{ route("inventory.index") }}';
}
 
// Show success message if redirected from reset
if (location.search.includes('reset=1')) {
  document.getElementById('alertSuccess').classList.add('show');
}
</script>
</body>
</html>