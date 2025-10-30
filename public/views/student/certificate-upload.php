<?php
$currentPage = 'certificate-upload';
?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="/public/assets/js/certificate-upload.js"></script>

<!-- Optional Bootstrap JS Bundle -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<main class="main-content">

<main class="container py-5 mt-3">
    <header class="mb-4">
        <h1 class="display-5 fw-bold text-dark">Upload Certificate</h1>
        <p class="text-muted">Fill out the form below to submit your certificate for review.</p>
    </header>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4 p-4">
                <form id="studentForm" class="needs-validation" novalidate enctype="multipart/form-data">
                    <input type="hidden" name="status" value="pending">
                    <?php
                    if (isset($_SESSION['auth_user']) && isset($_SESSION['auth_user']['admission_no'])) {
                        $student_id = $_SESSION['auth_user']['admission_no'];
                        echo '<input type="hidden" name="student_id" value="' . htmlspecialchars($student_id) . '">';
                    }
                    ?>

                    <div class="mb-3">
                        <label for="certification_title" class="form-label">Certificate Title*</label>
                        <input type="text" class="form-control" id="certification_title" name="certification_title" required>
                        <div class="invalid-feedback">Please provide a certificate title.</div>
                    </div>

                    <div class="mb-3">
                        <label for="certification_desc" class="form-label">Description*</label>
                        <textarea class="form-control" id="certification_desc" name="certification_desc" rows="4" required></textarea>
                        <div class="invalid-feedback">Please provide a description.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="issue_date" class="form-label">Issue Date*</label>
                            <input type="date" class="form-control" id="issue_date" name="issue_date" required>
                            <div class="invalid-feedback">Please select an issue date.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="issue_sem" class="form-label">Issued Semester*</label>
                            <select class="form-select" id="issue_sem" name="issue_sem" required>
                                <option value="">Select Semester</option>
                                <option value="1">S1</option>
                                <option value="2">S2</option>
                                <option value="3">S3</option>
                                <option value="4">S4</option>
                                <option value="5">S5</option>
                                <option value="6">S6</option>
                            </select>
                            <div class="invalid-feedback">Please select a semester.</div>
                        </div>
                    </div>
                   

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date*</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                            <div class="invalid-feedback">Please select a start date.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date*</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                            <div class="invalid-feedback">Please select an end date.</div>
                        </div>
                    </div>
 <div class="row g-3 mt-3">
             
                        <div class="col-md-6">
                            <label for="certificate_categories" class="form-label">Certificate categories*</label>
                            <select class="form-select" id="certificate_categories" name="certificate_categories" required>
                            </select>
                            <div class="invalid-feedback">Please select a semester.</div>
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="certification_mode" class="form-label">Mode of Learning*</label>
                            <select class="form-select" id="certification_mode" name="certification_mode" required>
                                <option value="">Select Mode</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                            <div class="invalid-feedback">Please select a mode.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="certification_file" class="form-label">Upload Certificate*</label>
                            <input class="form-control" type="file" id="certification_file" name="certification_file" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="invalid-feedback">Please upload a valid file.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="fas fa-upload me-2"></i>Submit Certificate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-light p-4 rounded-4 border">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-info-circle text-primary fs-4"></i>
                    <h5 class="mb-0 fw-bold text-dark">Submission Guidelines</h5>
                </div>
                <ul class="list-unstyled text-muted small ps-3">
                    <li class="mb-2">Ensure all details are accurate and match the certificate.</li>
                    <li class="mb-2">Upload a clear, high-quality scan or photo of the certificate.</li>
                    <li class="mb-2">Accepted file formats: <strong>PDF, JPG, PNG</strong>.</li>
                    <li class="mb-2">Maximum file size: <strong>5MB</strong>.</li>
                    <li>Your certificate will be reviewed by an admin after submission.</li>
                </ul>
            </div>
        </div>
    </div>
</main>
