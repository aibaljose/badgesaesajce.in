$(document).ready(function() {
    // Load certificates on page load
    loadCertificates();
    
    // Event handlers
    $('#statusFilter').on('change', loadCertificates);
    $('#searchInput').on('input', debounce(loadCertificates, 500));

    // Handle review button clicks
    $(document).on('click', '.review-btn', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const action = button.data('action');
        const certId = $('#certificateModal').data('certId');
        const comment = $('#reviewComment').val();

        updateCertificateStatus(certId, action, comment);
    });
});
function loadCertificates() {
    const status = $('#statusFilter').val();
    const search = $('#searchInput').val();
    
    
    
    
    $.ajax({
        url: '/api',
        type: 'POST',
        dataType: 'json',
        data: {
            method: 'getTeacherCertificates',
            status: status,
            search: search
        },
        beforeSend: function () {
            $('#certificatesList').html(`
                <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
        },
        success: function (response) {
            try {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                if (data && data.status && Array.isArray(data.data)) {
                    if (data.data.length === 0) {
                        $('#certificatesList').html(`
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-certificate fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted">No certificates found</h5>
                                <p class="text-muted">Try adjusting your search or filter criteria</p>
                            </div>
                        `);
                        return;
                    }

                    // Group certificates by student_id
                    const grouped = {};
                    data.data.forEach(cert => {
                        if (!grouped[cert.student_id]) grouped[cert.student_id] = [];
                        grouped[cert.student_id].push(cert);
                    });

                    let html = '<div class="row g-4">';

                    Object.keys(grouped).forEach(studentId => {
                        const certs = grouped[studentId];
                        const primaryCert = certs[0]; // Use first certificate for profile info
                        const studentName = `Student ${studentId}`; // You can replace with actual name if available
                        const mostRecentStatus = getMostRecentStatus(certs);
                        const statusBadgeClass = getStatusBadgeClass(mostRecentStatus);
                        const statusText = getStatusText(mostRecentStatus);
                        
                        html += `
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="card border-0 shadow-sm" style="border-radius: 16px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'">
                                    
                                    <!-- Profile Header -->
                                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center" style="padding: 20px 20px 10px 20px;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-lock me-2 text-muted" style="font-size: 14px;"></i>
                                            <span class="fw-bold text-dark" style="font-size: 16px;">#${studentId}</span>
                                        </div>
                                        <span class="badge ${statusBadgeClass}" style="padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                            ${statusText}
                                        </span>
                                    </div>

                                    <!-- Profile Info -->
                                    <div class="card-body" style="padding: 0 20px 20px 20px;">
                                        <!-- Student Profile -->
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                                <span class="text-white fw-bold" style="font-size: 18px;">${studentId.substring(0, 2).toUpperCase()}</span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-dark mb-1" style="font-size: 16px;">${studentName}</div>
                                                <div class="text-muted" style="font-size: 14px;">${formatDate(primaryCert.created_at)}</div>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="text-muted small mb-1">Total Certificates</div>
                                                    <div class="fw-semibold text-dark" style="font-size: 14px;">${certs.length}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-muted small mb-1">Student ID</div>
                                                    <div class="fw-semibold text-dark" style="font-size: 14px;">${studentId}</div>
                                                </div>
                                            </div>
                                        </div>

                                     

                                        <!-- Certificates Dropdown -->
                                        <div class="dropdown mb-3">
                                            <button class="btn btn-outline-primary dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" style="border-radius: 8px; padding: 10px 15px;">
                                                <span><i class="fas fa-certificate me-2"></i>View All Certificates (${certs.length})</span>
                                            </button>
                                            <ul class="dropdown-menu w-100 shadow-lg" style="border-radius: 12px; border: none; max-height: 400px; overflow-y: auto;">
                                                <li class="dropdown-header fw-bold text-primary">
                                                    <i class="fas fa-list me-2"></i>Certificate List
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                ${certs.map(cert => `
                                                    <li>
                                                        <div class="dropdown-item-text px-3 py-2" style="border-bottom: 1px solid #f1f5f9;">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="flex-grow-1">
                                                                    <div class="fw-semibold text-dark mb-1" style="font-size: 13px;">${cert.certification_title}</div>
                                                                    <div class="text-muted small">${cert.certification_mode}</div>
                                                                    <div class="text-muted small">
                                                                        <i class="fas fa-calendar me-1"></i>${formatDate(cert.created_at)}
                                                                    </div>
                                                                </div>
                                                                <div class="ms-2">
                                                                    <span class="badge ${getStatusBadgeClass(cert.status)}" style="font-size: 9px; padding: 3px 6px; border-radius: 10px;">
                                                                        ${cert.status.toUpperCase()}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-1 mt-2">
                                                                <button class="btn btn-outline-primary btn-sm" style="font-size: 10px; padding: 2px 8px; border-radius: 4px;" onclick="viewCertificate('${cert.id}')">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-outline-success btn-sm" style="font-size: 10px; padding: 2px 8px; border-radius: 4px;" onclick="approveCertificate('${cert.id}')">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger btn-sm" style="font-size: 10px; padding: 2px 8px; border-radius: 4px;" onclick="declineCertificate('${cert.id}')">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                `).join('')}
                                            </ul>
                                        </div>

                                        <!-- Main Action Buttons -->
                                
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    html += '</div>';
                    $('#certificatesList').html(html);
                }
            } catch (error) {
                console.error('Error processing certificates:', error);
                $('#certificatesList').html(`
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                        </div>
                        <h5 class="text-danger">Error Processing Data</h5>
                        <p class="text-muted">Please try refreshing the page</p>
                    </div>
                `);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            $('#certificatesList').html(`
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-wifi fa-3x text-danger"></i>
                    </div>
                    <h5 class="text-danger">Connection Error</h5>
                    <p class="text-muted">Unable to load certificates. Please check your connection.</p>
                    <button class="btn btn-primary" onclick="loadCertificates()">
                        <i class="fas fa-redo me-2"></i>Retry
                    </button>
                </div>
            `);
        }
    });
}

