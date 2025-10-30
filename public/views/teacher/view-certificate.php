<?php 
$currentPage = 'certificates';
include 'layout/header.php'; 
?>



<div class="main-container">
    <?php include 'layout/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="container py-4">
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

<!-- Make sure jQuery is loaded first -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Test if jQuery is working
    $(document).ready(function() {
        $('#test').html('jQuery is working');
    });
</script>
<script src="/public/assets/js/teacher-certificates.js"></script>

<?php include 'layout/footer.php'; ?>