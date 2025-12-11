<?php require '../app/views/layouts/header.php'; ?>
<style>
.hero-intro {
    height: 100vh;
    background: linear-gradient(135deg, #1d1d1f 0%, #000 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.logo-animation-wrapper {
    text-align: center;
}

.logo-main {
    font-size: 120px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -5px;
    opacity: 0;
    animation: logoReveal 1.5s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards;
}

.logo-tagline {
    font-size: 24px;
    color: rgba(255,255,255,0.6);
    font-weight: 300;
    margin-top: 20px;
    opacity: 0;
    animation: taglineReveal 1s ease-out 2s forwards;
}

.logo-icon {
    width: 80px;
    height: 80px;
    margin-bottom: 20px;
    opacity: 0;
    transform: scale(0.5) rotate(-10deg);
    animation: iconPop 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards;
}

.logo-glow {
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(0,113,227,0.3) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(60px);
    animation: glowPulse 4s ease-in-out infinite;
}

@keyframes iconPop {
    to {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
}

@keyframes logoReveal {
    0% {
        opacity: 0;
        transform: translateY(30px);
        filter: blur(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }
}

@keyframes taglineReveal {
    to {
        opacity: 1;
    }
}

@keyframes glowPulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
}

.scroll-indicator {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    animation: fadeIn 1s ease-out 3s forwards;
}

.scroll-indicator i {
    color: rgba(255,255,255,0.5);
    font-size: 28px;
    animation: bounce 2s infinite;
}

@keyframes fadeIn {
    to { opacity: 1; }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(10px); }
}

/* ============================================
   CATEGORIES GRID (Apple.com Style)
   ============================================ */
.categories-section {
    background: #f5f5f7;
    padding: 12px;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.category-tile {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    height: 580px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding-top: 50px;
    position: relative;
    transition: all 0.3s ease;
}

.category-tile:hover {
    transform: scale(1.005);
}

.category-tile-title {
    font-size: 40px;
    font-weight: 600;
    color: #1d1d1f;
    margin-bottom: 10px;
}

.category-tile-tagline {
    font-size: 17px;
    color: #1d1d1f;
    line-height: 1.4;
    max-width: 280px;
    margin-bottom: 20px;
}

.category-tile-buttons {
    display: flex;
    gap: 12px;
    margin-bottom: 30px;
}

.cat-btn-primary {
    background: #0071e3;
    color: #fff;
    padding: 10px 22px;
    border-radius: 980px;
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    transition: all 0.3s ease;
}

.cat-btn-primary:hover {
    background: #0077ed;
    color: #fff;
}

.cat-btn-secondary {
    background: transparent;
    color: #0071e3;
    padding: 10px 22px;
    border-radius: 980px;
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    border: 1px solid #0071e3;
    transition: all 0.3s ease;
}

.cat-btn-secondary:hover {
    background: #0071e3;
    color: #fff;
}

.category-tile-image {
    margin-top: auto;
    width: 100%;
    height: 320px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    overflow: hidden;
}

.category-tile-image img {
    max-width: 85%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.category-tile:hover .category-tile-image img {
    transform: scale(1.03);
}

@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }
    .category-tile {
        height: 500px;
    }
    .category-tile-title {
        font-size: 32px;
    }
}

/* ============================================
   EVENTS CAROUSEL (Apple TV+ Style)
   ============================================ */
.events-carousel-section {
    background: #fff;
    padding: 80px 0 100px;
    overflow: hidden;
}

.carousel-header {
    text-align: center;
    margin-bottom: 50px;
}

.carousel-header h2 {
    color: #1d1d1f;
    font-size: 48px;
    font-weight: 700;
}

.carousel-header p {
    color: #86868b;
    font-size: 18px;
    margin-top: 10px;
}

/* Apple TV+ Carousel Container */
.atv-carousel {
    position: relative;
    max-width: 100%;
    margin: 0 auto;
}

.atv-carousel-track {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    gap: 20px;
    padding: 0 calc(50% - 400px);
}

.atv-slide {
    flex-shrink: 0;
    width: 800px;
    height: 450px;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    transform: scale(0.85);
    opacity: 0.4;
    filter: brightness(0.5);
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    cursor: pointer;
}

.atv-slide.active {
    transform: scale(1);
    opacity: 1;
    filter: brightness(1);
    z-index: 10;
    border: 1px solid rgba(0,0,0,0.1);
    box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 8px 25px rgba(0,0,0,0.1);
}

.atv-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.atv-slide-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    background: linear-gradient(transparent, rgba(0,0,0,0.9));
}

