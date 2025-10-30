
<script src="/public/assets/js/certificate-list.js"></script>
<?php
$currentPage = 'certificate-upload';
?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="/public/assets/js/certificate-upload.js"></script>

<!-- Optional Bootstrap JS Bundle -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<main class="main-content">

<main class="container py-5">
    <header class="mb-3 mt-3">
        <h1 class="display-5 fw-bold text-dark">My Certificates</h1>
        <p class="text-muted">Certification are listed below.</p>
    </header>
    
   <header class="mb-4 mt-3">

    
    <!-- Mobile Filter Toggle Button -->
    <div class="d-md-none mb-3">
        <button class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilters" aria-expanded="false">
            <span><i class="fas fa-filter me-2"></i>Filters & Sort</span>
            <i class="fas fa-chevron-down" id="filterChevron"></i>
        </button>
    </div>
    
    <!-- Mobile Filter Card (Collapsible) -->
    <div class="collapse d-md-none" id="mobileFilters">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Search Filter -->
                    <div class="col-12">
                        <label class="form-label small fw-medium text-muted">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search certificates..." id="searchFilterMobile">
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="col-6">
                        <label class="form-label small fw-medium text-muted">Status</label>
                        <select class="form-select" id="statusFilterMobile">
                            <option value="">All Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                            <option value="reverted">Reverted</option>
                        </select>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="col-6">
                        <label class="form-label small fw-medium text-muted">Category</label>
                        <select class="form-select" id="categoryFilterMobile">
                            <option value="">All Categories</option>
                            <option value="technical">Technical</option>
                            <option value="soft-skills">Soft Skills</option>
                            <option value="certifications">Certifications</option>
                            <option value="achievements">Achievements</option>
                        </select>
                    </div>
                    
                    <!-- Sort Options -->
                    <div class="col-12">
                        <label class="form-label small fw-medium text-muted">Sort By</label>
                        <select class="form-select" id="sortFilterMobile">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="name-asc">Name A-Z</option>
                            <option value="name-desc">Name Z-A</option>
                            <option value="status">By Status</option>
                        </select>
                    </div>
                    
                    <!-- View Toggle -->
                    <div class="col-12">
                        <label class="form-label small fw-medium text-muted">View</label>
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-secondary active" id="gridViewMobile">
                                <i class="fas fa-th me-2"></i>Grid
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="listViewMobile">
                                <i class="fas fa-list me-2"></i>List
                            </button>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="col-12 pt-2">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary flex-fill" id="applyFiltersMobile">
                                <i class="fas fa-check me-2"></i>Apply Filters
                            </button>
                            <button type="button" class="btn btn-outline-danger" id="clearFiltersMobile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Desktop Filter Section (Hidden on Mobile) -->
    <div class="row g-2 mb-3 d-none d-md-flex align-items-center flex-wrap">
        <div class="col-auto flex-grow-1">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search..." id="searchFilter">
            </div>
        </div>
        <div class="col-auto">
            <select class="form-select form-select-sm" id="statusFilter">
                <option value="">Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
                <option value="reverted">Reverted</option>
            </select>
        </div>
        <div class="col-auto">
            <select class="form-select form-select-sm" id="categoryFilter">
                <option value="">Category</option>
                <option value="technical">Technical</option>
                <option value="soft-skills">Soft Skills</option>
                <option value="certifications">Certifications</option>
                <option value="achievements">Achievements</option>
            </select>
        </div>
        <div class="col-auto">
            <select class="form-select form-select-sm" id="sortFilter">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="name-asc">A-Z</option>
                <option value="name-desc">Z-A</option>
                <option value="status">Status</option>
            </select>
        </div>
        <div class="col-auto">
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="gridView" title="Grid View"><i class="fas fa-th"></i></button>
                <button type="button" class="btn btn-outline-secondary" id="listView" title="List View"><i class="fas fa-list"></i></button>
            </div>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-danger btn-sm" id="clearFilters" title="Clear Filters"><i class="fas fa-times"></i></button>
        </div>
    </div>
    
    <!-- Active Filters Display -->
    <div id="activeFilters" class="mb-3" style="display: none;">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <small class="text-muted fw-medium">Active filters:</small>
            <div id="filterTags" class="d-flex flex-wrap gap-1"></div>
        </div>
    </div>
</header>
    
        <section class="row">
                <div class="container-fluid px-0">
                        <div class="row" id="certificateViewContainer"></div>
                </div>
        </section>

        <!-- Certificate Details Modal -->
        <div class="modal fade" id="certificateDetailsModal" tabindex="-1" aria-labelledby="certificateDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="certificateDetailsModalLabel">Certificate Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="certificateDetailsBody">
                        <!-- Details will be injected by JS -->
                    </div>
                </div>
            </div>
        </div>

</main>