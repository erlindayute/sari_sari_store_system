// ================================
// PASSWORD TOGGLE
// ================================

function togglePw(id, btn) {
    const input = document.getElementById(id);

    if (!input) {
        console.error(`Input with ID "${id}" not found.`);
        return;
    }

    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
        btn.setAttribute('aria-label', 'Hide password');
    } else {
        input.type = 'password';
        btn.textContent = '👁';
        btn.setAttribute('aria-label', 'Show password');
    }
}

// ================================
// LOGIN FORM VALIDATION
// ================================

function validateLoginForm(event) {

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');

    // Remove old errors
    clearErrors();

    let valid = true;

    // Validate Email
    if (!email.value.trim()) {
        showError(email, 'Email is required.');
        valid = false;
    }

    // Validate Password
    if (!password.value.trim()) {
        showError(password, 'Password is required.');
        valid = false;
    }

    // Stop form if invalid
    if (!valid) {
        event.preventDefault();
        return false;
    }

    // Loading State
    if (loginBtn) {
        loginBtn.disabled = true;
        loginBtn.classList.add('loading');
    }

    return true;
}

// ================================
// SHOW FIELD ERROR
// ================================

function showError(input, message) {

    input.classList.add('error');

    let error = input.parentElement.querySelector('.field-error');

    if (!error) {
        error = document.createElement('div');
        error.className = 'field-error';
        input.parentElement.appendChild(error);
    }

    error.textContent = message;
    error.style.display = 'block';
}

// ================================
// CLEAR ERRORS
// ================================

function clearErrors() {

    document.querySelectorAll('.field-error').forEach(el => {
        el.style.display = 'none';
    });

    document.querySelectorAll('.form-input').forEach(el => {
        el.classList.remove('error');
    });
}

// ================================
// AUTO HIDE ALERTS
// ================================

document.addEventListener('DOMContentLoaded', () => {

    const alert = document.querySelector('.alert');

    if (alert) {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    }

});

// ================================
// GLOBAL FUNCTIONS
// ================================

window.togglePw = togglePw;
window.validateLoginForm = validateLoginForm;