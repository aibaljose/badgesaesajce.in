<div class="container mt-5">
    <!-- Profile Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start">
                    <img src="/assets/images/profile-placeholder.jpg" 
                         class="rounded-circle img-thumbnail" 
                         width="150" 
                         height="150" 
                         alt="Student Profile">
                </div>
                <div class="col-md-8">
                    <h3 class="mb-1">John Doe</h3>
                    <p class="text-muted mb-2">Student ID: STU001</p>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-graduation-cap me-2"></i>
                        <span>Computer Science Engineering</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-graduate me-2"></i>
                        <span>Third Year</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Student Badges</h5>
                <!-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBadgeModal">
                    <i class="fas fa-plus me-1"></i> Add Badge
                </button> -->
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <!-- Sample Badge 1 -->
                <div class="col-md-4 col-lg-3">
                    <div class="badge-card" data-bs-toggle="modal" data-bs-target="#editBadgeModal1">
                        <div class="badge-content text-center p-3">
                            <div class="badge-icon mb-3">
                                <i class="fas fa-award fa-3x text-primary"></i>
                            </div>
                            <h6 class="badge-title mb-1">Technical Excellence</h6>
                            <small class="text-muted">Awarded: Jan 2024</small>
                        </div>
                    </div>
                </div>

                <!-- Sample Badge 2 -->
                <div class="col-md-4 col-lg-3">
                    <div class="badge-card" data-bs-toggle="modal" data-bs-target="#editBadgeModal2">
                        <div class="badge-content text-center p-3">
                            <div class="badge-icon mb-3">
                                <i class="fas fa-code fa-3x text-success"></i>
                            </div>
                            <h6 class="badge-title mb-1">Coding Champion</h6>
                            <small class="text-muted">Awarded: Mar 2024</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Badge Modal -->
<div class="modal fade" id="editBadgeModal1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Badge: Technical Excellence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Badge Name</label>
                        <input type="text" class="form-control" value="Technical Excellence">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Award Date</label>
                        <input type="date" class="form-control" value="2024-01-15">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3">Awarded for exceptional technical skills and innovation.</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-2">Remove Badge</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Badge Modal -->
<!-- <div class="modal fade" id="addBadgeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Badge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Select Badge</label>
                        <select class="form-select">
                            <option selected>Choose a badge...</option>
                            <option>Leadership Excellence</option>
                            <option>Innovation Star</option>
                            <option>Team Player</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Award Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comments</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Badge</button>
            </div>
        </div>
    </div>
</div> -->

<style>
.badge-card {
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.badge-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,.1);
}

.badge-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge-content {
    background: #fff;
    border-radius: .25rem;
}

.img-thumbnail {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 50%;
    max-width: 100%;
    height: auto;
}
</style>