<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Apple' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/python/public/css/style.css">
    <?php if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false): ?>
    <link rel="stylesheet" href="/python/public/css/admin.css">
    <?php endif; ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark apple-navbar" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1030;">
    <div class="container">
        <a class="navbar-brand" href="/python/public/"><i class="bi bi-calendar-event"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/python/public/menu">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="/python/public/calendar">Calendar</a></li>
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'user'): ?>
                    <li class="nav-item"><a class="nav-link" href="/python/public/inscriptions">Inscriptions</a></li>
                <?php endif; ?>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="/python/public/admin">Console</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="d-flex">
            <a class="nav-link text-white mx-2" href="#"><i class="bi bi-search"></i></a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a class="nav-link text-white mx-2" href="/python/public/profile" title="Profile"><i class="bi bi-person-circle"></i></a>
                <a class="nav-link text-white mx-2" href="/python/public/auth/logout" title="Sign Out"><i class="bi bi-box-arrow-right"></i></a>
            <?php else: ?>
                <a class="nav-link text-white mx-2" href="/python/public/login" title="Login"><i class="bi bi-box-arrow-in-right"></i></a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Search Overlay -->
<div id="searchOverlay" class="search-overlay">
    <div class="search-container">
        <div class="search-bar-wrapper">
            <i class="bi bi-search py-2"></i>
            <input type="text" id="searchInput" placeholder="Search events..." autocomplete="off">
            <button id="closeSearch" class="btn-close-custom"><i class="bi bi-x-circle-fill"></i></button>
        </div>
        <div class="quick-links" id="quickLinks">
            <p class="section-title">Quick Links</p>
            <ul>
                <li><a href="/python/public/menu">Browse All Events</a></li>
                <li><a href="/python/public/calendar">Calendar</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="/python/public/menu/inscriptions">My Inscriptions</a></li>
                <?php else: ?>
                <li><a href="/python/public/login">Sign In</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div id="searchResults" class="search-results d-none">
            <!-- Results injected here -->
        </div>
    </div>
</div>

<style>
.search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    padding-top: 100px;
}

.search-overlay.active {
    opacity: 1;
    visibility: visible;
}

.search-container {
    width: 100%;
    max-width: 680px;
    padding: 0 20px;
}

.search-bar-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 40px;
}

.search-bar-wrapper i.bi-search {
    font-size: 24px;
    color: #86868b;
    margin-right: 15px;
}

#searchInput {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 24px;
    font-weight: 400;
    color: #1d1d1f;
    outline: none;
}

#searchInput::placeholder {
    color: #86868b;
}

.btn-close-custom {
    background: none;
    border: none;
    font-size: 24px;
    color: #86868b;
    cursor: pointer;
    padding: 0;
    margin-left: 15px;
    transition: color 0.2s;
}

.btn-close-custom:hover {
    color: #1d1d1f;
}

.section-title {
    font-size: 12px;
    font-weight: 600;
    color: #86868b;
    text-transform: uppercase;
    margin-bottom: 10px;
    letter-spacing: 0.5px;
}

.quick-links ul {
    list-style: none;
    padding: 0;
}

.quick-links li {
    margin-bottom: 10px;
}

.quick-links a {
    text-decoration: none;
    color: #1d1d1f;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.2s;
}

.quick-links a:hover {
    color: #0071e3;
    text-decoration: none;
}

.search-result-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #e5e5e5;
    text-decoration: none;
    color: #1d1d1f;
    transition: background 0.2s;
}

.search-result-item:hover {
    background: rgba(0,0,0,0.02);
}

.search-result-item img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 15px;
}

.search-result-content h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.search-result-content p {
    margin: 0;
    font-size: 12px;
    color: #86868b;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchTrigger = document.querySelector('.bi-search').parentElement;
    const overlay = document.getElementById('searchOverlay');
    const closeBtn = document.getElementById('closeSearch');
    const input = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('searchResults');
    const quickLinks = document.getElementById('quickLinks');
    let dobounceTimer;

    // Open Overlay
    searchTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        overlay.classList.add('active');
        setTimeout(() => input.focus(), 100);
        document.body.style.overflow = 'hidden';
    });

    // Close Overlay
    function closeOverlay() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        input.value = '';
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('d-none');
        quickLinks.classList.remove('d-none');
    }

    closeBtn.addEventListener('click', closeOverlay);

    // Close on Escape or click outside content
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape' && overlay.classList.contains('active')) {
            closeOverlay();
        }
    });

    // Live Search
    input.addEventListener('input', function() {
        clearTimeout(dobounceTimer);
        const query = this.value.trim();

        if(query.length === 0) {
            resultsContainer.innerHTML = '';
            resultsContainer.classList.add('d-none');
            quickLinks.classList.remove('d-none');
            return;
        }

        quickLinks.classList.add('d-none');
        resultsContainer.classList.remove('d-none');
        resultsContainer.innerHTML = '<div class="text-center py-3 text-muted">Searching...</div>';

        dobounceTimer = setTimeout(() => {
            fetch('/python/public/menu/search?q=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if(data.length > 0) {
                        data.forEach(item => {
                            const html = `
                                <a href="/python/public/menu/event/${item.id}" class="search-result-item">
                                    <img src="${item.image_cover}" alt="${item.title}">
                                    <div class="search-result-content">
                                        <h6>${item.title}</h6>
                                        <p>${item.description}</p>
                                    </div>
                                </a>
                            `;
                            resultsContainer.insertAdjacentHTML('beforeend', html);
                        });
                    } else {
                        resultsContainer.innerHTML = '<div class="text-center py-3 text-muted">No events found.</div>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    resultsContainer.innerHTML = '<div class="text-center py-3 text-danger">Error searching.</div>';
                });
        }, 300);
    });
});
</script>
