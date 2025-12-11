<?php require '../app/views/admin/layout/header.php'; ?>

<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h5 fw-bold mb-0">Edit Category</h2>
        <a href="/python/public/admin/categories" class="btn btn-light rounded-pill px-4 text-secondary">
            Cancel
        </a>
    </div>

    <form method="POST" action="/python/public/admin/categories/update" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['category']['id'] ?>">

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger small py-2 mb-3">
                <?php 
                if($_GET['error'] == 'exists') echo 'Category name already exists.';
                else echo 'An error occurred. Please try again.';
                ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">Name</label>
            <input type="text" name="name" class="form-control rounded-3" value="<?= htmlspecialchars($data['category']['nom']) ?>" style="background-color: #f5f5f7; border: none;" required>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold text-secondary">Cover Image</label>
            <input type="file" name="image" class="form-control rounded-3" style="background-color: #f5f5f7; border: none;">
            <?php if(!empty($data['category']['image'])): ?>
                <div class="mt-2">
                    <small class="text-secondary">Current image:</small><br>
                    <img src="/python/public/<?= $data['category']['image'] ?>" alt="Cover" style="height: 50px; border-radius: 8px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary rounded-3 py-2 fw-medium" style="background-color: #0071e3; border: none;">Save Changes</button>
        </div>
    </form>
</div>

<?php require '../app/views/admin/layout/footer.php'; ?>
