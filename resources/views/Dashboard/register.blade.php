<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account — TindaHub</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--ink:#0e0d0b;--paper:#faf8f4;--warm:#f5f0e8;--accent:#e8521a;--accent2:#2d6a4f;--border:rgba(14,13,11,0.12);--text2:#5c5852;--text3:#9c9890;--r:10px;--green:#1d9e75;--red:#d94040}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--ink);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(var(--border) 1px,transparent 1px),linear-gradient(90deg,var(--border) 1px,transparent 1px);background-size:48px 48px;opacity:.4;pointer-events:none}

.auth-wrap{width:100%;max-width:480px;position:relative;z-index:1}
.auth-logo{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--ink);text-decoration:none;display:block;text-align:center;margin-bottom:2rem}
.auth-logo span{color:var(--accent)}
.auth-card{background:white;border:1px solid var(--border);border-radius:16px;padding:2.5rem;box-shadow:0 4px 32px rgba(14,13,11,.06)}
.auth-title{font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:700;margin-bottom:.4rem}
.auth-sub{font-size:14px;color:var(--text2);margin-bottom:2rem}
.auth-sub a{color:var(--accent);text-decoration:none}

/* Form */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.form-group{margin-bottom:1.25rem}
label{display:block;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:6px}
.form-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r);font-size:14px;color:var(--ink);background:var(--paper);font-family:'DM Sans',sans-serif;transition:border-color .2s,box-shadow .2s;outline:none}
.form-input:focus{border-color:var(--ink);box-shadow:0 0 0 3px rgba(14,13,11,.06)}
.form-input.error{border-color:var(--red);background:#fff8f8}
.form-input.success{border-color:var(--green)}
.field-error{font-size:12px;color:var(--red);margin-top:4px;display:none}
.field-error.show{display:block}

/* Password toggle */
.pw-wrap{position:relative}
.pw-wrap .form-input{padding-right:40px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3);font-size:16px;padding:2px;line-height:1}

/* Strength bar */
.pw-strength{margin-top:6px}
.pw-strength-bar{height:3px;background:var(--border);border-radius:2px;overflow:hidden;margin-bottom:4px}
.pw-strength-fill{height:100%;border-radius:2px;transition:width .3s,background .3s;width:0%}
.pw-strength-label{font-size:11px;color:var(--text3)}

/* Role selector */
.role-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.25rem}
.role-card{border:1.5px solid var(--border);border-radius:var(--r);padding:1rem;cursor:pointer;transition:all .2s;position:relative}
.role-card:hover{border-color:var(--ink);background:var(--paper)}
.role-card.selected{border-color:var(--ink);background:var(--paper)}
.role-card.selected::after{content:'✓';position:absolute;top:8px;right:10px;font-size:12px;color:var(--accent);font-weight:700}
.role-card input{display:none}
.role-icon{font-size:20px;margin-bottom:.4rem}
.role-name{font-size:13px;font-weight:500}
.role-desc{font-size:11px;color:var(--text3);margin-top:2px}

/* Submit btn */
.btn-submit{width:100%;padding:13px;background:var(--ink);color:white;border:none;border-radius:var(--r);font-size:15px;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s;position:relative;overflow:hidden;margin-top:.5rem}
.btn-submit:hover{background:var(--accent);transform:translateY(-1px)}
.btn-submit:disabled{opacity:.6;cursor:not-allowed;transform:none}
.btn-submit .btn-loader{display:none;position:absolute;inset:0;background:var(--ink);align-items:center;justify-content:center}
.btn-submit.loading .btn-loader{display:flex}
.spinner{width:20px;height:20px;border:2px solid rgba(255,255,255,.3);border-top-color:white;border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

/* Divider */
.divider{display:flex;align-items:center;gap:.75rem;margin:1.25rem 0;color:var(--text3);font-size:12px}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}

/* Alert */
.alert{padding:.75rem 1rem;border-radius:var(--r);font-size:13px;margin-bottom:1.25rem;display:none;align-items:flex-start;gap:.6rem}
.alert.show{display:flex}
.alert-error{background:#fff1f1;border:1px solid #f7c1c1;color:#a32d2d}
.alert-success{background:#e1f5ee;border:1px solid #9fe1cb;color:#0f6e56}

/* Progress steps */
.steps{display:flex;align-items:center;margin-bottom:2rem;gap:0}
.step-item{flex:1;text-align:center;position:relative}
.step-circle{width:28px;height:28px;border-radius:50%;border:2px solid var(--border);background:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;margin:0 auto 6px;transition:all .3s;color:var(--text3)}
.step-item.active .step-circle{border-color:var(--ink);background:var(--ink);color:white}
.step-item.done .step-circle{border-color:var(--green);background:var(--green);color:white}
.step-item::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--border);z-index:0}
.step-item:last-child::after{display:none}
.step-item.done::after{background:var(--green)}
.step-circle{position:relative;z-index:1}
.step-label{font-size:11px;color:var(--text3)}
.step-item.active .step-label{color:var(--ink);font-weight:500}

