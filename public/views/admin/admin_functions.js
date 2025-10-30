$(document).ready(function() {
    fetchBadges();
    fetchBadgeRequests();
    let badgeRequestsData = [];
    
    function fetchBadges() {
        $.ajax({
            url: '/api',
            type: 'POST',
            data: { method: 'getBadgeList' },
            success: function (response) {
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status) {
                    renderBadges(res.badges);
                } else {
                    console.error('Error fetching badges:', res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching badge categories:', error);
            }
        });
    }
    
    function renderBadges(badges) {
        const container = $("#badgesList");
        container.empty();
        
        if (badges.length === 0) {
            container.append('<div class="text-center text-muted mt-5">No badge categories found.</div>');
            return;
        }
        
        badges.forEach(badge => {
            const badgeHtml = `
                <div class="badge-card">
                    <div class="badge-status-indicator ${badge.badge_status == '1' ? 'status-active' : 'status-inactive'}">
                        ${badge.badge_status == '1' ? 'Active' : 'Inactive'}
                    </div>
                    <div class="badge-display">
                        <img src="${badge.badge_icon}" alt="${badge.badge_name}" class="badge-image">
                    </div>
                    <div class="badge-info">
                        <h5 class="badge-title">${badge.badge_name}</h5>
                        <span class="recipient-type">
                            <i class="fas fa-user-graduate"></i>
                            ${badge.recipient_type || 'Student'}
                        </span>
                    </div>
                    <div class="badge-actions">
                        <button class="action-button" onclick="viewBadgeDetails(${badge.id})">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                    </div>
                </div>
            `;
            container.append(badgeHtml);
        });
    }
    
    function fetchBadgeRequests() {
        $.ajax({
            url: '/api',
            type: 'POST',
            data: { method: 'getBadgeRequests' },
            success: function (response) {
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status) {
                    badgeRequestsData = res.badges;
                    renderBadgeRequestTable(res.badges);
                } else {
                    console.error('Error fetching badge requests:', res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching badge requests:', error);
            }
        });
    }
    
    function renderBadgeRequestTable(badges) {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';
    
        badges.forEach((badge, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${badge.teacher_name || 'N/A'}</td>
                <td>${badge.department || 'N/A'}</td>
                <td>${badge.badge_name}</td>
                <td>${badge.created_at || 'N/A'}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailsModal" data-index="${index}">View Details</button>
                    <button class="btn btn-sm btn-success" onclick="createBadge(${badge.request_id})">Create Badge</button>
                    <button class="btn btn-sm btn-danger" onclick="rejectBadgeRequest(${badge.request_id})">Reject</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    $(document).on('click', '[data-target="#detailsModal"]', function () {
        const index = $(this).data('index');
        const badge = badgeRequestsData[index];
    
        $('#detailsModal .modal-body').html(`
            <p><strong>Teacher:</strong> ${badge.teacher_name || 'N/A'}</p>
            <p><strong>Department:</strong> ${badge.department || 'N/A'}</p>
            <p><strong>Badge Name:</strong> ${badge.badge_name}</p>
            <p><strong>Description:</strong> ${badge.badge_description}</p>
            <p><strong>Date Requested:</strong> ${badge.created_at || 'N/A'}</p>
            <p><strong>Badge Shape:</strong> ${badge.badge_shape || 'N/A'}</p>
            <p><strong>Primary Color:</strong> <span style="display:inline-block; width:20px; height:20px; background-color:${badge.primary_color}; border:1px solid #ddd;"></span> ${badge.primary_color}</p>
            <p><strong>Secondary Color:</strong> <span style="display:inline-block; width:20px; height:20px; background-color:${badge.secondary_color}; border:1px solid #ddd;"></span> ${badge.secondary_color}</p>
            <p><strong>Badge Icon:</strong> ${badge.badge_icon}</p>
        `);
    
        $('#detailsModal .modal-footer').html(`
            <button class="btn btn-success" onclick="createBadge(${badge.request_id})">Create Badge</button>
            <button class="btn btn-danger" onclick="rejectBadgeRequest(${badge.request_id})">Reject Request</button>
            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        `);
    });
    
    // Make the fetchBadgeRequests function available globally so it can be called from other functions
    window.fetchBadgeRequests = fetchBadgeRequests;
    window.createBadge=createBadge;

    // Function to approve and create badge from the request
    function createBadge(badgeId) {
        // Show loading indicator or disable buttons
        const loadingHtml = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        const $btn = $(event.target);
        const originalText = $btn.html();
        $btn.html(loadingHtml).prop('disabled', true);
        console.log(badgeId);
        
        // Call API to update the status to 'approved'
        $.ajax({
            url: '/api',
            type: 'POST',
            data: { 
                method: 'updateBadgeRequestStatus',
                id: badgeId,
                status: 'approved' 
            },
            success: function(response) {
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status) {
                    // Close modal if it's open
                    $('#detailsModal').modal('hide');
                    
                    // Convert badge details to URL parameters for the badges.php page
                    if (res.badge_request) {
                        const badgeRequest = res.badge_request;
                        const params = new URLSearchParams({
                            from_request: 'true',
                            request_id: badgeId,
                            badge_name: badgeRequest.badge_name,
                            badge_description: badgeRequest.badge_description,
                            primary_color: badgeRequest.primary_color,
                            secondary_color: badgeRequest.secondary_color,
                            badge_shape: badgeRequest.badge_shape,
                            badge_icon: badgeRequest.badge_icon
                        }).toString();
                        
                        // Redirect to badges.php with parameters
                        window.location.href = '/admin/badges/' + params;
                    } else {
                        // Fallback if badge request details are not returned
                        window.location.href = '/public/views/admin/badges.php?from_request=true&request_id=' + badgeId;
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: res.message || 'Failed to approve badge request'
                    });
                    $btn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating badge request:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while processing your request. Please try again.'
                });
                $btn.html(originalText).prop('disabled', false);
            }
        });
    }
    
    // Function to reject a badge request
    function rejectBadgeRequest(badgeId) {
        Swal.fire({
            title: 'Reject Badge Request?',
            text: 'Are you sure you want to reject this badge request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $(event.target);
                const originalText = $btn.html();
                $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Rejecting...').prop('disabled', true);
                
                $.ajax({
                    url: '/api',
                    type: 'POST',
                    data: { 
                        method: 'updateBadgeRequestStatus',
                        id: badgeId,
                        status: 'rejected' 
                    },
                    success: function(response) {
                        const res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.status) {
                            // Close modal if it's open
                            $('#detailsModal').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Rejected!',
                                text: 'Badge request has been rejected successfully.'
                            }).then(() => {
                                // Refresh the badge requests table
                                fetchBadgeRequests();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: res.message || 'Failed to reject badge request'
                            });
                            $btn.html(originalText).prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error rejecting badge request:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while processing your request. Please try again.'
                        });
                        $btn.html(originalText).prop('disabled', false);
                    }
                });
            }
        });
    }

    // Make fetchBadges available globally
    window.fetchBadges = fetchBadges;

});