.atv-slide-title {
    font-size: 42px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 15px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.atv-slide-meta {
    display: flex;
    align-items: center;
    gap: 20px;
}

.atv-slide-btn {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(10px);
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.atv-slide-btn:hover {
    background: #fff;
    color: #000;
}

.atv-slide-category {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
    font-weight: 500;
}

.atv-slide-category span {
    font-weight: 700;
    color: #fff;
}

/* Carousel Navigation */
.atv-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border: none;
    border-radius: 50%;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    z-index: 20;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.atv-nav:hover {
    background: rgba(255,255,255,0.2);
}

.atv-nav-prev { left: 30px; }
.atv-nav-next { right: 30px; }

/* Carousel Dots */
.atv-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}

.atv-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.atv-dot.active {
    background: #fff;
    width: 24px;
    border-radius: 4px;
}
</style>

<main>
    <!-- Hero Section with Logo Animation -->
    <section class="hero-intro">
        <div class="logo-glow"></div>
        <div class="logo-animation-wrapper">
            <i class="bi bi-calendar-event logo-icon" style="color: #0071e3; font-size: 80px; display: block;"></i>
            <h1 class="logo-main">Eventium</h1>
            <p class="logo-tagline">Discover. Connect. Experience.</p>
        </div>
        <div class="scroll-indicator">
            <i class="bi bi-chevron-double-down"></i>
        </div>
    </section>

    <!-- Categories Grid Section (Apple.com Style) -->
    <section class="categories-section">
        <div class="categories-grid">
            <?php 
            $taglines = [
                'Explore amazing events in this category.',
                'Discover what\'s happening near you.',
                'Connect with like-minded people.',
                'Experience something extraordinary.',
                'Join the community today.',
                'Find your next adventure.'
            ];
            $i = 0;
            foreach($data['categories'] as $cat): 
                $catImg = !empty($cat['image']) ? $cat['image'] : 'default_category.jpg';
                if(strpos($catImg, 'uploads/') === 0) {
                    $catImg = '/python/public/' . $catImg;
                } else {
                    $catImg = '/python/public/images/' . $catImg;
                }
                $tagline = $taglines[$i % count($taglines)];
            ?>
            <div class="category-tile">
                <h2 class="category-tile-title"><?= htmlspecialchars($cat['nom']) ?></h2>
                <p class="category-tile-tagline"><?= $tagline ?></p>
                <div class="category-tile-buttons">
                    <a href="/python/public/menu#cat-<?= $cat['id'] ?>" class="cat-btn-primary">Learn more</a>
                    <a href="/python/public/menu" class="cat-btn-secondary">Browse</a>
                </div>
                <div class="category-tile-image">
                    <img src="<?= $catImg ?>" alt="<?= htmlspecialchars($cat['nom']) ?>">
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>
    </section>

    <!-- Apple TV+ Style Events Carousel -->
    <section class="events-carousel-section">
        <div class="carousel-header">
            <h2>Upcoming Events</h2>
            <p>Don't miss what's happening next</p>
        </div>
        
        <div class="atv-carousel">
            <button class="atv-nav atv-nav-prev" onclick="atvPrev()"><i class="bi bi-chevron-left"></i></button>
            <button class="atv-nav atv-nav-next" onclick="atvNext()"><i class="bi bi-chevron-right"></i></button>
            
            <div class="atv-carousel-track" id="atvTrack">
                <?php 
                $idx = 0;
                foreach($data['events'] as $event): 
                    $evtImg = !empty($event['image_cover']) ? $event['image_cover'] : 'workshop.jpg';
                    if(strpos($evtImg, 'uploads/') === 0) {
                        $evtImg = '/python/public/' . $evtImg;
                    } else {
                        $evtImg = '/python/public/images/' . $evtImg;
                    }
                ?>
                <div class="atv-slide <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>" onclick="atvGoTo(<?= $idx ?>)">
                    <img src="<?= $evtImg ?>" alt="<?= htmlspecialchars($event['titre']) ?>">
                    <div class="atv-slide-overlay">
                        <h3 class="atv-slide-title"><?= htmlspecialchars($event['titre']) ?></h3>
                        <div class="atv-slide-meta">
                            <a href="/python/public/menu/event/<?= $event['id'] ?>" class="atv-slide-btn">View details</a>
                            <span class="atv-slide-category"><span><?= htmlspecialchars($event['category_name'] ?? 'Event') ?></span> · <?= date('M j', strtotime($event['date_evenement'])) ?></span>
                        </div>
                    </div>
                </div>
                <?php $idx++; endforeach; ?>
            </div>
            
            <div class="atv-dots" id="atvDots">
                <?php for($i = 0; $i < count($data['events']); $i++): ?>
                    <button class="atv-dot <?= $i === 0 ? 'active' : '' ?>" onclick="atvGoTo(<?= $i ?>)"></button>
                <?php endfor; ?>
            </div>
        </div>
    </section>
    
    <script>
    // Apple TV+ Style Carousel
    let atvCurrentIndex = 0;
    const atvSlides = document.querySelectorAll('.atv-slide');
    const atvDots = document.querySelectorAll('.atv-dot');
    const atvTrack = document.getElementById('atvTrack');
    const atvTotal = atvSlides.length;
    
    function atvGoTo(index) {
        if (index < 0) index = atvTotal - 1;
        if (index >= atvTotal) index = 0;
        atvCurrentIndex = index;
        
        // Update slides
        atvSlides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        
        // Update dots
        atvDots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        
        // Move track
        const slideWidth = 820; // 800 + 20 gap
        const offset = -index * slideWidth;
        atvTrack.style.transform = `translateX(${offset}px)`;
    }
    
    function atvNext() { atvGoTo(atvCurrentIndex + 1); }
    function atvPrev() { atvGoTo(atvCurrentIndex - 1); }
    
    // Auto-advance every 5 seconds
    setInterval(() => atvNext(), 5000);
    </script>
</main>

<?php require '../app/views/layouts/footer.php'; ?>
