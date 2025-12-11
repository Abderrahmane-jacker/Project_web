<?php require '../app/views/admin/layout/header.php'; ?>

<!-- Stats Overview -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="admin-card stats-card d-flex flex-column h-100">
            <span class="text-secondary small fw-bold text-uppercase mb-2">Total Events</span>
            <h2 class="fw-bold mb-0"><?= $data['stats']['total_events'] ?></h2>
            <span class="text-success small mt-2"><i class="bi bi-arrow-up-short"></i> Database</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-card stats-card d-flex flex-column h-100">
            <span class="text-secondary small fw-bold text-uppercase mb-2">Total Users</span>
            <h2 class="fw-bold mb-0"><?= $data['stats']['active_users'] ?></h2>
            <span class="text-success small mt-2"><i class="bi bi-people"></i> Registered</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-card stats-card d-flex flex-column h-100">
            <span class="text-secondary small fw-bold text-uppercase mb-2">Active Events</span>
            <h2 class="fw-bold mb-0"><?= $data['stats']['active_events'] ?></h2>
            <span class="text-success small mt-2"><i class="bi bi-activity"></i> Open for reg.</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-card stats-card d-flex flex-column h-100">
            <span class="text-secondary small fw-bold text-uppercase mb-2">Total Inscriptions</span>
            <h2 class="fw-bold mb-0"><?= $data['stats']['total_inscriptions'] ?></h2>
            <span class="text-secondary small mt-2">All time</span>
        </div>
    </div>
</div>

<!-- Analytics Charts -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="admin-card h-100">
            <h3 class="h5 fw-bold mb-4">Events by Category</h3>
            <div style="height: 300px; position: relative;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="admin-card h-100">
             <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h5 fw-bold mb-0">Registration Trace</h3>
                <span class="text-secondary small fw-bold text-uppercase">Last 30 Days</span>
            </div>
            <div style="height: 300px; width: 100%;">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity / Quick Actions -->
<div class="row g-4">
    <div class="col-md-8">
        <div class="admin-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h5 fw-bold mb-0">Recent Events</h3>
                <a href="/python/public/admin/events" class="text-decoration-none small fw-bold">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table-apple">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Max Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['recent_events'])): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No recent events found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data['recent_events'] as $event): ?>
                            <tr>
                                <td>
                                    <?php if ($event['est_cloture'] == 0): ?>
                                        <span class="status-badge status-active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge" style="background-color: #ffe5e5; color: #d32f2f;">Ended</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-medium"><?= htmlspecialchars($event['titre']) ?></td>
                                <td><?= htmlspecialchars($event['date_evenement']) ?></td>
                                <td><?= htmlspecialchars($event['nb_max_participants']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card h-100">
            <h3 class="h5 fw-bold mb-4">Quick Actions</h3>
            <div class="d-grid gap-3">
                <a href="/python/public/admin/events" class="btn btn-primary btn-lg w-100 fw-medium fs-6 rounded-3 d-flex align-items-center justify-content-center" style="background-color: #0071e3; border: none;">
                    <i class="bi bi-plus-lg me-2"></i> Create New Event
                </a>
                <a href="/python/public/admin/export/events" class="btn btn-light btn-lg w-100 fw-medium fs-6 rounded-3 border text-start ps-4 d-flex align-items-center">
                    <i class="bi bi-file-earmark-text me-2"></i> Export Report
                </a>
                <a href="/python/public/profile" class="btn btn-light btn-lg w-100 fw-medium fs-6 rounded-3 border text-start ps-4 d-flex align-items-center">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </div>
        </div>
    </div>
</div>

<?php require '../app/views/admin/layout/footer.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Categories Chart
    const catData = <?= json_encode($data['charts']['categories']) ?>;
    const catLabels = catData.map(item => item.nom);
    const catCounts = catData.map(item => item.count);

    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catCounts,
                backgroundColor: [
                    '#0071e3', '#34c759', '#ff9f0a', '#ff3b30', '#af52de', '#5856d6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: 'SF Pro Text' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            let value = context.raw;
                            let total = context.chart._metasets[context.datasetIndex].total;
                            let percentage = Math.round((value / total) * 100) + '%';
                            return label + value + ' (' + percentage + ')';
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // 2. Registrations Chart
    const regData = <?= json_encode($data['charts']['registrations']) ?>;
    const regLabels = regData.map(item => {
        const date = new Date(item.day); // Format YYYY-MM-DD
        return date.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });
    });
    const regCounts = regData.map(item => item.count);

    const ctxReg = document.getElementById('registrationChart').getContext('2d');
    
    // Create gradient
    const gradient = ctxReg.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 113, 227, 0.2)'); // Start color
    gradient.addColorStop(1, 'rgba(0, 113, 227, 0)');   // End color

    new Chart(ctxReg, {
        type: 'line',
        data: {
            labels: regLabels,
            datasets: [{
                label: 'Inscriptions',
                data: regCounts,
                borderColor: '#0071e3',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4, // Smooth curve
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#0071e3',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1d1d1f',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { family: 'SF Pro Text', size: 13 },
                    bodyFont: { family: 'SF Pro Text', size: 14 },
                    callbacks: {
                         label: function(context) {
                            return context.parsed.y + ' Inscriptions'; 
                         }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f5f5f7',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        font: { family: 'SF Pro Text' },
                        color: '#86868b',
                        precision: 0 // Natural numbers only
                    },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'SF Pro Text' },
                        color: '#86868b',
                        maxTicksLimit: 10 // Avoid crowding with daily data
                    },
                    border: { display: false }
                }
            }
        }
    });
});
</script>
