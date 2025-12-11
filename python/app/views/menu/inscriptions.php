<?php require '../app/views/layouts/header.php'; ?>

<!-- Include Admin CSS for Notification/Profile styles (optional, or use Bootstrap) -->
<!-- <link rel="stylesheet" href="/python/public/css/admin.css"> -->
<link rel="stylesheet" href="/python/public/css/inscription.css">

<div class="container inscriptions-header">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold mb-1">My Inscriptions</h1>
            <p class="text-secondary mb-0">Manage and view your event activities.</p>
        </div>
        
        <!-- Admin-like Actions (Notification & Profile) -->
        <div class="d-flex align-items-center gap-3">
             <!-- Notifications -->
             <div class="position-relative">
                <?php 
                    $userNotes = get_user_notifications(3); 
                    $userUnread = count($userNotes);
                ?>
                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center cursor-pointer" style="width: 44px; height: 44px; cursor: pointer;" id="notificationBtn">
                    <i class="bi bi-bell text-secondary fs-5"></i>
                    <?php if($userUnread > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 10px; height: 10px;"></span>
                    <?php endif; ?>
                </div>
                <!-- Notification Dropdown -->
                <div class="admin-panel shadow-lg rounded-4 p-3 position-absolute end-0 mt-3 d-none" id="notificationPanel" style="width: 320px; z-index: 1050; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Notifications</h6>
                        <span class="badge bg-primary rounded-pill"><?= $userUnread ?> new</span>
                    </div>
                    <div class="list-group list-group-flush small">
                        <?php if(empty($userNotes)): ?>
                            <div class="text-center text-secondary py-3">No new notifications</div>
                        <?php else: ?>
                            <?php foreach($userNotes as $note): ?>
                                <div class="list-group-item list-group-item-action border-0 rounded-3 mb-1 px-2 cursor-pointer hover-bg-light">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-circle" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-calendar-plus-fill text-primary" style="font-size: 12px;"></i>
                                        </div>
                                        <p class="mb-0 fw-bold text-dark text-truncate" style="max-width: 200px;"><?= htmlspecialchars($note['message']) ?></p>
                                    </div>
                                    <small class="text-secondary d-block ps-4 ms-1"><?= date('M j, g:i a', strtotime($note['created_at'])) ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="position-relative">
                <div class="d-flex align-items-center gap-2 ps-2 cursor-pointer" id="profileBtn">
                    <div class="bg-secondary rounded-circle" style="width: 40px; height: 40px; background-image: url('https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>'); background-size: cover;"></div>
                    <div class="d-none d-md-block">
                        <span class="d-block fw-semibold text-dark" style="font-size: 14px; line-height: 1.2;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
                        <span class="d-block text-secondary small" style="font-size: 12px;">Participant</span>
                    </div>
                </div>
                <!-- Profile Settings Dropdown -->
                <div class="admin-panel shadow-lg rounded-4 p-3 position-absolute end-0 mt-3 d-none" id="settingsPanel" style="width: 280px; z-index: 1050; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <div class="text-center mb-4 pt-2">
                        <div class="bg-secondary rounded-circle mx-auto mb-2" style="width: 64px; height: 64px; background-image: url('https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>'); background-size: cover;"></div>
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></h6>
                        <small class="text-secondary"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></small>
                    </div>
                    <hr class="dropdown-divider opacity-10">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="/python/public/profile" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3 hover-bg-light">
                                <i class="bi bi-person-gear fs-5"></i>
                                <span>Account Settings</span>
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
    </div>

    <!-- Events Grid -->
    <div class="row g-4">
        <?php if (empty($data['events'])): ?>
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="bi bi-calendar-x display-1 text-muted opacity-25 mb-3"></i>
                    <h3 class="fw-bold text-secondary">No inscriptions yet.</h3>
                    <p class="text-muted mb-4">You haven't registered for any events.</p>
                    <a href="/python/public/menu" class="btn btn-primary rounded-pill px-4 py-2 bg-dark border-0">Browse Events</a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($data['events'] as $event): ?>
            <div class="col-md-6 col-lg-4">
                <a href="/python/public/menu/event/<?= $event['id'] ?>" class="text-decoration-none text-dark d-block h-100">
                    <!-- Using similar card style but more static -->
                    <div class="card h-100 border-0 apple-card overflow-hidden shadow-sm hover-card" style="background-color: #fff; border-radius: 28px; min-height: 480px;">
                        <div class="card-body p-4 d-flex flex-column pt-4 ps-4 pe-4 position-relative">
                            <!-- Status Badge -->
                            <div class="mb-3">
                                <?php if ($event['est_cloture'] == 0): ?>
                                    <span class="status-badge status-active">Active</span>
                                <?php else: ?>
                                    <span class="status-badge status-ended">Ended</span>
                                <?php endif; ?>
                            </div>

                            <div class="z-2 text-start position-relative">
                                <h3 class="fw-bold mb-2 fs-4 text-dark"><?= htmlspecialchars($event['titre']) ?></h3>
                                <p class="mb-3 text-secondary small line-clamp-2"><?= htmlspecialchars($event['description']) ?></p>
                                
                                <div class="d-flex align-items-center text-secondary small gap-3 mb-4">
                                    <div><i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($event['lieu']) ?></div>
                                    <div><i class="bi bi-calendar me-1"></i> <?= htmlspecialchars($event['date_evenement']) ?></div>
                                </div>
                            </div>
                            
                            <div class="mt-auto w-100 text-center z-1">
                                <?php if(!empty($event['image_cover'])): 
                                    $evtImg = $event['image_cover'];
                                    if(strpos($evtImg, 'uploads/') === 0) {
                                        $evtImg = '/python/public/' . $evtImg;
                                    } else {
                                        $evtImg = '/python/public/images/' . $evtImg;
                                    }
                                ?>
                                <img src="<?= $evtImg ?>" alt="<?= htmlspecialchars($event['titre']) ?>" class="img-fluid rounded-4 mb-2 shadow-sm" style="width: 100%; height: 200px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="/python/public/js/admin.js"></script>
<?php require '../app/views/layouts/footer.php'; ?>
