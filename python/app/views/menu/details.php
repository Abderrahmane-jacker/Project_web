<?php require '../app/views/layouts/header.php'; ?>

<!-- Admin CSS for any utilities (Removed to fix header conflict) -->
<!-- <link rel="stylesheet" href="/python/public/css/admin.css"> -->
<style>
    body { background-color: #fbfbfd; }
    .hero-banner {
        height: 60vh;
        min-height: 400px;
        background-size: cover;
        background-position: center;
        position: relative;
        border-radius: 0 0 40px 40px;
        overflow: hidden;
    }
    .hero-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%);
    }
    .detail-container {
        margin-top: -100px;
        position: relative;
        z-index: 10;
    }
    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.4);
    }
</style>

<?php 
    $event = $data['event'];
    $imgSrc = $event['image_cover'];
    if(!empty($imgSrc)) {
         if(strpos($imgSrc, 'uploads/') === 0) {
            $imgSrc = '/python/public/' . $imgSrc;
        } else {
            $imgSrc = '/python/public/images/' . $imgSrc;
        }
    } else {
        $imgSrc = '/python/public/images/default_event.jpg'; // Fallback
    }
?>

<div class="hero-banner" style="background-image: url('<?= $imgSrc ?>');">
    <div class="hero-overlay w-100 h-100"></div>
</div>

<div class="container detail-container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="content-card p-5">
                <div class="row align-items-center mb-4">
                    <div class="col-md-8">
                        <span class="badge bg-primary rounded-pill mb-3 px-3 py-2">Event</span>
                        <h1 class="fw-bold display-4 mb-2"><?= htmlspecialchars($event['titre']) ?></h1>
                        <p class="text-secondary lead"><?= htmlspecialchars($event['lieu']) ?></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="bg-light rounded-4 p-3 d-inline-block text-center border">
                            <h2 class="fw-bold text-danger mb-0"><?= date('d', strtotime($event['date_evenement'])) ?></h2>
                            <p class="mb-0 text-uppercase fw-bold small"><?= date('M', strtotime($event['date_evenement'])) ?></p>
                        </div>
                    </div>
                </div>

                <hr class="opacity-10 my-4">

                <div class="row">
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-3">About this Event</h4>
                        <p class="text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                            <?= nl2br(htmlspecialchars($event['description'])) ?>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light rounded-4 p-4 mt-4 mt-md-0">
                            <h5 class="fw-bold mb-3">Registration</h5>
                            
                            <?php if ($data['is_enrolled']): ?>
                                <button class="btn btn-success w-100 py-3 rounded-pill fw-bold mb-3" disabled>
                                    <i class="bi bi-check-circle-fill me-2"></i> Registered
                                </button>

                                <a href="/python/public/menu/invitation/<?= $event['id'] ?>" class="btn btn-dark w-100 py-3 rounded-pill fw-bold mb-3">
                                    <i class="bi bi-download me-2"></i> Download Invitation
                                </a>
                                
                                <form action="/python/public/menu/cancel-enroll" method="POST" onsubmit="return confirm('Are you sure you want to cancel your registration?');">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                    <button type="submit" class="btn btn-outline-danger w-100 py-3 rounded-pill fw-bold">
                                        Cancel Inscription
                                    </button>
                                </form>
                            <?php elseif ($event['est_cloture'] == 1): ?>
                                <button class="btn btn-secondary w-100 py-3 rounded-pill fw-bold" disabled>
                                    Event Ended
                                </button>
                            <?php else: ?>
                                <form action="/python/public/menu/enroll" method="POST">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                                        Enroll Now
                                    </button>
                                </form>
                                <p class="text-center small text-muted mt-3 mb-0">Limited spots available.</p>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($event['est_cloture'] == 1): ?>
<!-- Reviews Section (Only for Ended Events) -->
<div class="container py-5" id="reviews">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white rounded-4 p-5 shadow-sm">
                <h3 class="fw-bold mb-4"><i class="bi bi-chat-left-quote me-2"></i> Reviews & Comments</h3>
                
                <!-- Add Comment Form -->
                <form action="/python/public/menu/comment" method="POST" class="mb-5">
                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Rating</label>
                        <div class="d-flex gap-1" id="starRating">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="bi bi-star-fill fs-4 text-warning star-btn" data-value="<?= $i ?>" style="cursor: pointer; opacity: 0.3;" onclick="setRating(<?= $i ?>)"></i>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" value="5">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Comment</label>
                        <textarea name="comment" class="form-control rounded-3" rows="3" placeholder="Share your experience..." required style="resize: none;"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-send me-2"></i> Submit Review
                    </button>
                </form>
                
                <hr class="my-4 opacity-10">
                
                <!-- Comments List -->
                <div class="comments-list">
                    <?php if (empty($data['comments'])): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-left-text fs-1 d-block mb-2 opacity-25"></i>
                            <p>No reviews yet. Be the first to share your experience!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($data['comments'] as $comment): ?>
                        <div class="d-flex gap-3 mb-4 pb-4 border-bottom">
                            <div class="flex-shrink-0">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 48px; height: 48px; background-image: url('https://ui-avatars.com/api/?name=<?= urlencode($comment['user_name']) ?>'); background-size: cover;"></div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="fw-bold mb-0"><?= htmlspecialchars($comment['user_name']) ?></h6>
                                    <small class="text-muted"><?= date('M j, Y', strtotime($comment['created_at'])) ?></small>
                                </div>
                                <div class="mb-2">
                                    <?php for($s = 1; $s <= 5; $s++): ?>
                                        <i class="bi bi-star-fill small <?= $s <= $comment['rating'] ? 'text-warning' : 'text-muted opacity-25' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="mb-0 text-secondary"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setRating(value) {
    document.getElementById('ratingValue').value = value;
    document.querySelectorAll('.star-btn').forEach((star, index) => {
        star.style.opacity = index < value ? '1' : '0.3';
    });
}
// Initialize with 5 stars
setRating(5);
</script>
<?php endif; ?>

<?php require '../app/views/layouts/footer.php'; ?>