// Helper function to get most recent status
function getMostRecentStatus(certs) {
    // Sort by date and get the most recent certificate's status
    const sortedCerts = certs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    return sortedCerts[0].status;
}

// Helper function to get status badge class
function getStatusBadgeClass(status) {
    const statusClasses = {
        'pending': 'bg-warning text-dark',
        'approved': 'bg-success text-white',
        'rejected': 'bg-danger text-white',
        'draft': 'bg-secondary text-white',
        'regular': 'bg-info text-white',
        'member': 'bg-success text-white',
        'assurance': 'bg-warning text-dark'
    };
    return statusClasses[status.toLowerCase()] || 'bg-secondary text-white';
}

// Helper function to get status text
function getStatusText(status) {
    const statusTexts = {
        'pending': 'Regular',
        'approved': 'Member', 
        'rejected': 'Assurance',
        'draft': 'Draft'
    };
    return statusTexts[status.toLowerCase()] || status.charAt(0).toUpperCase() + status.slice(1);
}

// Helper function to format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = date.getDate();
    const month = date.toLocaleString('en-US', { month: 'short' });
    const year = date.getFullYear();
    return `${day} ${month}, ${year}`;
}

// Certificate action functions
function viewCertificate(id) {
    console.log('Viewing certificate:', id);
    // Add your view logic here
}

function approveCertificate(id) {
    console.log('Approving certificate:', id);
    // Add your approve logic here
}

function declineCertificate(id) {
    console.log('Declining certificate:', id);
    // Add your decline logic here
}

function approveAllCertificates(studentId) {
    console.log('Approving all certificates for student:', studentId);
    // Add your approve all logic here
}

function declineAllCertificates(studentId) {
    console.log('Declining all certificates for student:', studentId);
    // Add your decline all logic here
}
function viewCertificate(certId) {
    if (!certId) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Invalid certificate ID',
            confirmButtonColor: '#6c4298'
        });
        return;
    }

    $.ajax({
        url: '/api',
        type: 'POST',
        dataType: 'json',
        data: {
            method: 'getCertificateDetails',
            cert_id: certId
        },
        success: function(response) {
            try {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (data && data.status && data.data) {
                    showCertificateModal(data.data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to load certificate details',
                        confirmButtonColor: '#6c4298'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error processing certificate data',
                    confirmButtonColor: '#6c4298'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to connect to server',
                confirmButtonColor: '#6c4298'
            });
        }
    });
}

function showCertificateModal(cert) {
    try {
        // Set modal data
        $('#certificateModal').data('certId', cert.id);
        
        // Set certificate details
        $('#studentId').text(cert.student_id || 'N/A');
        $('#certTitle').text(cert.certification_title || 'N/A');
        $('#certDesc').text(cert.certification_desc || 'N/A');
        $('#startDate').text(formatDate(cert.start_date));
        $('#endDate').text(formatDate(cert.end_date));
        $('#certMode').text(cert.certification_mode || 'N/A');
        
        // Set status with appropriate badge class
        const statusBadge = getStatusBadgeClass(cert.status);
        $('#certStatus').text(cert.status ? cert.status.toUpperCase() : 'N/A')
                       .removeClass()
                       .addClass(`badge ${statusBadge}`);
        
        $('#submissionDate').text(formatDate(cert.created_at));
        
        // Handle certificate preview and download
        if (cert.certification_file) {
            const fileExt = cert.certification_file.split('.').pop().toLowerCase();
            const downloadLink = $('#downloadCertificate');
            
            // Set download link
            downloadLink.attr('href', cert.certification_file)
                      .removeClass('d-none');
            
            // Set preview based on file type
            if (['pdf', 'jpg', 'jpeg', 'png'].includes(fileExt)) {
                if (fileExt === 'pdf') {
                    $('.certificate-preview').html(`
                        <embed src="${cert.certification_file}" type="application/pdf" width="100%" height="500px">
                    `);
                } else {
                    $('.certificate-preview').html(`
                        <img src="${cert.certification_file}" class="img-fluid" alt="Certificate">
                    `);
                }
            } else {
                $('.certificate-preview').html('<p class="text-center">Unsupported file format</p>');
            }
        } else {
            $('.certificate-preview').html('<p class="text-center">No file available</p>');
            $('#downloadCertificate').addClass('d-none');
        }
        
        // Set existing comment if any
        $('#reviewComment').val(cert.teacher_comment || '');
        
        // Show the modal
        $('#certificateModal').modal('show');
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Error displaying certificate details',
            confirmButtonColor: '#6c4298'
        });
    }
}

