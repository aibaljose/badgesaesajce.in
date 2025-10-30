$(document).ready(function() {
    
    // Global variables to store certificates and current filters
    let allCertificates = [];
    let filteredCertificates = [];
    let currentFilters = {
        search: '',
        status: '',
        category: '',
        sort: 'newest'
    };
    
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    const status = getQueryParam('status') || 'all'; // Default to 'all' if none

function renderCertificateTable(certificates) {
  const container = $('#certificateViewContainer');
  container.empty();

  if (!certificates.length) {
    container.append('<p class="text-muted">No certificates found.</p>');
    return;
  }

    certificates.forEach(cert => {
        const {
            certification_title = 'Untitled Certificate',
            certification_desc = 'No description available.',
            start_date = '',
            end_date = '',
            certification_mode = '',
            certification_file = '#',
            status = 'pending'
        } = cert;

        const isPdf = certification_file.toLowerCase().endsWith('.pdf');
        const statusColors = {
            approved: { bg: 'bg-success-subtle', text: 'text-success' },
            pending: { bg: 'bg-warning-subtle', text: 'text-warning' },
            rejected: { bg: 'bg-danger-subtle', text: 'text-danger' },
            reverted: { bg: 'bg-secondary-subtle', text: 'text-secondary' }
        };
        const { bg, text } = statusColors[status.toLowerCase()] || { bg: 'bg-light', text: 'text-muted' };
        const preview = isPdf
            ? `<iframe src="${certification_file}#toolbar=0" style="width:100%; height:100%; border:0;"></iframe>`
            : `<img src="${certification_file}" alt="${certification_title}" style="width:100%; height:100%; object-fit:cover;">`;
        const fileIcon = isPdf
            ? '<i class="fa-solid fa-file-pdf text-danger me-1"></i> PDF'
            : '<i class="fa-solid fa-image text-info me-1"></i> Image';

        // Modern card layout with improved UI/UX
        const card = `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="pdf-preview-card shadow-lg rounded-4 overflow-hidden bg-white border-0 position-relative h-100 d-flex flex-column transition-all">
                    <div class="bg-gradient d-flex align-items-center justify-content-center" style="height: 180px; overflow: hidden;">
                        ${preview}
                        <span class="position-absolute top-0 end-0 m-2  ${bg} ${text} text-capitalize px-2 py-1 shadow">${status}</span>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h5 class="fw-bold mb-2 text-truncate" title="${certification_title}">${certification_title}</h5>
                        <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                            ${fileIcon}
                            <span>Student Upload</span>
                            <span class="ms-auto text-secondary">${certification_mode}</span>
                        </div>
                        <div class="text-muted mb-3 text-truncate" title="${certification_desc}">${certification_desc}</div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> ${start_date ? new Date(start_date).toLocaleDateString() : ''}</span>
                            <a href="${certification_file}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3" title="View Full">
                                <i class="fa-solid fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.append(card);
    });
}

    
    function fetchCertificatesByStatus(status) {
        $.ajax({
            url: '/api/',
            method: 'POST',
            dataType: 'json',
            data: {
                method: 'getStudentCertificatesByStatus',
                status: status
            },
            success: function(response) {
                if (response.status) {
                    allCertificates = response.data;
                    filteredCertificates = [...allCertificates];
                    console.log(response.data);
                    
                    // Apply initial filters if any
                    applyFilters();
                    renderCertificateTable(filteredCertificates);
                } else {
                    alert('Failed to fetch: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

    // Filter Functions
    function applyFilters() {
        filteredCertificates = allCertificates.filter(cert => {
            // Search filter
            if (currentFilters.search) {
                const searchTerm = currentFilters.search.toLowerCase();
                const titleMatch = (cert.certification_title || '').toLowerCase().includes(searchTerm);
                const descMatch = (cert.certification_desc || '').toLowerCase().includes(searchTerm);
                const modeMatch = (cert.certification_mode || '').toLowerCase().includes(searchTerm);
                
                if (!titleMatch && !descMatch && !modeMatch) {
                    return false;
                }
            }
            
            // Status filter
            if (currentFilters.status && cert.status !== currentFilters.status) {
                return false;
            }
            
            // Category filter (assuming certification_mode represents category)
            if (currentFilters.category) {
                const certMode = (cert.certification_mode || '').toLowerCase();
                if (!certMode.includes(currentFilters.category.toLowerCase())) {
                    return false;
                }
            }
            
            return true;
        });
        
        // Apply sorting
        applySorting();
        
        // Update active filters display
        updateActiveFiltersDisplay();
    }
    
    function applySorting() {
        // Consistent sorting logic with fallback and normalization
        const sortType = currentFilters.sort;
        filteredCertificates.sort((a, b) => {
            switch (sortType) {
                case 'newest': {
                    const dateA = new Date(a.start_date || 0).getTime();
                    const dateB = new Date(b.start_date || 0).getTime();
                    return dateB - dateA;
                }
                case 'oldest': {
                    const dateA = new Date(a.start_date || 0).getTime();
                    const dateB = new Date(b.start_date || 0).getTime();
                    return dateA - dateB;
                }
                case 'name-asc': {
                    return (a.certification_title || '').toLowerCase().localeCompare((b.certification_title || '').toLowerCase());
                }
                case 'name-desc': {
                    return (b.certification_title || '').toLowerCase().localeCompare((a.certification_title || '').toLowerCase());
                }
                case 'status': {
                    return (a.status || '').toLowerCase().localeCompare((b.status || '').toLowerCase());
                }
                default:
                    return 0;
            }
        });
    }
    
    function updateActiveFiltersDisplay() {
        const activeFiltersContainer = $('#activeFilters');
        const filterTags = $('#filterTags');
        
        filterTags.empty();
        let hasActiveFilters = false;
        
        //Add search filter tag
        // if (currentFilters.search) {
        //     filterTags.append(`
        //         <span class="badge bg-primary">
        //             Search: "${currentFilters.search}"
        //             <button type="button" class="btn-close btn-close-white ms-1" data-filter="search"></button>
        //         </span>
        //     `);
        //     hasActiveFilters = true;
        // }
        
        // //Add status filter tag
        // if (currentFilters.status) {
        //     filterTags.append(`
        //         <span class="badge bg-success">
        //             Status: ${currentFilters.status}
        //             <button type="button" class="btn-close btn-close-white ms-1" data-filter="status"></button>
        //         </span>
        //     `);
        //     hasActiveFilters = true;
        // }
        
        // //Add category filter tag
        // if (currentFilters.category) {
        //     filterTags.append(`
        //         <span class="badge bg-info">
        //             Category: ${currentFilters.category}
        //             <button type="button" class="btn-close btn-close-white ms-1" data-filter="category"></button>
        //         </span>
        //     `);
        //     hasActiveFilters = true;
        // }
        
        // // Add sort filter tag (only if not default)
        // if (currentFilters.sort !== 'newest') {
        //     const sortLabels = {
        //         'oldest': 'Oldest First',
        //         'name-asc': 'Name A-Z',
        //         'name-desc': 'Name Z-A',
        //         'status': 'By Status'
        //     };
        //     filterTags.append(`
        //         <span class="badge bg-secondary">
        //             Sort: ${sortLabels[currentFilters.sort]}
        //             <button type="button" class="btn-close btn-close-white ms-1" data-filter="sort"></button>
        //         </span>
        //     `);
        //     hasActiveFilters = true;
        // }
        
        activeFiltersContainer.toggle(hasActiveFilters);
    }
    
    function clearAllFilters() {
        currentFilters = {
            search: '',
            status: '',
            category: '',
            sort: 'newest'
        };
        
        // Clear all filter inputs
        $('#searchFilter, #searchFilterMobile').val('');
        $('#statusFilter, #statusFilterMobile').val('');
        $('#categoryFilter, #categoryFilterMobile').val('');
        $('#sortFilter, #sortFilterMobile').val('newest');
        
        applyFilters();
        renderCertificateTable(filteredCertificates);
    }
    
    // Sync function to keep desktop and mobile filters in sync
    function syncFilters(sourceElement, targetElement) {
        $(targetElement).val($(sourceElement).val());
    }
    
    // Event Listeners for Desktop Filters
    $('#searchFilter').on('input', function() {
        currentFilters.search = $(this).val();
        syncFilters(this, '#searchFilterMobile');
        applyFilters();
        renderCertificateTable(filteredCertificates);
    });
    
    // $('#statusFilter').on('change', function() {
    //     currentFilters.status = $(this).val();
    //     syncFilters(this, '#statusFilterMobile');
    //     applyFilters();
    //     renderCertificateTable(filteredCertificates);
    // });
    
    $('#statusFilter').on('change', function() {
        const selectedStatus = $(this).val();
        syncFilters(this, '#statusFilterMobile');
        
        // If "All Status" is selected (empty value), pass "all" to the function
        const statusToFetch = selectedStatus === '' ? 'all' : selectedStatus;
        
        // Fetch new data from server when status changes (server-side filtering)
        fetchCertificatesByStatus(statusToFetch);
    });
    
    $('#categoryFilter').on('change', function() {
        currentFilters.category = $(this).val();
        syncFilters(this, '#categoryFilterMobile');
        applyFilters();
        renderCertificateTable(filteredCertificates);
    });
    
    $('#sortFilter').on('change', function() {
        currentFilters.sort = $(this).val();
        syncFilters(this, '#sortFilterMobile');
        applyFilters();
        renderCertificateTable(filteredCertificates);
    });
    
    // Event Listeners for Mobile Filters - Fixed to trigger filtering
    $('#searchFilterMobile').on('input', function() {
        currentFilters.search = $(this).val();
        syncFilters(this, '#searchFilter');
        // Apply filters immediately for real-time search
        applyFilters();
        renderCertificateTable(filteredCertificates);
    });
    
    $('#statusFilterMobile').on('change', function() {
        // currentFilters.status = $(this).val();
        // syncFilters(this, '#statusFilter');
        //   const statusToFetch = selectedStatus === '' ? 'all' : selectedStatus;
        
        // // Fetch new data from server when status changes (server-side filtering)
        // fetchCertificatesByStatus(statusToFetch);
        // // Don't apply immediately - wait for "Apply Filters" button
        
        
        const selectedStatus = $(this).val();
        syncFilters(this, '#statusFilter');
        
        // If "All Status" is selected (empty value), pass "all" to the function
        const statusToFetch = selectedStatus === '' ? 'all' : selectedStatus;
        
        // Fetch new data from server when status changes (server-side filtering)
        fetchCertificatesByStatus(statusToFetch);
        
        
        
        
    });
    
    $('#categoryFilterMobile').on('change', function() {
        currentFilters.category = $(this).val();
        syncFilters(this, '#categoryFilter');
        // Don't apply immediately - wait for "Apply Filters" button
    });
    
    $('#sortFilterMobile').on('change', function() {
        currentFilters.sort = $(this).val();
        syncFilters(this, '#sortFilter');
        // Don't apply immediately - wait for "Apply Filters" button
    });
    
    // Apply Filters Button for Mobile
    $('#applyFiltersMobile').on('click', function() {
        applyFilters();
        renderCertificateTable(filteredCertificates);
        hideMobileFilters();
    });
    
    // Clear filters button
    $('#clearFilters, #clearFiltersMobile').on('click', function() {
        clearAllFilters();
        // Hide mobile filters after clearing
        if ($(this).attr('id') === 'clearFiltersMobile') {
            hideMobileFilters();
        }
    });
    
    // Individual filter tag removal
    $(document).on('click', '[data-filter]', function() {
        const filterType = $(this).data('filter');
        currentFilters[filterType] = filterType === 'sort' ? 'newest' : '';
        
        // Update corresponding inputs
        if (filterType === 'search') {
            $('#searchFilter, #searchFilterMobile').val('');
        } else if (filterType === 'status') {
            $('#statusFilter, #statusFilterMobile').val('');
        } else if (filterType === 'category') {
            $('#categoryFilter, #categoryFilterMobile').val('');
        } else if (filterType === 'sort') {
            $('#sortFilter, #sortFilterMobile').val('newest');
        }
        
        applyFilters();
        renderCertificateTable(filteredCertificates);
    });
    
    // View toggle functionality - Fixed with proper event delegation
    function setGridView() {
        $('#gridView, #gridViewMobile').addClass('active');
        $('#listView, #listViewMobile').removeClass('active');
        $('#certificateViewContainer').removeClass('list-view').addClass('grid-view row');
        console.log('Grid view activated');
    }
    
    function setListView() {
        $('#listView, #listViewMobile').addClass('active');
        $('#gridView, #gridViewMobile').removeClass('active');
        $('#certificateViewContainer').removeClass('grid-view row').addClass('list-view');
        console.log('List view activated');
    }
    
    // Use event delegation for better compatibility
    $(document).on('click', '#gridView, #gridViewMobile', function(e) {
        e.preventDefault();
        setGridView();
    });
    
    $(document).on('click', '#listView, #listViewMobile', function(e) {
        e.preventDefault();
        setListView();
    });
    
    // Mobile filter toggle functionality (without Bootstrap dependency)
    function showMobileFilters() {
        $('#mobileFilters').slideDown(300);
        $('#filterChevron').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        $('[data-mobile-filter-toggle]').attr('aria-expanded', 'true');
        console.log('Mobile filters shown');
    }
    
    function hideMobileFilters() {
        $('#mobileFilters').slideUp(300);
        $('#filterChevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $('[data-mobile-filter-toggle]').attr('aria-expanded', 'false');
        console.log('Mobile filters hidden');
    }
    
    function toggleMobileFilters() {
        if ($('#mobileFilters').is(':visible')) {
            hideMobileFilters();
        } else {
            showMobileFilters();
        }
    }
    
    // Mobile filter toggle button handlers
    $(document).on('click', '[data-mobile-filter-toggle]', function(e) {
        e.preventDefault();
        console.log('Mobile filter toggle clicked');
        toggleMobileFilters();
    });
    
    // Alternative selectors for common toggle button patterns
    $(document).on('click', '[data-bs-toggle="collapse"][data-bs-target="#mobileFilters"]', function(e) {
        e.preventDefault();
        console.log('Bootstrap-style toggle clicked');
        toggleMobileFilters();
    });
    
    // Generic mobile filter button click
    $(document).on('click', '.mobile-filter-toggle, #mobileFilterToggle', function(e) {
        e.preventDefault();
        console.log('Generic mobile filter toggle clicked');
        toggleMobileFilters();
    });
    
    // Initialize view and filters
    function initializeInterface() {
        console.log('Initializing interface...');
        
        // Set default grid view
        setGridView();
        
        // Hide mobile filters initially
        $('#mobileFilters').hide();
        
        // Log available elements for debugging
        console.log('Available elements:');
        console.log('gridView:', $('#gridView').length);
        console.log('gridViewMobile:', $('#gridViewMobile').length);
        console.log('listView:', $('#listView').length);
        console.log('listViewMobile:', $('#listViewMobile').length);
        console.log('mobileFilters:', $('#mobileFilters').length);
        console.log('certificateViewContainer:', $('#certificateViewContainer').length);
        console.log('filterChevron:', $('#filterChevron').length);
    }
    
    // Initial load
    fetchCertificatesByStatus(status);
    
    // Initialize interface after a short delay to ensure DOM is ready
    setTimeout(initializeInterface, 100);
    
});