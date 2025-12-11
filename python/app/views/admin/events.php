<?php require '../app/views/admin/layout/header.php'; ?>

<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5 fw-bold mb-0">All Events</h2>
        <button class="btn btn-primary rounded-pill px-4" style="background-color: #0071e3; border: none;" data-bs-toggle="modal" data-bs-target="#addEventModal">
            <i class="bi bi-plus-lg me-2"></i> Add Event
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-apple">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Attendees</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['events'] as $event): ?>
                <tr>
                    <td class="text-secondary">#<?= $event['id'] ?></td>
                    <td>
                        <?php if($event['est_cloture'] == 0): ?>
                            <span class="status-badge status-active">Active</span>
                        <?php else: ?>
                            <span class="status-badge status-pending" style="color: #ff3b30; background: rgba(255, 59, 48, 0.1);">Closed</span>
                        <?php endif; ?>
                    </td>
                    <td class="fw-medium"><?= htmlspecialchars($event['titre']) ?></td>
                    <td><?= date('M d, Y', strtotime($event['date_evenement'])) ?></td>
                    <td><?= $event['nb_max_participants'] ?> Max</td>
                    <td class="text-end">
                        <a href="/python/public/admin/events/edit?id=<?= $event['id'] ?>" class="btn btn-sm btn-link text-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="/python/public/admin/events/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            <input type="hidden" name="id" value="<?= $event['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-link text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form method="POST" action="/python/public/admin/events/add" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Event Title</label>
                        <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. WWDC 2025" style="background-color: #f5f5f7; border: none;" required>
                    </div>
                    
                    <div class="mb-3">
                         <label class="form-label small fw-bold text-secondary">Description</label>
                         <textarea name="description" class="form-control rounded-3" rows="3" style="background-color: #f5f5f7; border: none;" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Date & Time</label>
                            <input type="datetime-local" name="date" class="form-control rounded-3" style="background-color: #f5f5f7; border: none;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Category</label>
                            <select name="category_id" class="form-select rounded-3" style="background-color: #f5f5f7; border: none;" required>
                                <?php foreach($data['categories'] as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                             <label class="form-label small fw-bold text-secondary">Location</label>
                             <input type="text" name="location" class="form-control rounded-3" style="background-color: #f5f5f7; border: none;" required>
                        </div>
                         <div class="col-md-6 mb-3">
                             <label class="form-label small fw-bold text-secondary">Max Participants</label>
                             <input type="number" name="max_participants" class="form-control rounded-3" style="background-color: #f5f5f7; border: none;" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">Cover Image</label>
                        <input type="file" name="image" class="form-control rounded-3" style="background-color: #f5f5f7; border: none;">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 py-2 fw-medium" style="background-color: #0071e3; border: none;">Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require '../app/views/admin/layout/footer.php'; ?>
