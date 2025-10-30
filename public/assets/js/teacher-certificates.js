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
                    const studentCertsMap = {};
                    data.data.forEach(cert => {
                        if (!grouped[cert.student_id]) grouped[cert.student_id] = [];
                        grouped[cert.student_id].push(cert);
                    });

                    let html = '<div class="row g-4">';

                    Object.keys(grouped).forEach(studentId => {
                        const certs = grouped[studentId];
                        studentCertsMap[studentId] = certs;
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

                                     

                                        <!-- Certificates Modal Trigger -->
                                        <div class="mb-3">
                                            <button class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center open-cert-list" type="button" data-student-id="${studentId}" style="border-radius: 8px; padding: 10px 15px;">
                                                <span><i class="fas fa-certificate me-2"></i>View All Certificates (${certs.length})</span>
                                                <i class="fas fa-up-right-from-square ms-2 small"></i>
                                            </button>
                                        </div>

                                        <!-- Main Action Buttons -->
                                
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    html += '</div>';
                    $('#certificatesList').html(html);
                    // Expose per-student certs for modal rendering
                    window.__studentCerts = studentCertsMap;

                    // Modal open handler for certificate list (Bootstrap modal + HTML templates)
                    $(document)
                        .off('click.openCertList')
                        .on('click.openCertList', '.open-cert-list', function(e){
                            e.preventDefault();
                            const studentId = $(this).data('studentId');
                            const certs = (window.__studentCerts && window.__studentCerts[studentId]) || [];
                            try {
                                openStudentCertificatesModal(studentId, certs);
                            } catch(err) {
                                console.error('Modal open error', err);
                            }
                        });
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
    if (!id) return;
    // Fetch available badges first
    $.ajax({
        url: '/api',
        type: 'POST',
        dataType: 'json',
        data: { method: 'getAvailableBadges' },
        success: function(response) {
            const res = typeof response === 'string' ? JSON.parse(response) : response;
            if (!res || !res.status) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load badges', confirmButtonColor: '#6c4298' });
                return;
            }
            const options = (res.data || []).map(b => `<option value="${b.badge_id}">${b.badge_name}</option>`).join('');
            Swal.fire({
                title: 'Approve Certificate',
                html: `
                    <div class="mb-2 text-start">
                        <label class="form-label">Select badge to award</label>
                        <select id="swalBadge" class="form-select">
                            <option value="">Choose a badge...</option>
                            ${options}
                        </select>
                    </div>
                    <div class="text-start">
                        <label class="form-label">Approval comment</label>
                        <textarea id="swalComment" class="form-control" rows="3" placeholder="Add your comment..."></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Approve',
                confirmButtonColor: '#6c4298',
                preConfirm: () => {
                    const badge = document.getElementById('swalBadge').value;
                    const comment = document.getElementById('swalComment').value;
                    if (!badge) { Swal.showValidationMessage('Please select a badge'); return false; }
                    if (!comment.trim()) { Swal.showValidationMessage('Please provide a comment'); return false; }
                    return { badge_id: badge, teacher_comment: comment };
                }
            }).then((r) => {
                if (r.isConfirmed) {
                    submitStatusUpdate(id, 'approve', r.value);
                }
            });
        },
        error: function(){
            Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load badges', confirmButtonColor: '#6c4298' });
        }
    });
}

function declineCertificate(id) {
    if (!id) return;
    Swal.fire({
        title: 'Reject Certificate',
        html: `
            <div class="text-start">
                <label class="form-label">Rejection reason</label>
                <textarea id="swalReject" class="form-control" rows="3" placeholder="Please add the reason..."></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Reject',
        confirmButtonColor: '#dc3545',
        preConfirm: () => {
            const reason = document.getElementById('swalReject').value;
            if (!reason.trim()) { Swal.showValidationMessage('Please provide a rejection reason'); return false; }
            return { rejection_reason: reason, teacher_comment: reason };
        }
    }).then((r) => {
        if (r.isConfirmed) submitStatusUpdate(id, 'reject', r.value);
    });
}

function revertCertificate(id) {
    if (!id) return;
    Swal.fire({
        title: 'Revert for Changes',
        html: `
            <div class="text-start">
                <label class="form-label">Revert reason and suggestions</label>
                <textarea id="swalRevert" class="form-control" rows="3" placeholder="Explain what needs to change..."></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Revert',
        confirmButtonColor: '#ffc107',
        preConfirm: () => {
            const reason = document.getElementById('swalRevert').value;
            if (!reason.trim()) { Swal.showValidationMessage('Please provide a revert reason'); return false; }
            return { revert_reason: reason, teacher_comment: reason };
        }
    }).then((r) => {
        if (r.isConfirmed) submitStatusUpdate(id, 'revert', r.value);
    });
}

function approveAllCertificates(studentId) {
    console.log('Approving all certificates for student:', studentId);
    // Add your approve all logic here
}

function declineAllCertificates(studentId) {
    console.log('Declining all certificates for student:', studentId);
    // Add your decline all logic here
}
// Open Bootstrap modal and render items using HTML templates defined in the page
function openStudentCertificatesModal(studentId, certs) {
    const modalEl = document.getElementById('studentCertificatesModal');
    const titleEl = document.getElementById('studentCertificatesLabel');
    const metaEl = document.getElementById('studentCertsMeta');
    const containerEl = document.getElementById('studentCertsContainer');
    const searchEl = document.getElementById('studentCertsSearch');
    const itemTpl = document.getElementById('studentCertsItemTemplate');

    if (!modalEl || !containerEl || !itemTpl) {
        console.error('Student certificates modal/templates not found');
        return;
    }

    // Set header
    if (titleEl) titleEl.textContent = `Certificates - #${studentId}`;
    if (metaEl) metaEl.textContent = `${certs.length} certificate(s)`;

    // Render items
    function render(list) {
        containerEl.innerHTML = '';
        if (!Array.isArray(list) || list.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'text-center text-muted py-4';
            empty.textContent = 'No certificates available';
            containerEl.appendChild(empty);
            return;
        }
        list.forEach(cert => {
            const node = itemTpl.content.cloneNode(true);
            const wrap = node.querySelector('.cert-item');
            node.querySelector('.cert-title').textContent = cert.certification_title || 'Untitled';
            node.querySelector('.cert-mode').textContent = cert.certification_mode || '—';
            node.querySelector('.cert-date').innerHTML = `<i class="fas fa-calendar me-1"></i>${formatDate(cert.created_at)}`;
            const statusEl = node.querySelector('.cert-status');
            statusEl.className = `badge cert-status xsmall ${getStatusBadgeClass(cert.status)}`;
            statusEl.textContent = (cert.status || '').toString().toUpperCase();

            // Wire actions
            node.querySelector('.cert-view').addEventListener('click', () => viewCertificate(cert.id));
            node.querySelector('.cert-approve').addEventListener('click', () => approveCertificate(cert.id));
            const revertBtn = node.querySelector('.cert-revert');
            if (revertBtn) revertBtn.addEventListener('click', () => revertCertificate(cert.id));
            node.querySelector('.cert-decline').addEventListener('click', () => declineCertificate(cert.id));

            containerEl.appendChild(node);
        });
    }

    render(certs);

    // Simple search filter
    if (searchEl) {
        searchEl.value = '';
        const handle = debounce(() => {
            const q = searchEl.value.trim().toLowerCase();
            if (!q) return render(certs);
            const filtered = certs.filter(c =>
                (c.certification_title || '').toLowerCase().includes(q) ||
                (c.certification_mode || '').toLowerCase().includes(q)
            );
            render(filtered);
        }, 200);
        searchEl.oninput = handle;
    }

    // Show modal
    if (window.bootstrap && bootstrap.Modal) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: true });
        modal.show();
    } else {
        // Minimal fallback
        modalEl.style.display = 'block';
        modalEl.classList.add('show');
    }
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
            
            // Set preview based on file type - use "open in new tab" instead of embedding
            if (['pdf', 'jpg', 'jpeg', 'png'].includes(fileExt)) {
                $('.certificate-preview').html(`
                    <div class="d-flex align-items-center gap-2">
                        <a href="${cert.certification_file}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Open in new tab
                        </a>
                        <small class="text-muted">Preview disabled for performance and compatibility.</small>
                    </div>
                `);
            } else {
                $('.certificate-preview').html(`
                    <div class="d-flex align-items-center gap-2">
                        <a href="${cert.certification_file}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Open in new tab
                        </a>
                        <small class="text-muted">Unsupported file format for preview.</small>
                    </div>
                `);
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