<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SariSari Store System</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;1,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}

:root {
  --orange:#f97316; --orange-deep:#ea580c;
  --orange-light:#fff7ed; --orange-pale:#ffedd5;
  --brown:#431407; --cream:#fffbf5;
  --stone:#78716c; --stone-light:#f5f5f4;
}

body { min-height:100vh; background:var(--cream); font-family:'Nunito',sans-serif; overflow-x:hidden; }

.bg-shapes { position:fixed; inset:0; pointer-events:none; z-index:0; overflow:hidden; }
.shape { position:absolute; border-radius:50%; opacity:.55; }
.shape-1 { width:700px; height:700px; background:radial-gradient(circle,#fed7aa 0%,transparent 70%); top:-200px; right:-180px; animation:drift 18s ease-in-out infinite alternate; }
.shape-2 { width:500px; height:500px; background:radial-gradient(circle,#fde68a55 0%,transparent 70%); bottom:-100px; left:-120px; animation:drift 22s ease-in-out infinite alternate-reverse; }
.shape-3 { width:320px; height:320px; background:radial-gradient(circle,#fdba7444 0%,transparent 70%); top:40%; left:30%; animation:drift 14s ease-in-out infinite alternate; }
.shape-4 { width:200px; height:200px; background:radial-gradient(circle,#fb923c33 0%,transparent 70%); top:15%; left:10%; animation:drift 20s ease-in-out infinite alternate-reverse; }
@keyframes drift { from{transform:translate(0,0) scale(1);} to{transform:translate(30px,20px) scale(1.06);} }

/* Navbar */
.navbar { position:sticky; top:0; z-index:100; background:rgba(255,251,245,.88); backdrop-filter:blur(12px); border-bottom:1px solid rgba(249,115,22,.12); }
.nav-inner { max-width:1100px; margin:0 auto; padding:0 24px; height:64px; display:flex; align-items:center; justify-content:space-between; }
.nav-logo { display:flex; align-items:center; gap:12px; text-decoration:none; }
.logo-icon { width:44px; height:44px; background:linear-gradient(135deg,var(--orange),var(--orange-deep)); border-radius:12px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(249,115,22,.35); flex-shrink:0; }
.logo-text { display:flex; flex-direction:column; line-height:1.1; }
.logo-primary { font-family:'Instrument Serif',Georgia,serif; font-size:1.2rem; color:var(--brown); }
.logo-secondary { font-size:10px; font-weight:700; color:var(--stone); letter-spacing:.08em; text-transform:uppercase; }
.nav-actions { display:flex; align-items:center; gap:10px; }
.btn-ghost { padding:8px 18px; border-radius:99px; font-size:14px; font-weight:700; color:var(--stone); text-decoration:none; transition:color .15s,background .15s; }
.btn-ghost:hover { color:var(--orange-deep); background:var(--orange-pale); }
.btn-solid { padding:8px 20px; border-radius:99px; background:var(--orange); color:#fff; font-size:14px; font-weight:700; text-decoration:none; box-shadow:0 3px 12px rgba(249,115,22,.3); transition:background .2s,transform .1s; }
.btn-solid:hover { background:var(--orange-deep); transform:translateY(-1px); }

/* Hero */
.hero { position:relative; z-index:1; max-width:860px; margin:0 auto; padding:80px 24px 48px; text-align:center; }
.hero-inner { display:flex; flex-direction:column; align-items:center; }

.hero-badge { display:inline-flex; align-items:center; gap:8px; background:var(--orange-pale); border:1px solid rgba(249,115,22,.3); border-radius:99px; padding:6px 16px; font-size:12px; font-weight:700; color:var(--orange-deep); margin-bottom:28px; animation:fadeUp .5s ease both; }
.badge-dot { width:7px; height:7px; border-radius:50%; background:var(--orange); box-shadow:0 0 0 3px rgba(249,115,22,.25); animation:pulse 2s ease infinite; }
@keyframes pulse { 0%,100%{box-shadow:0 0 0 3px rgba(249,115,22,.25);} 50%{box-shadow:0 0 0 6px rgba(249,115,22,.1);} }

.big-icon-wrap { width:100px; height:100px; background:linear-gradient(145deg,var(--orange),var(--orange-deep)); border-radius:28px; display:flex; align-items:center; justify-content:center; box-shadow:0 16px 48px rgba(249,115,22,.4),0 4px 12px rgba(249,115,22,.25); margin:0 auto 32px; animation:fadeUp .5s .05s ease both; transition:transform .3s; }
.big-icon-wrap:hover { transform:scale(1.04) rotate(-2deg); }

.hero-title { font-family:'Instrument Serif',Georgia,serif; font-size:clamp(2rem,5vw,3.2rem); font-weight:400; line-height:1.18; color:#1c1917; margin-bottom:20px; animation:fadeUp .5s .1s ease both; }
.hero-title em { font-style:italic; color:var(--orange); }
.hero-sub { font-size:1.05rem; color:var(--stone); line-height:1.75; max-width:520px; margin-bottom:36px; animation:fadeUp .5s .15s ease both; }

.hero-cta { display:flex; align-items:center; gap:14px; flex-wrap:wrap; justify-content:center; margin-bottom:16px; animation:fadeUp .5s .2s ease both; }
.cta-primary { display:inline-flex; align-items:center; gap:8px; padding:14px 28px; background:var(--orange); color:#fff; border-radius:14px; font-size:15px; font-weight:800; text-decoration:none; box-shadow:0 8px 28px rgba(249,115,22,.4); transition:background .2s,transform .15s; }
.cta-primary:hover { background:var(--orange-deep); transform:translateY(-2px); }
.cta-secondary { display:inline-flex; align-items:center; gap:6px; padding:14px 24px; background:transparent; border:2px solid rgba(249,115,22,.3); color:var(--orange-deep); border-radius:14px; font-size:15px; font-weight:700; text-decoration:none; transition:border-color .2s,background .2s,transform .15s; }
.cta-secondary:hover { border-color:var(--orange); background:var(--orange-pale); transform:translateY(-2px); }
.hero-note { font-size:12px; color:#a8a29e; margin-top:4px; animation:fadeUp .5s .25s ease both; }

/* Features */
.features { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; margin-top:56px; width:100%; }
.feature-card { background:rgba(255,255,255,.75); border:1px solid rgba(249,115,22,.12); border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:14px; backdrop-filter:blur(6px); opacity:0; animation:fadeUp .5s ease forwards; transition:transform .2s,box-shadow .2s,border-color .2s; }
.feature-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(249,115,22,.12); border-color:rgba(249,115,22,.3); }
.feature-icon { font-size:26px; line-height:1; flex-shrink:0; }
.feature-text { display:flex; flex-direction:column; gap:2px; }
.feature-text strong { font-size:14px; font-weight:700; color:#1c1917; }
.feature-text span { font-size:12px; color:var(--stone); line-height:1.4; }

/* Auth section */
.auth-section { position:relative; z-index:1; padding:16px 24px 80px; max-width:860px; margin:0 auto; }
.auth-cards { display:flex; align-items:stretch; background:#fff; border:1px solid #e7e5e4; border-radius:24px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,.07); animation:fadeUp .6s .3s ease both; }
.auth-card { flex:1; padding:40px 36px; display:flex; flex-direction:column; align-items:flex-start; gap:12px; }
.auth-card-login { background:#fff; }
.auth-card-register { background:var(--orange-light); }
.auth-card-icon { width:52px; height:52px; background:var(--orange-pale); border-radius:14px; color:var(--orange-deep); display:flex; align-items:center; justify-content:center; margin-bottom:4px; }
.register-icon { background:var(--orange); color:#fff; box-shadow:0 6px 18px rgba(249,115,22,.3); }
.auth-card-title { font-family:'Instrument Serif',Georgia,serif; font-size:1.35rem; font-weight:400; color:#1c1917; line-height:1.25; }
.auth-card-desc { font-size:13.5px; color:var(--stone); line-height:1.7; flex:1; }
.auth-card-btn { display:inline-flex; align-items:center; gap:8px; padding:12px 22px; border-radius:10px; font-size:14px; font-weight:700; text-decoration:none; margin-top:4px; transition:transform .15s,box-shadow .2s; }
.auth-card-btn:hover { transform:translateY(-2px); }
.login-btn { background:#1c1917; color:#fff; box-shadow:0 4px 14px rgba(28,25,23,.18); }
.register-btn { background:var(--orange); color:#fff; box-shadow:0 4px 14px rgba(249,115,22,.35); }
.register-btn:hover { background:var(--orange-deep); }

.auth-divider { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:0 4px; gap:8px; flex-shrink:0; }
.auth-divider .divider-line { width:1px; flex:1; background:#e7e5e4; }
.auth-divider span { font-size:11px; font-weight:700; color:#c4b5a5; letter-spacing:.08em; text-transform:uppercase; }

/* Footer */
.footer { position:relative; z-index:1; border-top:1px solid rgba(249,115,22,.1); padding:24px; text-align:center; display:flex; flex-direction:column; align-items:center; gap:8px; }
.footer-logo { display:flex; align-items:center; gap:8px; color:var(--stone); font-size:13px; font-weight:600; }
.footer-icon { color:var(--orange); }
.footer-copy { font-size:12px; color:#a8a29e; }

/* Alert styles */
.alert-success { background:#dcfce7; border:1px solid #22c55e; border-radius:12px; padding:16px; color:#15803d; margin-bottom:24px; display:flex; align-items:center; gap:12px; animation:slideDown .3s ease; }
.alert-success::before { content:'✓'; font-size:1.2rem; font-weight:bold; }
.alert-error { background:#fee2e2; border:1px solid #ef4444; border-radius:12px; padding:16px; color:#991b1b; margin-bottom:24px; display:flex; align-items:center; gap:12px; animation:slideDown .3s ease; }
.alert-error::before { content:'✕'; font-size:1.2rem; font-weight:bold; }

@keyframes fadeUp { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
@keyframes slideDown { from{opacity:0;transform:translateY(-10px);} to{opacity:1;transform:translateY(0);} }

@media(max-width:640px) {
  .btn-ghost{display:none;}
  .auth-cards{flex-direction:column;}
  .auth-divider{flex-direction:row;padding:4px 0;}
  .auth-divider .divider-line{flex:1;height:1px;width:auto;}
  .auth-card{padding:28px 24px;}
  .features{grid-template-columns:1fr 1fr;}
}
</style>
</head>
<body>

<div class="bg-shapes" aria-hidden="true">
  <div class="shape shape-1"></div>
  <div class="shape shape-2"></div>
  <div class="shape shape-3"></div>
  <div class="shape shape-4"></div>
</div>

<!-- Navbar -->
<nav class="navbar">
  <div class="nav-inner">
    <div class="nav-logo">
      <div class="logo-icon">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
          <path d="M4 11 L14 3 L24 11" stroke="white" stroke-width="2" stroke-linejoin="round" fill="none"/>
          <rect x="6" y="11" width="16" height="13" rx="1.5" fill="white" fill-opacity="0.25" stroke="white" stroke-width="1.5"/>
          <rect x="11" y="17" width="6" height="7" rx="1" fill="white"/>
          <rect x="7.5" y="13" width="4" height="3.5" rx="0.8" fill="white" fill-opacity="0.7"/>
          <rect x="16.5" y="13" width="4" height="3.5" rx="0.8" fill="white" fill-opacity="0.7"/>
        </svg>
      </div>
      <div class="logo-text">
        <span class="logo-primary">SariSari</span>
        <span class="logo-secondary">Store System</span>
      </div>
    </div>
    <div class="nav-actions">
      <a href="/dashboard/login" class="btn-ghost">Sign in</a>
      <a href="/dashboard/register" class="btn-ghost">Register</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-badge"><span class="badge-dot"></span>Barangay Edition · Free to use</div>

    <div class="big-icon-wrap">
      <svg width="56" height="56" viewBox="0 0 56 56" fill="none">
        <path d="M8 22 L28 6 L48 22" stroke="white" stroke-width="3.5" stroke-linejoin="round" fill="none"/>
        <rect x="10" y="22" width="36" height="28" rx="3" fill="white" fill-opacity="0.18" stroke="white" stroke-width="2.5"/>
        <rect x="20" y="34" width="16" height="16" rx="2" fill="white"/>
        <rect x="12" y="26" width="10" height="7" rx="1.5" fill="white" fill-opacity="0.75"/>
        <rect x="34" y="26" width="10" height="7" rx="1.5" fill="white" fill-opacity="0.75"/>
      </svg>
    </div>

  <!-- Decorative panel -->
      <p class="deco-sub">Your neighborhood store,<br>powered by smart management.</p>
      <div class="deco-tags">
        <span>Inventory</span>
        <span>Sales</span>
        <span>Reports</span>
        <span>POS</span>
      </div>
    </div>
    <div class="deco-footer">v1.0 · Barangay Edition</div>
    </div>

  <!-- Form panel -->

  <main class="form-panel">
   
    <div class="form-card">

```
  <div class="form-top">
    <div>
      <p class="form-hint">Sign in to your store account</p>
    </div>
  </div>

  <!-- Success alert -->
  @if(session('success'))
    <div class="alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- Error alert -->
  @if(session('error'))
    <div class="alert-error">
      {{ session('error') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert-error">
      <strong>Oops!</strong> Please check the errors below.
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <!-- Email -->
    <div class="field">
      <label for="email">Email address</label>
      <div class="input-wrap">
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="you@example.com"
          autocomplete="email"
        />
      </div>
      @error('email')
        <span class="field-msg">{{ $message }}</span>
      @enderror
    </div>

    <!-- Password -->
    <div class="field">
      <label for="password">Password</label>
      <div class="input-wrap">
        <input
          id="password"
          type="password"
          name="password"
          placeholder="••••••••"
          autocomplete="current-password"
        />
        <button type="button" class="toggle-pass" onclick="togglePass()">
          👁
        </button>
      </div>
      @error('password')
        <span class="field-msg">{{ $message }}</span>
      @enderror
    </div>

    <button type="submit" class="btn-submit">
      Sign in
    </button>

  </form>

  <p class="switch-text">
    Don't have an account yet? <a href="{{ route('register') }}">Please register</a>
  </p>

</div>
```

  </main>

</div>

<script>
function togglePass() {
  const input = document.getElementById('password');
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>