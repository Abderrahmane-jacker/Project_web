<?php require '../app/views/layouts/header.php'; ?>

<style>
    /* Complementary CSS for Apple-specific look on top of Bootstrap */
    .auth-container {
        max-width: 600px;
        margin: 80px auto;
        padding: 0 20px;
    }
    
    .auth-header h1 {
        font-size: 40px;
        font-weight: 700;
        color: #1d1d1f;
    }

    /* Stacked Inputs Logic */
    .stacked-top .form-control {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom: none;
    }
    
    .stacked-bottom .form-control {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-top: 1px solid #d2d2d7; 
    }
    
    /* Override Bootstrap form-control focused border to be Apple blue */
    .form-control:focus {
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0,113,227, 0.1);
        z-index: 2;
    }

    /* Arrow button positioning inside input */
    .btn-input-arrow {
        border: none;
        background: transparent;
        color: #86868b;
        transition: color 0.2s;
    }
    .btn-input-arrow:hover {
        color: #1d1d1f;
        background: #f5f5f7;
    }
</style>

<div class="auth-container text-center">
    <div class="auth-header mb-5">
        <h1 class="mb-4">Sign in for faster checkout.</h1>
        <h2 class="h4 fw-medium">Sign in to Eventium</h2>
    </div>

    <form id="EventiumAuthForm" style="max-width: 500px; margin: 0 auto;" method="POST" action="/python/public/login">
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small mb-4 rounded-3 text-start">
                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Email Field -->
        <div class="position-relative" id="emailGroup">
            <div class="form-floating">
                <input type="email" class="form-control rounded-3" id="emailInput" name="email" placeholder="Email" style="height: 56px;" required>
                <label for="emailInput" class="text-secondary">Email</label>
            </div>
            
            <!-- Arrow Button -->
            <button type="button" class="btn btn-input-arrow rounded-circle position-absolute top-50 end-0 translate-middle-y me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" id="emailNextBtn" onclick="showPasswordStep()">
                <i class="bi bi-arrow-right-circle fs-4"></i>
            </button>
        </div>

        <!-- Password Field (Hidden Initially) -->
        <div class="position-relative d-none" id="passwordGroup">
            <div class="form-floating">
                <input type="password" class="form-control rounded-3" id="passwordInput" name="password" placeholder="Password" style="height: 56px;" >
                <label for="passwordInput" class="text-secondary">Password</label>
            </div>
             <button type="submit" class="btn btn-input-arrow rounded-circle position-absolute top-50 end-0 translate-middle-y me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-arrow-right-circle fs-4"></i>
            </button>
        </div>

        <div class="form-check d-flex justify-content-center mt-4 mb-4 gap-2">
            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
            <label class="form-check-label" for="rememberMe">
                Remember me
            </label>
        </div>
    </form>
    
    <div class="mt-5 text-center">
        <a href="#" class="text-decoration-none text-primary small d-block mb-2">Forgot password?</a>
        <p class="small text-muted mb-0">Don't have an Eventium Account? <a href="register" class="text-decoration-none text-primary">Create Your Eventium Account ></a></p>
    </div>
</div>

<script>
    function showPasswordStep() {
        const emailInput = document.getElementById('emailInput');
        const emailGroup = document.getElementById('emailGroup');
        const passwordGroup = document.getElementById('passwordGroup');
        const emailNextBtn = document.getElementById('emailNextBtn');
        const passwordInput = document.getElementById('passwordInput');

        if(emailInput.value.trim() !== "") {
            // Apply Locked/Stacked State
            emailInput.setAttribute('readonly', true);
            emailInput.classList.add('bg-light'); // Bootstrap gray bg
            emailNextBtn.classList.add('d-none'); // Hide arrow
            
            // Stack Logic: Add classes to email group to remove bottom rounded corners/border
            // But we need to target the input itself or a wrapper? 
            // Bootstrap form-control has border-radius.
            emailInput.classList.add('stacked-top'); // Custom class defined above? No, I defined .stacked-top .form-control
            // Actually let's just add the class directly to input via JS or wrap them.
            // Simpler: Just modify styles directly or specific class
            emailInput.style.borderBottomLeftRadius = '0';
            emailInput.style.borderBottomRightRadius = '0';
            emailInput.style.borderBottom = 'none';

            // Show Password
            passwordGroup.classList.remove('d-none');
            // Animate? Bootstrap doesn't have fade-in built-in for d-none switch easily without transition classes.
            // Just show it for now.
            
            const passInputControl = passwordGroup.querySelector('input');
            passInputControl.style.borderTopLeftRadius = '0';
            passInputControl.style.borderTopRightRadius = '0';
            
            passwordInput.focus();
        } else {
            emailInput.focus();
        }
    }

    function handleAuthSubmit(e) {
        e.preventDefault();
        alert("Signing in...");
    }
    
    // Handle Enter on Email
    document.getElementById('emailInput').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            showPasswordStep();
        }
    });
</script>

<?php require '../app/views/layouts/footer.php'; ?>
