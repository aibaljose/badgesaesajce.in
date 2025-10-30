<div class="main-content">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Badge Management</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Badges</li>
                        </ol>
                    </nav>
                </div>
                <button class="create-badge-btn" data-bs-toggle="modal" data-bs-target="#addBadgeModal">
                    <i class="fas fa-plus"></i>
                    Create New Badge
                </button>
            </div>
        </div>

        <!-- Badges Grid -->
        <div class="badges-grid" id="badgesList">
            <!-- Badge Card Example -->
            <div class="badge-card">
                <div class="badge-status">Active</div>
                <div class="badge-image">
                    <!-- Badge shape will be rendered here -->
                    <div class="badge hexagon">
                        <div class="badge-content">
                            <i class="badge-icon fas fa-award"></i>
                            <div class="badge-title">Excellence</div>
                        </div>
                    </div>
                </div>
                <div class="badge-content">
                    <h3 class="badge-title">Academic Excellence</h3>
                    <div class="badge-type">
                        <i class="fas fa-user-graduate"></i>
                        Student
                    </div>
                </div>
                <div class="badge-actions">
                    <button class="badge-action-btn btn btn-light" title="View Details">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                </div>
            </div>
            <!-- More badge cards will be dynamically added here -->
        </div>
    </div>
</div>

<!-- Add Badge Modal -->
<div class="modal fade" id="addBadgeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content position-relative">
            <!-- Loader Overlay -->
            <div id="modalLoader" class="modal-loader-overlay d-none">
                <div class="spinner"></div>
                <p class="loader-text">Loading, please wait...</p>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Create New Badge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <form id="addBadgeForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Badge Title</label>
                                <input type="text" class="form-control" id="badgeTitle" name="badgeTitle" value="<?=htmlspecialchars($queryParams['badge_name'])?>" placeholder="Enter badge title" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Recipient Type</label>
                                <select class="form-select" id="recipientType" name="recipientType" required>
                                    <option value="Student">Student</option>
                                    <option value="Teacher">Teacher</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Badge Shape</label>
                                <select class="form-select" id="badgeShape" name="badgeShape">
                                    <option value="hexagon">Hexagon</option>
                                    <option value="circle">Circle</option>
                                    <option value="octagon">Octagon</option>
                                    <option value="pentagon">Pentagon</option>
                                </select>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Primary Color</label>
                                    <input type="color" class="form-control form-control-color w-100" id="primaryColor" name="primaryColor" value="<?=htmlspecialchars($queryParams['primary_color'])?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Secondary Color</label>
                                    <input type="color" class="form-control form-control-color w-100" id="secondaryColor" name="secondaryColor" value="<?=htmlspecialchars($queryParams['secondary_color'])?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Badge Icon</label>
                                <select class="form-select" id="badgeIcon" name="badgeIcon">
                                    <option value="fa-award">Award</option>
                                    <option value="fa-medal">Medal</option>
                                    <option value="fa-trophy">Trophy</option>
                                    <option value="fa-star">Star</option>
                                    <option value="fa-certificate">Certificate</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Badge Description</label>
                                <textarea class="form-control" id="badgeDescription" name="badgeDescription" placeholder="Describe the badge and its criteria" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            
                            <input type="hidden" id="admin_id" name="admin_id" value="">
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="badge-preview-container">
                            <h6 class="text-center mb-4">Preview</h6>
                            <div id="badgePreview" class="badge-preview d-flex justify-content-center align-items-center">
                                <!-- Badge will be rendered here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-success px-4" id="createBadge">Create Badge</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Form Styles */
.form-label {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid rgba(0,0,0,.1);
    border-radius: 0.5rem;
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(106, 76, 147, 0.1);
}

.form-control::placeholder {
    color: #adb5bd;
}

.form-control-color {
    height: 38px;
    padding: 0.375rem;
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,.1);
}

.modal-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
    padding: 1.25rem 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0,0,0,.05);
    padding: 1.25rem 1.5rem;
}

.modal-title {
    font-weight: 600;
    color: var(--text-primary);
}

/* Badge Preview */
.badge-preview-container {
    background: #f8f9fe;
    border: 1px solid rgba(0,0,0,.05);
}

/* Breadcrumb */
.breadcrumb {
    font-size: 0.875rem;
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--text-secondary);
}

/* Button Styles */
.btn {
    font-weight: 500;
    padding: 0.625rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
}

.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: #5a3f7d;
    border-color: #5a3f7d;
}

.btn-light {
    background: #f8f9fe;
    border-color: #f8f9fe;
    color: var(--text-primary);
}

.btn-light:hover {
    background: #edf0f9;
    border-color: #edf0f9;
}

/* Page Title */
h4 {
    color: var(--text-primary);
    font-weight: 600;
}

/* Ensure Font Awesome is loaded */
.fa, .fas {
    font-family: 'Font Awesome 5 Free' !important;
    font-weight: 900;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<link href="/public/assets/css/badgecreator.css" rel="stylesheet">
<script src="/public/assets/js/badgecreator.js"></script>
<script src="/public/views/admin/admin_functions.js"></script>
<script src="/public/assets/js/badgeSvgTemplates.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</html>