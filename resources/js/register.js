// Toggles password visibility in an input field
function togglePw(id, btn) {
    const input = document.getElementById(id);
    if (!input) {
        console.error(`Input with ID "${id}" not found.`);
        return;
    }
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈'; // Show password icon
        btn.setAttribute('aria-label', 'Hide password'); // Accessibility improvement
    } else {
        input.type = 'password';
        btn.textContent = '👁'; // Hide password icon
        btn.setAttribute('aria-label', 'Show password'); // Accessibility improvement
    }
}

// Checks password strength and updates UI feedback
function checkStrength(pwInput) { // Renamed parameter to be more descriptive
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    // Handle both cases: when pwInput is a string value or an element
    const pw = typeof pwInput === 'string' ? pwInput : (pwInput && pwInput.value ? pwInput.value : '');

    if (!fill || !label) {
        console.error('Strength indicator elements not found.');
        return;
    }

    if (!pw) {
        fill.style.width = '0%';
        fill.style.backgroundColor = ''; // Clear background color
        label.textContent = 'Enter a password';
        label.style.color = 'var(--text-muted)';
        return;
    }

    let score = 0;
    // Criteria for password strength
    if (pw.length >= 8) score++;
    if (/[A-Z]/.test(pw)) score++; // Uppercase letter
    if (/[0-9]/.test(pw)) score++; // Number
    if (/[^A-Za-z0-9]/.test(pw)) score++; // Special character

    // Define strength levels
    const levels = [
        { width: '20%', color: '#e24b4a', text: 'Too weak' }, // score 0
        { width: '40%', color: '#e24b4a', text: 'Weak' },     // score 1
        { width: '65%', color: '#ef9f27', text: 'Fair' },     // score 2
        { width: '85%', color: '#1d9e75', text: 'Strong' },   // score 3
        { width: '100%', color: '#1d9e75', text: 'Very strong' } // score 4
    ];

    // Use score directly as index; if score is out of bounds, default to 0
    const l = levels[score] || levels[0];

    fill.style.width = l.width;
    fill.style.backgroundColor = l.color; // Use backgroundColor for clarity
    label.textContent = l.text;
    label.style.color = l.color;
}

// Handles role selection for the user
function selectRole(card, val) { // 'val' parameter isn't used, consider removing if not needed.
    // Ensure 'card' is a DOM element
    if (!card || !card.classList) {
        console.error('Invalid card element passed to selectRole.');
        return;
    }

    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');

    // Optionally update a hidden input or state if 'val' represents the selected role value
    // e.g., document.getElementById('selectedRole').value = val;
}

// Displays an error message for a given input field
function showError(id, msg) {
    const errorEl = document.getElementById(id);
    // Assuming 'id' for the error message div is like 'err-field' and input id is 'field'
    const inputId = id.replace('err-', '');
    const inputEl = document.getElementById(inputId);

    if (errorEl) {
        // Only update textContent if msg is provided, otherwise keep existing message
        errorEl.textContent = msg || errorEl.textContent;
        errorEl.classList.add('show');
    } else {
        console.warn(`Error element with ID "${id}" not found.`);
    }

    if (inputEl) {
        inputEl.classList.add('error');
        inputEl.setAttribute('aria-invalid', 'true'); // Accessibility improvement
        inputEl.setAttribute('aria-describedby', id); // Link input to error message
    } else {
        console.warn(`Input element with ID "${inputId}" not found for error display.`);
    }
}

// Clears all displayed error messages and error styles
function clearErrors() {
    document.querySelectorAll('.field-error.show').forEach(e => { // Only clear visible errors
        e.classList.remove('show');
        e.textContent = ''; // Clear message for reusability
    });
    document.querySelectorAll('.form-input.error').forEach(e => {
        e.classList.remove('error');
        e.removeAttribute('aria-invalid'); // Accessibility improvement
        e.removeAttribute('aria-describedby'); // Accessibility improvement
    });
    const alertBox = document.getElementById('alertBox');
    if (alertBox) {
        alertBox.classList.remove('show');
        const alertMsg = document.getElementById('alertMsg');
        if (alertMsg) alertMsg.textContent = ''; // Clear alert message too
    }
}

