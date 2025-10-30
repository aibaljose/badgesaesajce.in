<div class="main-container">
    <?php include 'layout/sidebar.php'; ?>
    <div class="main-content">
        <div class="container">
            <div class="card dashboard-card">
                <div class="card-header bg-custom-primary text-white">
                    <h4 class="mb-0">Request New Badge</h4>
                </div>
                <div class="card-body">
                    <form id="badgeRequestForm" aria-label="Badge Request Form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="badge_name" class="form-label">Badge Name</label>
                                <input type="text" id="badge_name" name="badge_name" class="form-control" 
                                    required aria-label="Badge Name" 
                                    placeholder="Enter badge name"
                                    title="Enter the name for your badge">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="badge_icon" class="form-label">Badge Icon</label>
                                <select id="badge_icon" name="badge_icon" class="form-select" 
                                    required aria-label="Select Badge Icon"
                                    title="Choose an icon for your badge">
                                    <option value="">Select an icon</option>
                                    <option value="award">Award</option>
                                    <option value="star">Star</option>
                                    <option value="medal">Medal</option>
                                    <option value="trophy">Trophy</option>
                                    <option value="certificate">Certificate</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="badge_description" class="form-label">Description</label>
                                <textarea id="badge_description" name="badge_description" class="form-control" 
                                    rows="3" required aria-label="Badge Description" 
                                    placeholder="Enter badge description"
                                    title="Provide a description for your badge"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="primary_color" class="form-label">Primary Color</label>
                                <input type="color" id="primary_color" name="primary_color" 
                                    class="form-control form-control-color" value="#6c4298" 
                                    required aria-label="Primary Color"
                                    title="Choose primary color for your badge">
                            </div>

                            <div class="col-md-6">
                                <label for="secondary_color" class="form-label">Secondary Color</label>
                                <input type="color" id="secondary_color" name="secondary_color" 
                                    class="form-control form-control-color" value="#ffffff" 
                                    required aria-label="Secondary Color"
                                    title="Choose secondary color for your badge">
                            </div>

                            <div class="col-md-6">
                                <label for="badge_shape" class="form-label">Badge Shape</label>
                                <select id="badge_shape" name="badge_shape" class="form-select" 
                                    required aria-label="Select Badge Shape"
                                    title="Choose a shape for your badge">
                                    <option value="">Select a shape</option>
                                    <option value="circle">Circle</option>
                                    <option value="square">Square</option>
                                    <option value="shield">Shield</option>
                                    <option value="ribbon">Ribbon</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary bg-custom-primary"
                                    title="Submit badge request"
                                    aria-label="Submit badge request">
                                    <i class="fas fa-paper-plane me-2" aria-hidden="true"></i> Submit Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-color {
    -webkit-user-select: none;
    user-select: none;
}
</style>

<!-- Load dependencies -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/public/assets/js/teacher-badges.js"></script> 