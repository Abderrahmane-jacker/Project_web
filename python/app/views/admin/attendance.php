<?php require '../app/views/admin/layout/header.php'; ?>

<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5 fw-bold mb-0">Attendance Tracking</h2>
        <form method="GET" action="" class="d-flex gap-2">
            <input type="text" name="search" value="<?= htmlspecialchars($data['search'] ?? '') ?>" class="form-control form-control-sm rounded-pill px-3" placeholder="Search attendee..." style="width: 200px;">
            <button type="submit" class="btn btn-light btn-sm rounded-pill border px-3"><i class="bi bi-funnel"></i> Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-apple">
            <thead>
                <tr>
                    <th>Attendee</th>
                    <th>Event</th>
                    <th>Check-in Time</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['attendees'] as $person): ?>
                <tr>
                    <td class="fw-medium">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 32px; height: 32px; font-size: 12px;">
                                <?= substr($person['name'], 0, 1) ?>
                            </div>
                            <?= $person['name'] ?>
                        </div>
                    </td>
                    <td><?= $person['event'] ?></td>
                    <td class="text-secondary"><?= $person['check_in'] ?></td>
                    <td>
                        <?php if($person['status'] == 'Confirmed'): ?>
                            <span class="status-badge status-active">Confirmed</span>
                        <?php else: ?>
                            <span class="status-badge status-pending bg-danger-subtle text-danger">Cancelled</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-link text-secondary" onclick="openUserProfile(<?= $person['user_id'] ?>)">View Profile</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<!-- User Profile Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-body p-0">
                <!-- Header with Avatar -->
                <div class="position-relative p-4 text-center pb-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="mx-auto mb-3 shadow-sm rounded-circle" id="modalAvatar" style="width: 100px; height: 100px; background-color: #f5f5f7; background-size: cover;"></div>
                    <h4 class="fw-bold mb-1" id="modalName">User Name</h4>
                    <p class="text-secondary small" id="modalEmail">email@example.com</p>
                </div>
                
                <!-- Stats Grid -->
                <div class="p-4 pt-2">
                    <div class="row g-3 mt-2 text-center">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-4">
                                <h3 class="fw-bold text-primary mb-0" id="modalTotalInscriptions">0</h3>
                                <span class="text-secondary small fw-bold text-uppercase" style="font-size: 10px;">Enrolled</span>
                            </div>
                        </div>
                        <div class="col-6">
                             <div class="p-3 bg-light rounded-4">
                                <h5 class="fw-bold text-dark mb-0 fs-6" id="modalJoined" style="line-height: 24px;">-</h5>
                                <span class="text-secondary small fw-bold text-uppercase" style="font-size: 10px;">Joined</span>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Last Activity -->
                <div class="p-4 pt-0">
                    <h6 class="text-secondary small fw-bold text-uppercase mb-3">Recent Activity</h6>
                    <div class="d-flex align-items-center gap-3">
                         <div class="bg-primary bg-opacity-10 p-2 rounded-circle text-primary">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-medium small text-dark">Last Event Attended</p>
                            <p class="mb-0 text-secondary small" id="modalLastEvent">None</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('userProfileModal');
    const modal = new bootstrap.Modal(modalElement);
    
    // Elements to update
    const avatarEl = document.getElementById('modalAvatar');
    const nameEl = document.getElementById('modalName');
    const emailEl = document.getElementById('modalEmail');
    const inscriptionsEl = document.getElementById('modalTotalInscriptions');
    const joinedEl = document.getElementById('modalJoined');
    const lastEventEl = document.getElementById('modalLastEvent');

    window.openUserProfile = function(userId) {
        // Show loading state/reset
        nameEl.textContent = 'Loading...';
        
        // Fetch Data
        fetch('/python/public/admin/user_details?id=' + userId)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }
                
                // Populate Modal
                nameEl.textContent = data.name;
                emailEl.textContent = data.email;
                inscriptionsEl.textContent = data.stats.total_inscriptions;
                joinedEl.textContent = data.joined_date;
                lastEventEl.textContent = data.stats.last_event;
                
                // Avatar
                const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}&size=200&background=random`;
                avatarEl.style.backgroundImage = `url('${avatarUrl}')`;

                modal.show();
            })
            .catch(err => {
                console.error('Failed to fetch user details', err);
                nameEl.textContent = 'Error loading data';
            });
    };
});
</script>

<?php require '../app/views/admin/layout/footer.php'; ?>
