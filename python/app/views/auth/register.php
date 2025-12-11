<?php require '../app/views/layouts/header.php'; ?>

<style>
    .auth-container {
        max-width: 460px;
        margin: 40px auto;
        padding: 40px;
    }
    .auth-header h1 {
        font-size: 28px;
        font-weight: 600;
    }
</style>

<div class="auth-container">
    <div class="auth-header text-center mb-5">
        <h1>Create your Eventium ID</h1>
        <p class="text-muted">One Eventium ID is all you need to access all Eventium services.</p>
    </div>

    <form method="POST" action="/python/public/register">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small mb-4 rounded-3">
                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
            <label for="name">Name</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            <label for="email">Email</label>
            <div class="form-text small ps-1 pt-1">This will be your new Eventium ID.</div>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
            <label for="confirmPassword">Confirm Password</label>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" value="" id="news">
            <label class="form-check-label small text-muted" for="news">
                Subscribe to Eventium emails to receive news and Events updates.
            </label>
        </div>

        <button class="btn btn-primary w-100 py-3 rounded-3" style="font-size: 17px;" type="submit">Continue</button>
    </form>
    
    <div class="text-center mt-4">
        <a href="login" class="text-decoration-none small">Already have an account? Sign in ></a>
    </div>
</div>

<?php require '../app/views/layouts/footer.php'; ?>
