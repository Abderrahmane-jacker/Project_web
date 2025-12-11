<?php require '../app/views/admin/layout/header.php'; ?>

<div class="row">
    <div class="col-md-4">
        <div class="admin-card mb-4">
            <h3 class="h5 fw-bold mb-4">Add Category</h3>
            <form method="POST" action="/python/public/admin/categories/add" enctype="multipart/form-data">
                <?php if(isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
                    <div class="alert alert-danger small py-2 mb-3">Category already exists</div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Name</label>
                    <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Technology" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Cover Image</label>
                    <input type="file" name="image" class="form-control rounded-3">
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-3" style="background: #0071e3; border: none;">Save Category</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="admin-card">
            <h2 class="h5 fw-bold mb-4">Managed Categories</h2>
            
            <?php if(isset($_GET['success']) && $_GET['success'] == 'updated'): ?>
                <div class="alert alert-success small py-2 mb-3">Category updated successfully.</div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table-apple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Event Count</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['categories'] as $cat): ?>
                        <tr>
                            <td class="text-secondary">#<?= $cat['id'] ?></td>
                            <td class="fw-medium">
                                <div class="d-flex align-items-center">
                                    <?php if(!empty($cat['image']) && file_exists('../public/' . $cat['image'])): ?>
                                        <img src="/python/public/<?= $cat['image'] ?>" class="rounded-circle me-2" width="24" height="24" style="object-fit:cover;">
                                    <?php else: ?>
                                        <span class="d-inline-block rounded-circle me-2" style="width: 8px; height: 8px; background-color: #0071e3;"></span>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($cat['nom']) ?>
                                </div>
                            </td>
                            <td><?= $cat['event_count'] ?> events</td>
                            <td class="text-end">
                                <a href="/python/public/admin/categories/edit?id=<?= $cat['id'] ?>" class="btn btn-sm btn-link text-secondary"><i class="bi bi-pencil"></i></a>
                                <form action="/python/public/admin/categories/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-link text-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require '../app/views/admin/layout/footer.php'; ?>
