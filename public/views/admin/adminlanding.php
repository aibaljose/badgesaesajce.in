

<html>
<!-- Add AOS CSS and JS in head section or before closing body -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<div class="content">
    <div class="container">
        <!-- Statistics Cards Row -->
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">5</h3>
                            <p class="stat-label">Badge Categories</p>
                        </div>
                    </div>
                    <div class="stat-footer">
                        <i class="fas fa-sync"></i> Updated just now
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">12</h3>
                            <p class="stat-label">Pending Requests</p>
                        </div>
                    </div>
                    <div class="stat-footer">
                        <i class="fas fa-calendar"></i> Last 24 hours
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">45</h3>
                            <p class="stat-label">Approved Badges</p>
                        </div>
                    </div>
                    <div class="stat-footer">
                        <i class="fas fa-sync"></i> Updated just now
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">8</h3>
                            <p class="stat-label">Active Faculty</p>
                        </div>
                    </div>
                    <div class="stat-footer">
                        <i class="fas fa-sync"></i> Updated just now
                    </div>
                </div>
            </div>
        </div>

        <!-- Badge Requests Table -->
        <div class="card mb-5" data-aos="fade-up">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Badge Requests from Teachers</h5>
                    <button class="btn btn-primary btn-sm">View All</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Teacher Name</th>
                                <th>Department</th>
                                <th>Badge Requested</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Alice+Johnson" class="rounded-circle me-3" width="40" height="40">
                                        <div>
                                            <h6 class="mb-0">Dr. Alice Johnson</h6>
                                            <small class="text-muted">Senior Faculty</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Computer Science</td>
                                <td>
                                    <span class="badge bg-primary-light text-primary">Innovative Teaching</span>
                                </td>
                                <td>May 8, 2025</td>
                                <td>
                                    <span class="badge bg-warning">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-link btn-sm p-0 me-2" data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-link btn-sm p-0 me-2 text-success" data-bs-toggle="tooltip" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-link btn-sm p-0 text-danger" data-bs-toggle="tooltip" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Department Cards -->
        <div class="row g-4">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Academic Departments</h5>
                    <button class="btn btn-primary btn-sm">Manage Departments</button>
                </div>
            </div>
            
            <!-- Department Cards -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="department-card">
                    <div class="department-card-bg" style="background-image: url('/public/assets/images/chemical_home.jpg')">
                        <div class="department-overlay"></div>
                        <div class="department-content">
                            <div class="department-icon">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <div class="department-info">
                                <h4>Computer Science</h4>
                                <p>12 Faculty Members</p>
                                <div class="department-stats">
                                    <div class="stat">
                                        <span class="stat-value">24</span>
                                        <span class="stat-label">Badges</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">8</span>
                                        <span class="stat-label">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repeat similar structure for other departments -->
            <!-- Just changing the icon and title for brevity -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="department-card">
                    <div class="department-card-bg" style="background-image: url('/public/assets/images/chemical_home.jpg')">
                        <div class="department-overlay"></div>
                        <div class="department-content">
                            <div class="department-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="department-info">
                                <h4>Mechanical Engineering</h4>
                                <p>10 Faculty Members</p>
                                <div class="department-stats">
                                    <div class="stat">
                                        <span class="stat-value">18</span>
                                        <span class="stat-label">Badges</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">5</span>
                                        <span class="stat-label">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="department-card">
                    <div class="department-card-bg" style="background-image: url('/public/assets/images/chemical_home.jpg')">
                        <div class="department-overlay"></div>
                        <div class="department-content">
                            <div class="department-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="department-info">
                                <h4>Electrical Engineering</h4>
                                <p>8 Faculty Members</p>
                                <div class="department-stats">
                                    <div class="stat">
                                        <span class="stat-value">15</span>
                                        <span class="stat-label">Badges</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value">3</span>
                                        <span class="stat-label">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,.1);
}

.stat-card-inner {
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.bg-primary-light { background: rgba(106, 76, 147, 0.1); color: var(--primary-color); }
.bg-warning-light { background: rgba(251, 99, 64, 0.1); color: #fb6340; }
.bg-success-light { background: rgba(45, 206, 137, 0.1); color: #2dce89; }
.bg-info-light { background: rgba(17, 205, 239, 0.1); color: #11cdef; }

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
    color: var(--text-primary);
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
    font-weight: 500;
}

.stat-footer {
    padding: 0.75rem 1.5rem;
    border-top: 1px solid rgba(0,0,0,.05);
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 500;
}

/* Table Styles */
.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
    overflow: hidden;
}

.card-header {
    background: white;
    border-bottom: 1px solid rgba(0,0,0,.05);
    padding: 1.25rem 1.5rem;
}

.table {
    margin: 0;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 1rem 1.5rem;
    color: var(--text-secondary);
}

.table td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(106, 76, 147, 0.02);
}

/* Department Cards */
.department-card {
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
    transition: all 0.3s ease;
}

.department-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,.1);
}

.department-card-bg {
    position: relative;
    background-size: cover;
    background-position: center;
    height: 240px;
}

.department-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.8) 100%);
}

.department-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    color: white;
}

.department-icon {
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.9);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.department-info h4 {
    margin: 0 0 0.5rem;
    font-weight: 600;
}

.department-info p {
    margin: 0;
    opacity: 0.8;
    font-size: 0.875rem;
}

.department-stats {
    display: flex;
    gap: 1.5rem;
    margin-top: 1rem;
}

.stat {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 600;
}

.stat-label {
    font-size: 0.75rem;
    opacity: 0.8;
}

/* Badges */
.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
    font-size: 0.75rem;
}

.bg-primary-light {
    background: rgba(106, 76, 147, 0.1);
    color: var(--primary-color);
}

/* Buttons */
.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: #5a3f7d;
    border-color: #5a3f7d;
}

.btn-link {
    color: var(--text-primary);
    text-decoration: none;
}

.btn-link:hover {
    color: var(--primary-color);
}
</style>

<script>
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
});

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>

<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->
<!--<script src="/public/assets/js/dashboard-chart.js"></script>-->
<script src="/public/views/admin/admin_functions.js"></script>

</html>
