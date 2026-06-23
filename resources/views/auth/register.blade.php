<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account — TindaHub</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

@vite([
        'resources/css/register.css',
        'resources/js/register.js'
    ])

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

    <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
        @csrf

        <!-- STEP 1: Account Info -->
        <div id="panelStep1">
          <div class="auth-title">Create your account</div>
          <div class="auth-sub">Already have one? <a href="{{ route('login') }}">Sign in</a></div>

          <div class="form-row">
            <div class="form-group">
              <label for="first_name">First name</label>
              <input type="text" id="first_name" name="first_name" class="form-input" placeholder="Maria" value="{{ old('first_name') }}">
              @error('first_name')
                <div class="field-error show">{{ $message }}</div>
              @enderror
              <div class="field-error" id="err-firstName">Enter your first name.</div>
            </div>
            <div class="form-group">
              <label for="last_name">Last name</label>
              <input type="text" id="last_name" name="last_name" class="form-input" placeholder="Santos" value="{{ old('last_name') }}">
              @error('last_name')
                <div class="field-error show">{{ $message }}</div>
              @enderror
              <div class="field-error" id="err-lastName">Enter your last name.</div>
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="maria@example.com" value="{{ old('email') }}">
            @error('email')
              <div class="field-error show">{{ $message }}</div>
            @enderror
            <div class="field-error" id="err-email">Enter a valid email.</div>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="pw-wrap">
              <input type="password" id="password" name="password" class="form-input" placeholder="At least 8 characters" oninput="checkStrength(this.value)">
              <button class="pw-toggle" type="button" onclick="togglePw('password',this)">👁</button>
            </div>
            <div class="pw-strength">
              <div class="pw-strength-bar"><div class="pw-strength-fill" id="strengthFill"></div></div>
              <div class="pw-strength-label" id="strengthLabel">Enter a password</div>
            </div>
            @error('password')
              <div class="field-error show">{{ $message }}</div>
            @enderror
            <div class="field-error" id="err-password">Password must be at least 8 characters.</div>
          </div>

          <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <div class="pw-wrap">
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Repeat your password" oninput="checkStrength(document.getElementById('password').value)">
              <button class="pw-toggle" type="button" onclick="togglePw('password_confirmation',this)">👁</button>
            </div>
            @error('password_confirmation')
              <div class="field-error show">{{ $message }}</div>
            @enderror
            <div class="field-error" id="err-password_confirmation">Passwords must match.</div>
          </div>

          <div class="checkbox-wrap">
            <input type="checkbox" id="agreeTerms" {{ old('agreeTerms') ? 'checked' : '' }}>
            <label for="agreeTerms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
          </div>

          <button type="button" class="btn-submit" id="btnStep1" onclick="goStep2()">
            Continue to store setup
            <div class="btn-loader"><div class="spinner"></div></div>
          </button>
        </div>

        <!-- STEP 2: Store Info -->
        <div id="panelStep2" style="display:none">
          <div class="auth-title">Set up your store</div>
          <div class="auth-sub">Tell us a bit about your sari-sari store.</div>

          <div class="form-group">
            <label for="store_name">Store name</label>
            <input type="text" id="store_name" name="store_name" class="form-input" placeholder="e.g. Aling Maria's Store" value="{{ old('store_name') }}">
            @error('store_name')
              <div class="field-error show">{{ $message }}</div>
            @enderror
            <div class="field-error" id="err-storeName">Enter your store name.</div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="store_city">City / Municipality</label>
              <input type="text" id="store_city" name="store_city" class="form-input" placeholder="Quezon City" value="{{ old('store_city') }}">
            </div>
            <div class="form-group">
              <label for="store_province">Province</label>
              <input type="text" id="store_province" name="store_province" class="form-input" placeholder="Metro Manila" value="{{ old('store_province') }}">
            </div>
          </div>

          <div class="form-group">
            <label>Your role in the store</label>
            <div class="role-grid">
              <div class="role-card {{ old('role') === 'owner' || !old('role') ? 'selected' : '' }}" onclick="selectRole(this,'owner')">
                <input type="radio" name="role" value="owner" {{ old('role') === 'owner' || !old('role') ? 'checked' : '' }}>
                <div class="role-icon">🏪</div>
                <div class="role-name">Owner</div>
                <div class="role-desc">Full access to all features</div>
              </div>
              <div class="role-card {{ old('role') === 'manager' ? 'selected' : '' }}" onclick="selectRole(this,'manager')">
                <input type="radio" name="role" value="manager" {{ old('role') === 'manager' ? 'checked' : '' }}>
                <div class="role-icon">👔</div>
                <div class="role-name">Manager</div>
                <div class="role-desc">Manage inventory & reports</div>
              </div>
            </div>
            @error('role')
              <div class="field-error show">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="plan">Choose a plan</label>
            <select id="plan" name="plan" class="form-input">
              <option value="free" {{ old('plan') === 'free' ? 'selected' : '' }}>Starter — Free forever</option>
              <option value="pro" {{ old('plan') === 'pro' || !old('plan') ? 'selected' : '' }}>Pro — ₱499/month (60 days free)</option>
              <option value="business" {{ old('plan') === 'business' ? 'selected' : '' }}>Business — ₱999/month (60 days free)</option>
            </select>
          </div>

          <div style="display:flex;gap:.75rem">
            <button type="button" class="btn-submit" style="background:white;color:var(--ink);border:1.5px solid var(--border);flex:0 0 auto;width:auto;padding:13px 20px" onclick="backStep1()">← Back</button>
            <button type="button" class="btn-submit" style="flex:1" id="btnStep2" onclick="finishRegister(event)">
              Create my store
              <div class="btn-loader"><div class="spinner"></div></div>
            </button>
          </div>
        </div>

        <!-- STEP 3: Success -->
        <div id="panelStep3" style="display:none;text-align:center;padding:1rem 0">
          <div style="font-size:56px;margin-bottom:1rem;animation:pop .4s ease">🎉</div>
          <div class="auth-title" style="text-align:center">Registration Complete!</div>
          <p style="color:var(--text2);font-size:14px;margin:1rem 0 1.75rem;line-height:1.7">Your TindaHub account and store have been created successfully. We've sent a verification email to <strong id="confirmedEmail"></strong></p>
          <a href="{{ route('login') }}" class="btn-submit" style="display:block;text-decoration:none;text-align:center">Sign In to Your Account →</a>
          <p style="font-size:12px;color:var(--text3);margin-top:1rem">Please verify your email first, then sign in with your credentials</p>
        </div>

    </form>

    <script>
      // Handle Laravel validation errors and show on appropriate step
      document.addEventListener('DOMContentLoaded', function() {
        const errors = @json($errors->messages());
        const step1Fields = ['first_name', 'last_name', 'email', 'password', 'password_confirmation', 'agreeTerms'];
        const step2Fields = ['store_name', 'store_city', 'store_province', 'role', 'plan'];
        
        let hasStep1Errors = false;
        let hasStep2Errors = false;
        
        // Categorize errors
        for (const field in errors) {
          if (step1Fields.includes(field)) hasStep1Errors = true;
          if (step2Fields.includes(field)) hasStep2Errors = true;
        }
        
        // Show appropriate step with errors
        if (hasStep1Errors) {
          window.setStep(1);
          // Display individual field errors
          for (const field in errors) {
            let errorId = field.replace(/_/g, '-');
            if (field === 'password_confirmation') errorId = 'password-confirmation';
            const mappedId = `err-${errorId}`;
            errors[field].forEach(msg => {
              window.showError(mappedId, msg);
            });
          }
        } else if (hasStep2Errors) {
          window.setStep(2);
          // Display individual field errors
          for (const field in errors) {
            let errorId = field.replace(/_/g, '-');
            const mappedId = `err-${errorId}`;
            errors[field].forEach(msg => {
              window.showError(mappedId, msg);
            });
          }
        }
        
        // Show general errors in alert box
        if (Object.keys(errors).length > 0 && !hasStep1Errors && !hasStep2Errors) {
          const alertBox = document.getElementById('alertBox');
          const alertMsg = document.getElementById('alertMsg');
          if (alertBox && alertMsg) {
            alertBox.classList.add('show');
            alertMsg.textContent = 'Registration failed. Please check your information and try again.';
          }
        }
      });
    </script>

  </div>
</div>

</body>
</html>