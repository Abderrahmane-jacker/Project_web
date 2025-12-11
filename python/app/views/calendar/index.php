<?php require '../app/views/layouts/header.php'; ?>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>
    :root {
        --fc-border-color: #f5f5f7;
        --fc-button-text-color: #1d1d1f;
        --fc-button-bg-color: rgba(0,0,0,0.05);
        --fc-button-border-color: transparent;
        --fc-button-hover-bg-color: rgba(0,0,0,0.1);
        --fc-button-active-bg-color: #0071e3;
        --fc-button-active-border-color: transparent;
        --fc-today-bg-color: rgba(0, 113, 227, 0.05);
        --fc-neutral-bg-color: #fbfbfd;
    }

    body {
        background-color: #fbfbfd;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .calendar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .calendar-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.02);
    }

    /* Apple-style Header */
    .fc-toolbar-title {
        font-size: 24px !important;
        font-weight: 700 !important;
        color: #1d1d1f;
    }

    /* Buttons */
    .fc-button {
        background-color: var(--fc-button-bg-color) !important;
        border: none !important;
        color: #1d1d1f !important;
        font-weight: 500 !important;
        text-transform: capitalize !important;
        border-radius: 12px !important;
        padding: 8px 16px !important;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .fc-button:hover {
        background-color: var(--fc-button-hover-bg-color) !important;
    }

    .fc-button-active {
        background-color: #0071e3 !important;
        color: #fff !important;
    }

    /* Grid Styling */
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f0f0f5;
    }

    .fc-col-header-cell {
        padding: 15px 0 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #86868b;
        background-color: #fff;
    }

    .fc-daygrid-day-number {
        font-size: 14px;
        font-weight: 500;
        color: #1d1d1f;
        padding: 10px 12px !important;
    }

    /* Events */
    .fc-event {
        border: none !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        cursor: pointer;
        transition: transform 0.1s;
    }

    .fc-event:hover {
        transform: scale(0.98);
        filter: brightness(0.95);
    }

    .fc-event-title, .fc-event-time {
        font-family: inherit;
    }

    /* View Adjustments */
    .fc-view-harness {
        margin-top: 20px;
    }
    
    /* Category Filter Pills */
    .category-filter-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .cat-pill {
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #d1d1d6;
        background: #fff;
        color: #1d1d1f;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .cat-pill:hover {
        background: #f5f5f7;
    }

    .cat-pill.active {
        background: #0071e3;
        color: #fff;
        border-color: #0071e3;
    }
</style>

<div class="calendar-container" style="padding-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Events Calendar</h1>
            <p class="text-secondary mb-0">Overview of all upcoming activities.</p>
        </div>
        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="/python/public/admin/events" class="btn btn-dark rounded-pill px-4">Manage Events</a>
        <?php endif; ?>
    </div>

    <!-- Category Filter Pills -->
    <div class="category-filter-pills">
        <button class="cat-pill active" data-category="all">All Categories</button>
        <?php 
        $catColors = ['#0071e3', '#34c759', '#ff9f0a', '#ff3b30', '#af52de', '#5856d6'];
        $i = 0;
        if(isset($data['categories']) && is_array($data['categories'])):
            foreach($data['categories'] as $cat): 
                $color = $catColors[$i % count($catColors)];
            ?>
                <button class="cat-pill" data-category="<?= $cat['id'] ?>" data-color="<?= $color ?>">
                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: <?= $color ?>; margin-right: 6px;"></span>
                    <?= htmlspecialchars($cat['nom']) ?>
                </button>
            <?php $i++; endforeach; 
        endif;
        ?>
    </div>

    <div class="calendar-card">
        <div id='calendar'></div>
    </div>
</div>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var allEvents = [];
        var currentFilter = 'all';

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            themeSystem: 'standard',
            height: 'auto',
            contentHeight: 700,
            aspectRatio: 1.8,
            handleWindowResize: true,
            stickyHeaderDates: true,
            
            // Fetch Events
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('/python/public/calendar/api/events')
                    .then(response => response.json())
                    .then(data => {
                        allEvents = data;
                        successCallback(filterEvents(data, currentFilter));
                    })
                    .catch(error => failureCallback(error));
            },
            
            // Interaction
            editable: false,
            droppable: false,
            
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault();
                }
            }
        });
        calendar.render();

        // Filter function
        function filterEvents(events, categoryId) {
            if (categoryId === 'all') return events;
            return events.filter(e => e.categoryId == categoryId);
        }

        // Category filter click handlers
        document.querySelectorAll('.cat-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                // Update active state
                document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                // Update filter and refetch
                currentFilter = this.dataset.category;
                calendar.refetchEvents();
            });
        });
    });
</script>

<?php require '../app/views/layouts/footer.php'; ?>