// Sets the active step in a multi-step form
function setStep(n) {
    // Array of step numbers (assuming your steps are 1, 2, 3)
    const allSteps = [1, 2, 3];
    allSteps.forEach(i => {
        const stepIndicator = document.getElementById('step' + i);
        if (stepIndicator) {
            stepIndicator.classList.remove('active', 'done');
            if (i < n) {
                stepIndicator.classList.add('done');
            }
            if (i === n) {
                stepIndicator.classList.add('active');
            }
        } else {
            console.warn(`Step indicator 'step${i}' not found.`);
        }
    });

    document.querySelectorAll('[id^="panelStep"]').forEach(p => {
        if (p) p.style.display = 'none';
    });
    const targetPanel = document.getElementById('panelStep' + n);
    if (targetPanel) {
        targetPanel.style.display = 'block';
    } else {
        console.error(`Panel 'panelStep${n}' not found.`);
    }
}

// Navigates to step 2 after validating step 1 fields
function goStep2() {
    clearErrors(); // Always clear errors at the start of validation
    let isValid = true; // Use more descriptive variable name

    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('agreeTerms');
    const alertBox = document.getElementById('alertBox');
    const alertMsg = document.getElementById('alertMsg');


    // Helper to check for input existence
    const getInputValue = (inputElement, errorId) => {
        if (!inputElement) {
            console.error(`Input element with ID "${errorId.replace('err-', '')}" not found.`);
            isValid = false; // Mark overall form as invalid
            return ''; // Return empty string to prevent further errors
        }
        return inputElement.value.trim();
    };

    const fn = getInputValue(firstNameInput, 'err-firstName');
    const ln = getInputValue(lastNameInput, 'err-lastName');
    const em = getInputValue(emailInput, 'err-email');
    const pw = getInputValue(passwordInput, 'err-password');
    const pwConfirm = getInputValue(passwordConfirmInput, 'err-password_confirmation');
    const termsChecked = termsCheckbox ? termsCheckbox.checked : false;

    // Validate fields
    if (!fn) {
        showError('err-firstName', 'First name is required.'); // Provide default message
        isValid = false;
    }
    if (!ln) {
        showError('err-lastName', 'Last name is required.'); // Provide default message
        isValid = false;
    }
    // Basic email validation regex can be improved for edge cases but is generally okay for a quick check
    if (!em || !/^[^@]+@[^@]+\.[^@]+$/.test(em)) {
        showError('err-email', 'Please enter a valid email address.');
        isValid = false;
    }
    // Password validation: assuming a minimum length of 8 based on checkStrength, but could be stricter
    if (pw.length < 8) {
        showError('err-password', 'Password must be at least 8 characters long.'); // Provide default message
        isValid = false;
    }
    if (pwConfirm.length < 8) {
        showError('err-password_confirmation', 'Please confirm your password.');
        isValid = false;
    }
    if (pw !== pwConfirm && pw.length >= 8 && pwConfirm.length >= 8) {
        showError('err-password_confirmation', 'Passwords do not match.');
        isValid = false;
    }
    if (!termsChecked) {
        if (alertBox && alertMsg) {
            alertBox.classList.add('show');
            alertMsg.textContent = 'Please accept the Terms of Service to continue.';
        } else {
            console.warn('Alert box or message element not found for terms error.');
        }
        isValid = false;
    }

    if (isValid) {
        setStep(2);
    }
}

// Navigates back to step 1
function backStep1() {
    setStep(1);
}

// Final registration step - validates step 2 and submits the form
function finishRegister(event) {
    if (event) event.preventDefault();

    clearErrors();
    const storeNameInput = document.getElementById('store_name');
    const storeName = storeNameInput ? storeNameInput.value.trim() : '';
    const roleRadios = document.querySelectorAll('input[name="role"]');
    const selectedRole = Array.from(roleRadios).find(r => r.checked);

    if (!storeName) {
        showError('err-storeName', 'Please enter your store name.');
        return;
    }

    if (!selectedRole) {
        const alertBox = document.getElementById('alertBox');
        const alertMsg = document.getElementById('alertMsg');
        if (alertBox && alertMsg) {
            alertBox.classList.add('show');
            alertMsg.textContent = 'Please select a role.';
        }
        return;
    }

    const btn = document.getElementById('btnStep2');
    if (btn) {
        btn.classList.add('loading');
        btn.disabled = true;
    }

    // Actually submit the form to the backend
    const form = document.getElementById('registerForm');
    if (form) {
        // Add a small delay to show loading state
        setTimeout(() => {
            form.submit();
        }, 500);
    } else {
        console.error('Form with ID "registerForm" not found.');
    }
}

// Expose all functions to the global window object to make them available for inline onclick handlers
window.togglePw = togglePw;
window.checkStrength = checkStrength;
window.selectRole = selectRole;
window.showError = showError;
window.clearErrors = clearErrors;
window.setStep = setStep;
window.goStep2 = goStep2;
window.backStep1 = backStep1;
window.finishRegister = finishRegister;