function updateCertificateStatus(certId, action, comment) {
    // Validate comment
    if (!comment || comment.trim() === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Comment Required',
            text: 'Please add a comment before updating the status',
            confirmButtonColor: '#6c4298'
        });
        return;
    }

    // Handle different actions
    switch(action) {
        case 'approve':
            // First, fetch available badges
            $.ajax({
                url: '/api',
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'getAvailableBadges'
                },
                success: function(response) {
                    if (response.status && response.data) {
                        let badgeOptions = response.data.map(badge => 
                            `<option value="${badge.badge_id}">
                                ${badge.badge_name}
                            </option>`
                        ).join('');

                        Swal.fire({
                            title: 'Select Badge to Award',
                            html: `
                                <div class="mb-3">
                                    <label class="form-label">Select a badge to award:</label>
                                    <select id="badgeSelect" class="form-select">
                                        <option value="">Choose a badge...</option>
                                        ${badgeOptions}
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Approval Comment:</label>
                                    <textarea id="approvalComment" class="form-control">${comment}</textarea>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Approve & Award Badge',
                            confirmButtonColor: '#6c4298',
                            preConfirm: () => {
                                const selectedBadge = document.getElementById('badgeSelect').value;
                                const approvalComment = document.getElementById('approvalComment').value;
                                
                                if (!selectedBadge) {
                                    Swal.showValidationMessage('Please select a badge');
                                    return false;
                                }
                                if (!approvalComment.trim()) {
                                    Swal.showValidationMessage('Please provide an approval comment');
                                    return false;
                                }
                                
                                return {
                                    badge_id: selectedBadge,
                                    teacher_comment: approvalComment
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                submitStatusUpdate(certId, action, result.value);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load available badges',
                            confirmButtonColor: '#6c4298'
                        });
                    }
                }
            });
            break;

        case 'reject':
            Swal.fire({
                title: 'Provide Rejection Reason',
                html: `
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason:</label>
                        <textarea id="rejectionReason" class="form-control" rows="3" 
                            placeholder="Please provide a detailed reason for rejection...">${comment}</textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Reject Certificate',
                confirmButtonColor: '#dc3545',
                preConfirm: () => {
                    const reason = document.getElementById('rejectionReason').value;
                    if (!reason.trim()) {
                        Swal.showValidationMessage('Please provide a rejection reason');
                        return false;
                    }
                    return {
                        rejection_reason: reason,
                        teacher_comment: reason
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitStatusUpdate(certId, action, result.value);
                }
            });
            break;

        case 'revert':
            Swal.fire({
                title: 'Provide Revert Reason',
                html: `
                    <div class="mb-3">
                        <label class="form-label">Revert Reason & Suggestions:</label>
                        <textarea id="revertReason" class="form-control" rows="3" 
                            placeholder="Please provide reasons and suggestions for improvement...">${comment}</textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Revert for Changes',
                confirmButtonColor: '#ffc107',
                preConfirm: () => {
                    const reason = document.getElementById('revertReason').value;
                    if (!reason.trim()) {
                        Swal.showValidationMessage('Please provide revert reason and suggestions');
                        return false;
                    }
                    return {
                        revert_reason: reason,
                        teacher_comment: reason
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitStatusUpdate(certId, action, result.value);
                }
            });
            break;
    }
}

function submitStatusUpdate(certId, action, data) {
    // Show loading state
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait while we update the certificate status',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Prepare data for submission
    const submitData = {
        method: 'updateStatus',
        certificate_id: certId,
        status_action: action,
        ...data
    };

    // Send update request
    $.ajax({
        url: '/api',
        type: 'POST',
        dataType: 'json',
        data: submitData,
        success: function(response) {
            if (response.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonColor: '#6c4298'
                }).then(() => {
                    $('#certificateModal').modal('hide');
                    loadCertificates(); // Reload the certificates list
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Failed to update certificate status',
                    confirmButtonColor: '#6c4298'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to connect to server. Please try again.',
                confirmButtonColor: '#6c4298'
            });
        }
    });
}

function getStatusBadgeClass(status) {
    const classes = {
        'pending': 'bg-warning',
        'approved': 'bg-success',
        'rejected': 'bg-danger',
        'reverted': 'bg-info'
    };
    return classes[status.toLowerCase()] || 'bg-secondary';
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    } catch (error) {
        return dateString;
    }
}

function debounce(func, wait) {
    let timeout;
    return function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, arguments), wait);
    };
} 