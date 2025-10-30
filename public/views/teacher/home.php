<?php 
$currentPage = 'home';
session_start(); // ✅ Ensure session is started if needed for data access
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="/public/assets/js/teacher/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>
    body {
        background-color: #f4f5f7;
        font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-card {
        border: none;
        border-radius: .75rem;
        background: linear-gradient(145deg, #ffffff, #f1f1f1);
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        padding: .6rem;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }

    .card-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: .5rem;
        color: #fff;
        font-size: 1rem;
    }

    .stretched-link::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .table thead {
        background-color: #f0f2f5;
    }

    .table td, .table th {
        vertical-align: middle;
        border: none;
    }

    .table-hover tbody tr:hover {
        background-color: #f9f9fc;
    }

    .table thead th {
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
    }

    .badge { font-size: .72rem; padding: .3em .55em; }

    .btn-outline-primary { border-radius: .4rem; padding: .25rem .6rem; font-size: .88rem; }

    .recent-table { border-radius: .75rem; overflow: hidden; }

    .card-header h5 { font-weight: 600; font-size: 1rem; }

    /* Progress Circle Style - Optional for visual counters */
    .progress-circle {
        width: 42px;
        height: 42px;
        background: conic-gradient(#0d6efd 75%, #e9ecef 75%);
        border-radius: 50%;
        position: relative;
    }

    .progress-circle span { position: absolute; inset: 0; display:flex; align-items:center; justify-content:center; font-size: .72rem; font-weight:700; }

    /* Make layout more compact on smaller screens */
    @media (max-width: 992px) {
        .card-body { padding: .7rem !important; }
        .container-fluid { padding-left: .8rem; padding-right: .8rem; }
        .dashboard-card .fw-bold { font-size: 1.35rem; }
        .card-icon { width:36px; height:36px; font-size:.95rem; }
        .recent-table table td, .recent-table table th { font-size: .88rem; padding: .45rem .6rem; }
    }

    @media (max-width: 576px) {
        .row.g-4 { gap: .7rem; }
        .dashboard-card { padding: .5rem; }
        .dashboard-card .fw-bold { font-size: 1.15rem; }
        .card-icon { width:32px; height:32px; }
        .card-header h5 { font-size: .95rem; }
        canvas#topStudentsChart { height: 160px !important; }
    }
</style>
 <div class="content-wrapper">
<div class="main-container">
    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid py-4">

            <div class="row g-4">
                <!-- Pending Certificates -->
                <div class="col-lg-4 col-md-6">
                    <div class="card dashboard-card position-relative">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Pending Certificates</p>
                                <h2 class="fw-bold mb-0" id="pending">15</h2>
                            </div>
                            <div class="card-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <a href="certificates.php?status=pending" class="stretched-link"></a>
                    </div>
                </div>

                <!-- Approved Certificates -->
                <div class="col-lg-4 col-md-6">
                    <div class="card dashboard-card position-relative">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Approved Certificates</p>
                                <h2 class="fw-bold mb-0" id="approved">45</h2>
                            </div>
                            <div class="card-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <a href="certificates.php?status=approved" class="stretched-link"></a>
                    </div>
                </div>

                <!-- Available Badges -->
                <div class="col-lg-4 col-md-6">
                    <div class="card dashboard-card position-relative">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Available Badges</p>
                                <h2 class="fw-bold mb-0" id="badges">8</h2>
                            </div>
                            <div class="card-icon bg-info">
                                <i class="fas fa-award"></i>
                            </div>
                        </div>
                        <a href="badges.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <!-- Top Performing Students - Graph -->
<div class="card mt-4 border-0 rounded-4 shadow-sm bg-white">
    <div class="card-header bg-white border-bottom-0 py-3">
        <h5 class="mb-0 fw-semibold">Top Performing Students (Badges)</h5>
    </div>
    <div class="card-body">
        <canvas id="topStudentsChart" height="200"></canvas>
    </div>
</div>


            <!-- Recent Submissions -->
            <div class="card mt-5 border-0 rounded-4 shadow-sm bg-white recent-table">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="mb-0 fw-semibold">Recent Certificate Submissions</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th>Student Name</th>
                                    <th>Certificate Title</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>Web Development</td>
                                    <td>2024-03-15</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>
                                        <a href="review-certificate.php?id=1" class="btn btn-sm btn-outline-primary">Review</a>
                                    </td>
                                </tr>
                                <!-- Dynamically injected rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('topStudentsChart').getContext('2d');

    const topStudentsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Alice Joseph', 'Ravi Kumar', 'Priya S', 'John Doe', 'Sneha M'],
            datasets: [{
                label: 'Badges Earned',
                data: [12, 10, 8, 7, 5],
                backgroundColor: [
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                borderRadius: 10,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Badges'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Student Name'
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => ` ${context.raw} Badges`
                    }
                }
            }
        }
    });
</script>

<?php include 'layout/footer.php'; ?>
