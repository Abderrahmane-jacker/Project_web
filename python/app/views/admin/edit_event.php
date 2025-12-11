<?php require '../app/views/admin/layout/header.php'; ?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5 fw-bold mb-0">Edit Event</h2>
        <a href="/python/public/admin/events" class="btn btn-light rounded-pill px-4 text-secondary">
            Cancel
        </a>
    </div>

    <form method="POST" action="/python/public/admin/events/update" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['event']['id'] ?>">

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">Event Title</label>
            <input type="text" name="title" class="form-control rounded-3" value="<?= htmlspecialchars($data['event']['titre']) ?>" style="background-color: #f5f5f7; border: none;" required>
        </div>
        
        <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Description</label>
                <textarea name="description" class="form-control rounded-3" rows="3" style="background-color: #f5f5f7; border: none;" required><?= htmlspecialchars($data['event']['description']) ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold text-secondary">Date & Time</label>
                <input type="datetime-local" name="date" class="form-control rounded-3" value="<?= date('Y-m-d\TH:i', strtotime($data['event']['date_evenement'])) ?>" style="background-color: #f5f5f7; border: none;" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold text-secondary">Category</label>
                <select name="category_id" class="form-select rounded-3" style="background-color: #f5f5f7; border: none;" required>
                    <?php foreach($data['categories'] as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $data['event']['categorie_id']) ? 'selected' : '' ?>>
                            <?= $cat['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold text-secondary">Location</label>
                    <input type="text" name="location" class="form-control rounded-3" value="<?= htmlspecialchars($data['event']['lieu']) ?>" style="background-color: #f5f5f7; border: none;" required>
            </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold text-secondary">Max Participants</label>
                    <input type="number" name="max_participants" class="form-control rounded-3" value="<?= $data['event']['nb_max_participants'] ?>" style="background-color: #f5f5f7; border: none;" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold text-secondary">Cover Image (Leave empty to keep current)</label>
            <input type="file" name="image" class="form-control rounded-3" style="background-color: #f5f5f7; border: none;">
            <?php if(!empty($data['event']['image_cover'])): ?>
                <div class="mt-2">
                    <small class="text-secondary">Current image:</small><br>
                    <img src="/python/public/<?= $data['event']['image_cover'] ?>" alt="Cover" style="height: 50px; border-radius: 8px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary rounded-3 py-2 fw-medium" style="background-color: #0071e3; border: none;">Save Changes</button>
        </div>
    </form>
</div>

<?php require '../app/views/admin/layout/footer.php'; ?>
