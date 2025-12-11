<?php require '../app/views/layouts/header.php'; ?>

<style>
    body { background-color: #fbfbfd; }
    .profile-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        padding: 40px;
    }
    .stat-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        padding: 24px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .form-floating > .form-control {
        border-radius: 12px;
        border: 1px solid #d2d2d7;
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
    }
    .form-floating > .form-control:focus {
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0,113,227,0.1);
    }
</style>

<div class="container py-5 mt-4">
    <div class="row g-5 justify-content-center">
        <!-- Sidebar / Stats -->
        <div class="col-md-4">
            <div class="text-center mb-4">
                <div class="bg-secondary rounded-circle mx-auto mb-3 shadow-sm" style="width: 120px; height: 120px; background-image: url('https://ui-avatars.com/api/?name=<?= urlencode($data['user']['nom']) ?>&size=240'); background-size: cover;"></div>
                <h3 class="fw-bold mb-1"><?= htmlspecialchars($data['user']['nom']) ?></h3>
                <p class="text-secondary small text-uppercase fw-bold tracking-wide">Eventium ID</p>
                <p class="text-muted"><?= htmlspecialchars($data['user']['email']) ?></p>
            </div>

            <div class="row g-3">
                <?php if(isset($data['stats']['inscriptions'])): ?>
                    <div class="col-6 col-md-12">
                        <div class="stat-card">
                            <h2 class="display-4 fw-bold text-primary mb-0"><?= $data['stats']['inscriptions'] ?></h2>
                            <span class="text-secondary small fw-bold text-uppercase">Events Enrolled</span>
                        </div>
                    </div>
                <?php elseif(isset($data['stats']['events'])): ?>
                    <div class="col-6">
                        <div class="stat-card p-3">
                            <h3 class="fw-bold text-primary mb-0"><?= $data['stats']['events'] ?></h3>
                            <span class="text-secondary small fw-bold text-uppercase" style="font-size: 10px;">Events</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card p-3">
                            <h3 class="fw-bold text-success mb-0"><?= $data['stats']['users'] ?></h3>
                            <span class="text-secondary small fw-bold text-uppercase" style="font-size: 10px;">Users</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card p-3">
                            <h3 class="fw-bold text-warning mb-0"><?= $data['stats']['categories'] ?></h3>
                            <span class="text-secondary small fw-bold text-uppercase" style="font-size: 10px;">Categories</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Settings Form -->
        <div class="col-md-8 col-lg-6">
            <div class="profile-card">
                <h4 class="fw-bold mb-4">Account Settings</h4>
                
                <?php if(isset($_GET['updated'])): ?>
                <div class="alert alert-success d-flex align-items-center rounded-4 border-0 bg-success-subtle text-success mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>Profile updated successfully.</div>
                </div>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger d-flex align-items-center rounded-4 border-0 bg-danger-subtle text-danger mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div><?= htmlspecialchars($_GET['error']) ?></div>
                </div>
                <?php endif; ?>

                <form action="/python/public/profile/update" method="POST">
                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold text-uppercase ms-1">Personal Information</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= htmlspecialchars($data['user']['nom']) ?>">
                            <label for="name">Full Name</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control bg-light" id="email" value="<?= htmlspecialchars($data['user']['email']) ?>" disabled readonly>
                            <label for="email">Email Address</label>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label text-secondary small fw-bold text-uppercase ms-1">Security</label>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Current Password">
                            <label for="old_password">Current Password (Required to change password)</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                            <label for="password">New Password</label>
                        </div>
                        <div class="form-text ms-1 mt-2">Leave password fields blank if you don't want to change it.</div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <a href="/python/public/auth/logout" class="text-danger text-decoration-none fw-semibold">Sign Out</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require '../app/views/layouts/footer.php'; ?>
