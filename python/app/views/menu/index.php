<?php require '../app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="/python/public/css/store.css?v=<?= time() ?>">
<link rel="stylesheet" href="/python/public/css/store_animation.css">
<link rel="stylesheet" href="/python/public/css/store_carousel.css">
<div class="container-fluid pt-5">
    <!-- Floating Circles Animation Background -->
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <!-- Event Carousel Section -->
    <section class="store-carousel-section text-start mb-5">
        <div class="container mb-5">
            <div class="row align-items-end">
                <div class="col-md-7">
                    <h1 class="fw-bold" style="font-size: 64px; letter-spacing: -2px; margin-top: 80px;">
                        <span class="apple-intelligence-text">Eventium.</span>
                        <br>
                        <span class="text-secondary" style="font-size: 28px; font-weight: 400; letter-spacing: normal;">The best way to enter the Events you love.</span>
                    </h1>
                </div>
                <div class="col-md-5 text-md-end pb-2">
                    <?php if(!isset($_SESSION['user_id'])): ?>
                    <h2 class="fw-semibold mb-1" style="font-size: 24px;">Give something special<br>this Year.</h2>
                    <a href="/python/public/login" class="text-decoration-none small">Sign in Now<i class="bi bi-chevron-right" style="font-size: 10px;"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="carousel-wrapper js-carousel position-relative container glass-morphism p-4">
                <!-- Navigation Buttons -->
                <button class="prev-btn btn btn-light rounded-circle shadow-sm position-absolute start-0 top-50 translate-middle-y z-3" style="width: 40px; height: 40px; margin-left: -20px;" id="prevBtn"><i class="bi bi-chevron-left"></i></button>
                <button class="next-btn btn btn-light rounded-circle shadow-sm position-absolute end-0 top-50 translate-middle-y z-3" style="width: 40px; height: 40px; margin-right: -20px;" id="nextBtn"><i class="bi bi-chevron-right"></i></button>

                <!-- Carousel Container -->
                <div class="carousel-container d-flex overflow-auto py-5 justify-content-center" id="carouselContainer" style="scroll-behavior: smooth; scrollbar-width: none;">
                    <?php foreach($data['carousel_events'] as $item): ?>
                    <div class="flex-shrink-0 text-center px-4 js-category-filter" data-category-id="<?= $item['id'] ?>" style="width: 180px; transition: transform 0.3s; cursor: pointer;">
                        <a href="javascript:void(0)" class="text-decoration-none text-dark d-block">
                            <div class="d-flex align-items-center justify-content-center mb-2" style="height: 100px;">
                                <?php 
                                    $imgSrc = $item['image'];
                                    if(strpos($imgSrc, 'uploads/') === 0) {
                                        $imgSrc = '/python/public/' . $imgSrc;
                                    } else {
                                        // Default fallback or legacy images in public/images/
                                        $imgSrc = '/python/public/images/' . $imgSrc; 
                                    }
                                ?>
                                <img src="<?= $imgSrc ?>" alt="<?= $item['title'] ?>" class="img-fluid" style="max-height: 100%; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                            </div>
                            <p class="small fw-semibold mb-0"><?= $item['title'] ?></p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
        </div>
    </section>

    <!-- Product Grid (Existing) -->
    <div class="container">
        <section class="store-grid py-5">
            <!-- No Events Message (Hidden by default) -->
            <div id="no-events-msg" class="text-center py-5 d-none">
                <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                <h3 class="fw-bold text-secondary">No events here.</h3>
                <p class="text-muted">Check back later for updates in this category.</p>
            </div>

            <?php if(empty($data['categorized_events'])): ?>
                <div class="text-center py-5">
                    <p class="text-muted">No events currently available.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['categorized_events'] as $catId => $category): ?>
                    <div class="category-block mb-5 js-category-section" id="category-section-<?= (int)$catId ?>">
                        <div class="px-5 mb-5">
                             <h2 class="fw-bold apple-intelligence-text"><?= htmlspecialchars($category['category_name']) ?>.</h2><h2><span class="text-muted">Browse the collection.</span></h2>
                        </div>
                        
                        <div class="position-relative js-carousel">
                            <button class="btn btn-light rounded-circle shadow-sm position-absolute top-50 translate-middle-y z-3 prev-btn d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; left: -50px; background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px); border: none;"><i class="bi bi-chevron-left fs-4"></i></button>
                            <button class="btn btn-light rounded-circle shadow-sm position-absolute top-50 translate-middle-y z-3 next-btn d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; right: -50px; background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px); border: none;"><i class="bi bi-chevron-right fs-4"></i></button>
            
                            <!-- Card Carousel Container -->
                            <div class="carousel-container d-flex overflow-auto py-5 px-0" style="scrollbar-width: none; scroll-behavior: smooth;">
                                <div class="ps-4"></div> <!-- Spacer for starting padding -->
                                <?php foreach($category['events'] as $event): ?>
                                <div class="flex-shrink-0 me-4" style="width: 480px; height: 500px;">
                                    <a href="/python/public/menu/event/<?= $event['id'] ?>" class="text-decoration-none text-dark d-block h-100">
                                        <div class="card h-100 border-0 apple-card overflow-hidden" style="background-color: #f5f5f7; border-radius: 28px; transition: transform 0.2s;">
                                            <div class="card-body p-4 d-flex flex-column pt-5 ps-4 pe-4 position-relative">
                                                <div class="z-2 text-start position-relative">
                                                    <h3 class="store-card-title mb-1"><?= htmlspecialchars($event['title']) ?></h3>
                                                    <span class="apple-intelligence-text store-card-category d-inline-block"><?= htmlspecialchars($category['category_name']) ?></span>
                                                    <p class="mb-2 text-secondary" style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($event['description']) ?></p>
                                                    <p class="mt-1 store-card-info">
                                                        <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($event['place']) ?><br>
                                                        <i class="bi bi-calendar"></i> <?= htmlspecialchars($event['date']) ?>
                                                    </p>
                                                </div>
                                                <div class="position-absolute bottom-0 start-0 w-100 text-center z-1 pointer-events-none">
                                                    <?php if(!empty($event['image_cover'])): 
                                                        $evtImg = $event['image_cover'];
                                                        if(strpos($evtImg, 'uploads/') === 0) {
                                                            $evtImg = '/python/public/' . $evtImg;
                                                        } else {
                                                            $evtImg = '/python/public/images/' . $evtImg;
                                                        }
                                                    ?>
                                                    <img src="<?= $evtImg ?>" alt="<?= htmlspecialchars($event['title']) ?>" class="card-image" style="display: block;">
                                                    <?php else: ?>
                                                        <div style="height: 150px; background: #ddd; display:flex; align-items:center; justify-content:center;">No Image</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

<script src="/python/public/js/carousel.js?v=<?= time() ?>"></script>
<script src="/python/public/js/store_filter.js?v=<?= time() ?>"></script>
<?php require '../app/views/layouts/footer.php'; ?>