/* T&C */
.checkbox-wrap{display:flex;align-items:flex-start;gap:.75rem;margin-bottom:1.5rem;cursor:pointer}
.checkbox-wrap input[type=checkbox]{width:16px;height:16px;margin-top:2px;accent-color:var(--ink);flex-shrink:0}
.checkbox-wrap label{font-size:13px;color:var(--text2);cursor:pointer}
.checkbox-wrap a{color:var(--accent);text-decoration:none}

@media(max-width:480px){.form-row{grid-template-columns:1fr}.auth-card{padding:1.75rem}}
</style>
</head>
<body>

<div class="auth-wrap">
  <a href="{{ route('welcome') }}" class="auth-logo">Tinda<span>Hub</span></a>

  <div class="auth-card">
    <!-- Steps -->
    <div class="steps" id="progressSteps">
      <div class="step-item active" id="step1">
        <div class="step-circle">1</div>
        <div class="step-label">Account</div>
      </div>
      <div class="step-item" id="step2">
        <div class="step-circle">2</div>
        <div class="step-label">Store</div>
      </div>
      <div class="step-item" id="step3">
        <div class="step-circle">3</div>
        <div class="step-label">Done</div>
      </div>
    </div>

    <div class="alert alert-error" id="alertBox">
      <span>⚠</span> <span id="alertMsg">Something went wrong.</span>
    </div>

    <!-- STEP 1: Account Info -->
    <div id="panelStep1">
      <div class="auth-title">Create your account</div>
      <div class="auth-sub">Already have one? <a href="{{ route('login') }}">Sign in</a></div>

      <div class="form-row">
        <div class="form-group">
          <label for="firstName">First name</label>
          <input type="text" id="firstName" class="form-input" placeholder="Maria" autocomplete="given-name">
          <div class="field-error" id="err-firstName">Enter your first name.</div>
        </div>
        <div class="form-group">
          <label for="lastName">Last name</label>
          <input type="text" id="lastName" class="form-input" placeholder="Santos" autocomplete="family-name">
          <div class="field-error" id="err-lastName">Enter your last name.</div>
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" class="form-input" placeholder="maria@example.com" autocomplete="email">
        <div class="field-error" id="err-email">Enter a valid email.</div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="pw-wrap">
          <input type="password" id="password" class="form-input" placeholder="At least 8 characters" autocomplete="new-password" oninput="checkStrength(this.value)">
          <button class="pw-toggle" type="button" onclick="togglePw('password',this)">👁</button>
        </div>
        <div class="pw-strength">
          <div class="pw-strength-bar"><div class="pw-strength-fill" id="strengthFill"></div></div>
          <div class="pw-strength-label" id="strengthLabel">Enter a password</div>
        </div>
        <div class="field-error" id="err-password">Password must be at least 8 characters.</div>
      </div>

      <div class="checkbox-wrap">
        <input type="checkbox" id="agreeTerms">
        <label for="agreeTerms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
      </div>

      <button class="btn-submit" id="btnStep1" onclick="goStep2()">
        Continue to store setup
        <div class="btn-loader"><div class="spinner"></div></div>
      </button>
    </div>

    <!-- STEP 2: Store Info -->
    <div id="panelStep2" style="display:none">
      <div class="auth-title">Set up your store</div>
      <div class="auth-sub">Tell us a bit about your sari-sari store.</div>

      <div class="form-group">
        <label for="storeName">Store name</label>
        <input type="text" id="storeName" class="form-input" placeholder="e.g. Aling Maria's Store">
        <div class="field-error" id="err-storeName">Enter your store name.</div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="storeCity">City / Municipality</label>
          <input type="text" id="storeCity" class="form-input" placeholder="Quezon City">
        </div>
        <div class="form-group">
          <label for="storeProvince">Province</label>
          <input type="text" id="storeProvince" class="form-input" placeholder="Metro Manila">
        </div>
      </div>

      <div class="form-group">
        <label>Your role in the store</label>
        <div class="role-grid">
          <div class="role-card selected" onclick="selectRole(this,'owner')">
            <input type="radio" name="role" value="owner" checked>
            <div class="role-icon">🏪</div>
            <div class="role-name">Owner</div>
            <div class="role-desc">Full access to all features</div>
          </div>
          <div class="role-card" onclick="selectRole(this,'manager')">
            <input type="radio" name="role" value="manager">
            <div class="role-icon">👔</div>
            <div class="role-name">Manager</div>
            <div class="role-desc">Manage inventory & reports</div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="planSelect">Choose a plan</label>
        <select id="planSelect" class="form-input">
          <option value="free">Starter — Free forever</option>
          <option value="pro" selected>Pro — ₱499/month (60 days free)</option>
          <option value="business">Business — ₱999/month (60 days free)</option>
        </select>
      </div>

      <div style="display:flex;gap:.75rem">
        <button class="btn-submit" style="background:white;color:var(--ink);border:1.5px solid var(--border);flex:0 0 auto;width:auto;padding:13px 20px" onclick="backStep1()">← Back</button>
        <button class="btn-submit" style="flex:1" id="btnStep2" onclick="finishRegister()">
          Create my store
          <div class="btn-loader"><div class="spinner"></div></div>
        </button>
      </div>
    </div>

    <!-- STEP 3: Success -->
    <div id="panelStep3" style="display:none;text-align:center;padding:1rem 0">
      <div style="font-size:56px;margin-bottom:1rem;animation:pop .4s ease">🎉</div>
      <div class="auth-title" style="text-align:center">You're all set!</div>
      <p style="color:var(--text2);font-size:14px;margin:1rem 0 1.75rem;line-height:1.7">Your TindaHub account and store are ready. We've sent a verification email to <strong id="confirmedEmail"></strong></p>
      <a href="{{ route('welcome') }}" class="btn-submit" style="display:block;text-decoration:none;text-align:center">Go to my dashboard →</a>
      <p style="font-size:12px;color:var(--text3);margin-top:1rem">Check your inbox to verify your email (or skip for now)</p>
    </div>

  </div>
