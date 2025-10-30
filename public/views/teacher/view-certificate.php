<?php 
$currentPage = 'certificates';
include 'layout/header.php'; 
?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<div class="main-container" id="teacher-certificates-page">
    <?php include 'layout/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="container" style="padding-top: 5rem;">
            <!-- Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="reverted">Reverted</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search certificates">
                        </div>
                    </div>
                </div>
            </div>

        
            <!-- Certificates List with a different structure -->
            <div class="row">
                <div class="col-12">
                    <div id="certificatesList">
                        <!-- Certificates will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Certificate Review Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title">Certificate Review</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Certificate Preview</h6>
                                <a href="#" id="downloadCertificate" class="btn btn-sm btn-primary" download>
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="certificate-preview">
                                    <!-- Preview will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title border-bottom pb-2">Certificate Details</h6>
                                <div class="certificate-details">
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Student ID</small>
                                        <strong id="studentId"></strong>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Title</small>
                                        <strong id="certTitle"></strong>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Description</small>
                                        <p id="certDesc" class="mb-0"></p>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Duration</small>
                                        <div class="d-flex justify-content-between">
                                            <span id="startDate"></span>
                                            <span>to</span>
                                            <span id="endDate"></span>
                                        </div>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Mode</small>
                                        <strong id="certMode"></strong>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Status</small>
                                        <span id="certStatus" class="badge"></span>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <small class="text-muted d-block">Submitted On</small>
                                        <span id="submissionDate"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h6 class="card-title border-bottom pb-2">Review Decision</h6>
                                <textarea class="form-control mb-3" id="reviewComment" rows="3" 
                                    placeholder="Add your comments here..."></textarea>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success review-btn" data-action="approve">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-warning review-btn" data-action="revert">
                                        <i class="fas fa-undo"></i> Revert for Changes
                                    </button>
                                    <button class="btn btn-danger review-btn" data-action="reject">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student Certificates Modal (Responsive & Compact) -->
<div class="modal fade" id="studentCertificatesModal" tabindex="-1" aria-labelledby="studentCertificatesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentCertificatesLabel">Certificates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-sm-flex align-items-center justify-content-between mb-3">
                    <div class="fw-semibold small text-muted" id="studentCertsMeta"></div>
                    <div class="mt-2 mt-sm-0" style="min-width:220px;">
                        <input type="text" id="studentCertsSearch" class="form-control form-control-sm" placeholder="Search certificates" />
                    </div>
                </div>
                <div id="studentCertsContainer" class="row g-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  
</div>

<!-- Templates used by JS to render cert list -->
<template id="studentCertsItemTemplate">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="cert-item border rounded-3 p-2 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1 pe-2">
                    <div class="cert-title fw-semibold text-dark small mb-1">Title</div>
                    <div class="text-muted xsmall cert-mode">Mode</div>
                    <div class="text-muted xsmall cert-date"><i class="fas fa-calendar me-1"></i>Date</div>
                </div>
                <span class="badge cert-status xsmall"></span>
            </div>
            <div class="d-flex gap-1 mt-2">
                <button class="btn btn-outline-primary btn-sm cert-view" title="View"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-success btn-sm cert-approve" title="Approve"><i class="fas fa-check"></i></button>
                <button class="btn btn-outline-warning btn-sm cert-revert" title="Revert"><i class="fas fa-undo"></i></button>
                <button class="btn btn-outline-danger btn-sm cert-decline" title="Reject"><i class="fas fa-times"></i></button>
            </div>
        </div>
    </div>
  
</template>

<style>
    /* Page-scoped compact styles to match AES design */
    #teacher-certificates-page .card { border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); }
    #teacher-certificates-page .card-header { padding: .6rem .9rem; background-color: #fff; border-bottom: 1px solid #f1f1f4; }
    #teacher-certificates-page .card-body { padding: .9rem; }
    #teacher-certificates-page .form-control, 
    #teacher-certificates-page .form-select { padding: .4rem .6rem; border-radius: .4rem; font-size: .95rem; }
    #teacher-certificates-page .btn { border-radius: .45rem; }
    #teacher-certificates-page .btn-sm { padding: .25rem .5rem; font-size: .85rem; }
    #teacher-certificates-page .badge { font-size: .75rem; padding: .25rem .5rem; border-radius: .5rem; }
    /* AES purple primary */
    #teacher-certificates-page .btn-primary { background-color: #4A56E2; border-color: #6c4298; }
    #teacher-certificates-page .btn-primary:hover { background-color: #4A56E2; border-color: #5b3781; }
    #teacher-certificates-page .btn-outline-primary { color: #4A56E2; border-color: #6c4298; }
    #teacher-certificates-page .btn-outline-primary:hover { background-color: rgba(108,66,152,0.08); color: #5b3781; }

    /* Review modal header/style */
    #certificateModal .modal-content { border-radius: 12px; }
    #certificateModal .modal-header { background-color: #4A56E2; color: #fff; }
    #certificateModal .btn-close { filter: invert(1); }

    /* Student Certificates Modal (Responsive & Compact) */
    #studentCertificatesModal .modal-body { padding-top: .75rem; padding-bottom: .75rem; }
    #studentCertificatesModal .modal-content { border-radius: 12px; }
    #studentCertificatesModal .modal-header { background-color: #4A56E2; color: #fff; }
    #studentCertificatesModal .btn-close { filter: invert(1); }
    .cert-item { border-color: #f1f5f9 !important; }
    .cert-item .btn-sm { padding: .2rem .45rem; font-size: .8rem; border-radius: .35rem; }
    .xsmall { font-size: .78rem; }
    @media (max-width: 576px) {
        #studentCertsContainer { row-gap: .5rem; }
        .cert-item { padding: .6rem; }
    }

    /* Layout fixes: reserve space for fixed sidebar and prevent horizontal overflow */
    #teacher-certificates-page, #teacher-certificates-page .main-content { max-width: 100%; overflow-x: hidden; }
    #teacher-certificates-page .main-content { margin-left: 260px; }
    @media (max-width: 991.98px) {
        #teacher-certificates-page .main-content { margin-left: 0; }
    }
</style>
<!-- Make sure jQuery is loaded first -->
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<script>
    // Test if jQuery is working
    $(document).ready(function() {
        $('#test').html('jQuery is working');
    });
</script>
<script src="/public/assets/js/teacher-certificates.js"></script>

<?php include 'layout/footer.php'; ?>