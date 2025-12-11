<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

    <!-- Sidebar -->
    <nav class="admin-sidebar d-flex flex-column">
        <div class="sidebar-brand">
            <i class="bi bi-calendar-event fs-4"></i>
            <span>Admin Console</span>
        </div>

        <div class="nav flex-column">
            <a href="/python/public/admin" class="nav-link <?= ($data['current_page'] == 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
            <a href="/python/public/admin/events" class="nav-link <?= ($data['current_page'] == 'events') ? 'active' : '' ?>">
                <i class="bi bi-calendar-event"></i>
                Events Management
            </a>
            <a href="/python/public/calendar" class="nav-link <?= ($data['current_page'] == 'calendar') ? 'active' : '' ?>">
                <i class="bi bi-calendar3"></i>
                Calendar
            </a>
            <a href="/python/public/admin/categories" class="nav-link <?= ($data['current_page'] == 'categories') ? 'active' : '' ?>">
                <i class="bi bi-tags"></i>
                Categories
            </a>
            <a href="/python/public/admin/attendance" class="nav-link <?= ($data['current_page'] == 'attendance') ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                Attendance Lists
            </a>
        </div>

        <div class="mt-auto">
            <a href="/python/public/auth/logout" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i>
                Sign Out
            </a>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="admin-content">
        <!-- Top Header inside Main Content -->
        <header class="d-flex justify-content-between align-items-center mb-5 pt-2">
            <div>
                <h1 class="h3 fw-bold mb-0"><?= $data['title'] ?></h1>
                <p class="text-secondary small mb-0">Overview of your platform.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <!-- Notifications -->
                <div class="position-relative">
                    <?php 
                        $notifications = get_latest_notifications(3); 
                        $unreadCount = count($notifications);
                    ?>
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center cursor-pointer" style="width: 40px; height: 40px; cursor: pointer;" id="notificationBtn">
                        <i class="bi bi-bell text-secondary"></i>
                        <?php if($unreadCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 10px; height: 10px;"></span>
                        <?php endif; ?>
                    </div>
                    <!-- Notification Dropdown -->
                    <div class="admin-panel shadow-lg rounded-4 p-3 position-absolute end-0 mt-3 d-none" id="notificationPanel" style="width: 320px; z-index: 1050; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Notifications</h6>
                            <span class="badge bg-primary rounded-pill"><?= $unreadCount ?> new</span>
                        </div>
                        <div class="list-group list-group-flush small">
                            <?php if(empty($notifications)): ?>
                                <div class="text-center text-secondary py-3">No new notifications</div>
                            <?php else: ?>
                                <?php foreach($notifications as $notif): ?>
                                    <a href="#" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 px-2">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <?php if($notif['type'] == 'inscription'): ?>
                                                <i class="bi bi-person-plus-fill text-primary"></i>
                                            <?php else: ?>
                                                <i class="bi bi-info-circle-fill text-secondary"></i>
                                            <?php endif; ?>
                                            <p class="mb-0 fw-bold text-truncate" style="max-width: 200px;"><?= htmlspecialchars($notif['message']) ?></p>
                                        </div>
                                        <small class="text-secondary d-block ps-4"><?= date('M j, g:i a', strtotime($notif['created_at'])) ?></small>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="position-relative">
                    <div class="d-flex align-items-center gap-2 cursor-pointer" id="profileBtn" style="cursor: pointer;">
                        <div class="bg-secondary rounded-circle" style="width: 32px; height: 32px; background-image: url('https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'Admin User') ?>'); background-size: cover;"></div>
                        <span class="fs-6 fw-medium"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin User') ?></span>
                    </div>
                    <!-- Profile Settings Dropdown -->
                    <div class="admin-panel shadow-lg rounded-4 p-3 position-absolute end-0 mt-3 d-none" id="settingsPanel" style="width: 280px; z-index: 1050; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                        <div class="text-center mb-4 pt-2">
                            <div class="bg-secondary rounded-circle mx-auto mb-2" style="width: 64px; height: 64px; background-image: url('https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'Admin User') ?>'); background-size: cover;"></div>
                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin User') ?></h6>
                            <small class="text-secondary"><?= htmlspecialchars($_SESSION['user_email'] ?? 'admin@apple.com') ?></small>
                        </div>
                        <hr class="dropdown-divider opacity-10">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="#" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3 hover-bg-light">
                                    <i class="bi bi-person-gear fs-5"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3 hover-bg-light">
                                    <i class="bi bi-shield-lock fs-5"></i>
                                    <span>Security</span>
                                </a>
                            </li>
                            <li>
                                <a href="/python/public/auth/logout" class="d-flex align-items-center gap-3 text-decoration-none text-danger p-2 rounded-3 hover-bg-light">
                                    <i class="bi bi-box-arrow-right fs-5"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