</div>

<script>
function togglePw(id, btn) {
  const input = document.getElementById(id);
  if (input.type === 'password') { input.type = 'text'; btn.textContent = '🙈'; }
  else { input.type = 'password'; btn.textContent = '👁'; }
}

function checkStrength(pw) {
  const fill = document.getElementById('strengthFill');
  const label = document.getElementById('strengthLabel');
  if (!pw) { fill.style.width='0%'; label.textContent='Enter a password'; label.style.color='var(--text3)'; return; }
  let score = 0;
  if (pw.length >= 8) score++;
  if (/[A-Z]/.test(pw)) score++;
  if (/[0-9]/.test(pw)) score++;
  if (/[^A-Za-z0-9]/.test(pw)) score++;
  const levels = [
    {w:'20%', c:'#e24b4a', t:'Too weak'},
    {w:'40%', c:'#e24b4a', t:'Weak'},
    {w:'65%', c:'#ef9f27', t:'Fair'},
    {w:'85%', c:'#1d9e75', t:'Strong'},
    {w:'100%',c:'#1d9e75', t:'Very strong'}
  ];
  const l = levels[score] || levels[0];
  fill.style.width = l.w; fill.style.background = l.c;
  label.textContent = l.t; label.style.color = l.c;
}

function selectRole(card, val) {
  document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');
}

function showError(id, msg) {
  const el = document.getElementById(id);
  const inp = document.getElementById(id.replace('err-',''));
  if (el) { el.textContent = msg || el.textContent; el.classList.add('show'); }
  if (inp) inp.classList.add('error');
}
function clearErrors() {
  document.querySelectorAll('.field-error').forEach(e => e.classList.remove('show'));
  document.querySelectorAll('.form-input').forEach(e => e.classList.remove('error'));
  document.getElementById('alertBox').classList.remove('show');
}

function setStep(n) {
  [1,2,3].forEach(i => {
    const s = document.getElementById('step'+i);
    s.classList.remove('active','done');
    if (i < n) s.classList.add('done');
    if (i === n) s.classList.add('active');
  });
  document.querySelectorAll('[id^="panelStep"]').forEach(p => p.style.display='none');
  document.getElementById('panelStep'+n).style.display='block';
}

function goStep2() {
  clearErrors();
  let ok = true;
  const fn = document.getElementById('firstName').value.trim();
  const ln = document.getElementById('lastName').value.trim();
  const em = document.getElementById('email').value.trim();
  const pw = document.getElementById('password').value;
  const terms = document.getElementById('agreeTerms').checked;

  if (!fn) { showError('err-firstName'); ok=false; }
  if (!ln) { showError('err-lastName'); ok=false; }
  if (!em || !/^[^@]+@[^@]+\.[^@]+$/.test(em)) { showError('err-email','Enter a valid email address.'); ok=false; }
  if (pw.length < 8) { showError('err-password'); ok=false; }
  if (!terms) { const a=document.getElementById('alertBox'); a.classList.add('show'); document.getElementById('alertMsg').textContent='Please accept the Terms of Service to continue.'; ok=false; }
  if (ok) setStep(2);
}

function backStep1() { setStep(1); }

function finishRegister() {
  clearErrors();
  const sn = document.getElementById('storeName').value.trim();
  if (!sn) { showError('err-storeName','Enter your store name.'); return; }

  const btn = document.getElementById('btnStep2');
  btn.classList.add('loading'); btn.disabled = true;

  // Simulate API call
  setTimeout(() => {
    btn.classList.remove('loading'); btn.disabled = false;
    const email = document.getElementById('email').value;
    document.getElementById('confirmedEmail').textContent = email;

    // Persist session
    const user = {
      name: document.getElementById('firstName').value + ' ' + document.getElementById('lastName').value,
      email: email,
      storeName: sn,
      role: 'owner',
      plan: document.getElementById('planSelect').value,
      emailVerified: false,
      onboardingCompleted: false
    };
    sessionStorage.setItem('tindahub_user', JSON.stringify(user));
    setStep(3);
  }, 1600);
}
</script>
</body>
</html>