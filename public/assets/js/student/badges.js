 let allBadges = [];
    let filteredBadges = [];
    let allCategories = [];


$(document).ready(function() {


   
    let currentFilters = {
        search: '',
        category: 'all',
        status: 'all',
        sort: 'date-desc' // Default sort
    };

  
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Get initial filters from URL and set the state
    const initialCategoryId = getQueryParam('category_id') || 'all';
    const initialStatus = getQueryParam('status') || 'all';
    currentFilters.category = initialCategoryId;
    currentFilters.status = initialStatus;





    /**
     * NOTE: The <style> block was removed from this function. 
     * It is very inefficient to add a large style block for every single card.
     * Please move the CSS rules into your main stylesheet.
     */
function renderBadgesGrid(badges) {
    const container = $('.badges-grid-container');
    container.empty();

    if (!badges || !badges.length) {
        const emptyStateHTML = `
            <div class="col-12 text-center py-5">
                <div class="display-4 text-muted mb-3">
                    <i class="fas fa-trophy"></i>
                </div>
                <h4 class="fw-bold">Your Badge Collection is Starting!</h4>
                <p class="text-muted">You haven't earned any badges yet. Explore courses and activities to begin your collection.</p>
                <a href="/path/to/all-badges-page" class="btn btn-primary mt-3">
                    <i class="fas fa-search me-2"></i>Discover Badges
                </a>
            </div>
        `;
        container.append(emptyStateHTML);
        return;
    }

    badges.forEach(badge => {
        const badgeDate = new Date(badge.awarded_date).toLocaleDateString('en-GB', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });

        const badgeIcon = badge.badge_icon || 'fas fa-trophy';
        // You can add a 'badge_color' column to your database to make this dynamic
        const colorPalette = [
    '#0d6efd', // Blue
    '#6f42c1', // Purple
    '#d63384', // Pink
    '#dc3545', // Red
    '#fd7e14', // Orange
    '#198754', // Green
    '#20c997', // Teal
    '#0dcaf0'  // Cyan
];
        const badgeColor = badge.badge_color || colorPalette[Math.floor(Math.random() * colorPalette.length)];

        // <<< This is the updated card template using your new design >>>
        const card = `
        
        
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
<div class="card h-100 shadow-sm border-0" data-badge-id="${badge.badge_id}" id="badgeid">
                    <div class="card-body text-center p-3">
                        <div class="position-relative mb-3">
                            <button class="btn btn-link position-absolute top-0 end-0 p-0 favorite-btn" style="z-index: 10;" title="Favorite">
                                <i class="far fa-heart text-muted"></i>
                            </button>
                            <button class="btn btn-link position-absolute top-0 end-0 me-4 p-0 menu-btn" style="z-index: 10;" title="More Options">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </button>
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: ${badgeColor};">
                                                               <img src="${badgeIcon}" alt="${badge.badge_name}" style="width: 60%; height: 60%; object-fit: contain;">

                            </div>
                        </div>
                        <h6 class="card-title fw-bold mb-2">${badge.badge_name}</h6>
                        <small class="text-muted">${badgeDate}</small>
                        <p>${badge.awarded_staff_name}</p>
                    </div>
                </div>
            </div>`;
        
        container.append(card);
    });
}

function renderCategoryButtons() {
    const container = $('.badge-categories-container');
    if (!container.length) return;

    container.empty();

    // Render "All Categories" button
    const allBtnActive = currentFilters.category === 'all' ? 'btn-primary' : 'btn-outline-secondary';
    container.append(`
        <button class="btn ${allBtnActive} btn-sm category-btn me-2 mb-2" data-category="all">
            All Categories
        </button>
    `);

    // Split categories: show first 3, rest go into dropdown
    const visibleCategories = allCategories.slice(0, 2);
    const moreCategories = allCategories.slice(2);

    // Render first 3 buttons
    visibleCategories.forEach(category => {
        const isActive = category.id == currentFilters.category ? 'btn-primary' : 'btn-outline-secondary';
        container.append(`
            <button class="btn ${isActive} btn-sm category-btn me-2 mb-2" data-category="${category.id}">
                ${category.name}
            </button>
        `);
    });

    // Render dropdown if more categories exist
    if (moreCategories.length > 0) {
        let dropdownItems = '';
        moreCategories.forEach(category => {
            dropdownItems += `
                <li>
                    <a class="dropdown-item category-btn" href="#" data-category="${category.id}">
                        ${category.name}
                    </a>
                </li>
            `;
        });

        container.append(`
            <div class="dropdown d-inline-block mb-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    More
                </button>
                <ul class="dropdown-menu">
                    ${dropdownItems}
                </ul>
            </div>
        `);
    }
}

function showBadgeDetails(data) {
  $('#badge-icon').attr('src', data.badge_icon);
  $('#badge-name').text(data.badge_name);
  $('#badge-category').text(data.category_name || '—');
  $('#badge-description').text(data.badge_description || 'No description provided.');
  $('#student-id').text(data.student_id);
  $('#staff-name').text(data.awarded_staff_name);
  $('#staff-code').text(data.awarded_staff_code);
  $('#awarded-date').text(data.awarded_date);
  $('#badge-status').text(data.status);
  const modal = new bootstrap.Modal(document.getElementById('badgeDetailsModal'));
  modal.show();
}


    // --- DATA FETCHING (AJAX) ---
    function fetchBadgeCategories() {
        $.ajax({
            url: '/api/',
            method: 'POST',
            dataType: 'json',
            data: { method: 'getBadgeCategories' },
            success: function(response) {
                if (response.status) {
                    allCategories = response.data;
                    renderCategoryButtons();
                } else {
                    console.error('Failed to fetch categories:', response.message);
                }
            },
            error: (xhr, status, error) => console.error('AJAX Error:', error)
        });
    }

    function fetchBadges(categoryId = 'all', status = 'all') {
        $('.badges-grid-container').html('<div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin"></i> Loading badges...</div>');
        
        $.ajax({
            url: '/api/',
            method: 'POST',
            dataType: 'json',
            data: {
                method: 'getBadgesStudent',
                category_id: categoryId,
                status: status
            },
            success: function(response) {
                if (response.status) {
                    allBadges = response.data;
                    applyFiltersAndRender();
                } else {
                    console.error('Failed to fetch badges:', response.message);
                    $('.badges-grid-container').html('<div class="col-12 text-center py-5"><p class="text-danger">Could not load badges.</p></div>');
                }
            },
            error: (xhr, status, error) => console.error('AJAX Error:', error)
        });
    }


    // --- FILTERING & SORTING LOGIC ---
    function applyFiltersAndRender() {
        let badgesToDisplay = [...allBadges];

        // Category filter
        if (currentFilters.category !== 'all') {
            badgesToDisplay = badgesToDisplay.filter(badge => badge.category_id == currentFilters.category);
        }

        // Add other client-side filters like search here if needed
        // For example:
        // if (currentFilters.search) { ... }

        // Sorting
        switch (currentFilters.sort) {
            case 'date-desc':
                badgesToDisplay.sort((a, b) => new Date(b.awarded_date) - new Date(a.awarded_date));
                break;
            case 'date-asc':
                badgesToDisplay.sort((a, b) => new Date(a.awarded_date) - new Date(b.awarded_date));
                break;
            case 'name-asc':
                badgesToDisplay.sort((a, b) => (a.badge_name || '').localeCompare(b.badge_name || ''));
                break;
            case 'name-desc':
                badgesToDisplay.sort((a, b) => (b.badge_name || '').localeCompare(a.badge_name || ''));
                break;
        }
        
        filteredBadges = badgesToDisplay;
        renderBadgesGrid(filteredBadges);
        
        // updateBadgeCount(); // Uncomment if you have a badge count element
    }


    // --- EVENT LISTENERS ---

    // Category button clicks
    $(document).on('click', '.category-btn', function() {
        const categoryId = $(this).data('category');
        if (categoryId == currentFilters.category) return;

        currentFilters.category = categoryId;
        
        // Refetch data from the server based on the new category
        // This is more efficient than filtering large datasets on the client
        fetchBadges(currentFilters.category, currentFilters.status);

        // Update button styles
        $('.category-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
        $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
    });

    // Sort dropdown clicks
    $(document).on('click', '.sort-option', function(e) {
        e.preventDefault();
        const sortBy = $(this).data('sort');
        if (sortBy === currentFilters.sort) return;

        currentFilters.sort = sortBy;
        
        $(this).closest('.dropdown').find('button').html(`<i class="fas fa-sort me-2"></i> ${$(this).text()}`);
        
        // Re-apply filters and sorting to the currently loaded data
        applyFiltersAndRender();
    });

    // Placeholder for other actions like favorite, menu, etc.
    $(document).on('click', '.favorite-btn', function(e) {
        e.stopPropagation();
        $(this).find('i').toggleClass('far fas text-danger');
    });
   
    $(document).on('click', '.menu-btn', function(e) {
    e.stopPropagation();

    const badgeId = $(this).closest('.card').attr('data-badge-id');
//   showBadgeDetails(filteredBadges);

    // Show badge ID in modal content
});

    // --- INITIALIZATION ---
    function initializePage() {
        console.log("Initializing page...");
        fetchBadgeCategories(); // Load categories and render buttons
        fetchBadges(initialCategoryId, initialStatus); // Load initial set of badges
    }

    initializePage();

});