document.addEventListener('DOMContentLoaded', function() {
    fetchCategories();
});

function fetchCategories() {
    $.ajax({
        url: '/api_services/index.php',
        type: 'POST',
        data: {
            action: 'getCategories'
        },
        beforeSend: function() {
            console.log('Fetching categories...');
        },
        complete: function(xhr) {
            console.log('Raw response:', xhr.responseText);
        },
        success: function(response) {
            try {
                if (typeof response === 'string' && response.trim().startsWith('<')) {
                    console.error('Received HTML instead of JSON:', response);
                    return;
                }

                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result && result.status && result.data) {
                    console.log('Categories data:', result.data);
                    updateCategoryTabs(result.data);
                    updateDropdownCategories(result.data);
                } else {
                    console.error('Invalid response format:', result);
                }
            } catch (error) {
                console.error('Error processing response:', error);
                console.log('Raw response that caused error:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', {
                status: status,
                error: error,
                responseText: xhr.responseText
            });
        }
    });
}

function updateCategoryTabs(categories) {
    const scrollableTabsContainer = document.querySelector('.scrollable-tabs');
    if (!scrollableTabsContainer) {
        console.error('Scrollable tabs container not found');
        return;
    }
    
    scrollableTabsContainer.innerHTML = '';

    categories.forEach(category => {
        const li = document.createElement('li');
        li.className = 'nav-item';
        li.innerHTML = `
            <a class="nav-link" href="#category_${category.category_id}">
                ${category.category_name}
            </a>
        `;
        scrollableTabsContainer.appendChild(li);
    });
}

function updateDropdownCategories(categories) {
    const dropdownMenu = document.querySelector('.dropdown-menu');
    if (!dropdownMenu) {
        console.error('Dropdown menu not found');
        return;
    }
    
    dropdownMenu.innerHTML = '';

    categories.forEach(category => {
        const li = document.createElement('li');
        li.innerHTML = `
            <a class="dropdown-item" href="#category_${category.category_id}">
                <i class="bi bi-grid"></i> ${category.category_name}
            </a>
        `;
        dropdownMenu.appendChild(li);
    });
}

function loadCategoryItems(categoryId) {
    console.log('Loading items for category:', categoryId);
}

window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.error('Script error:', {
        message: msg,
        url: url,
        line: lineNo,
        column: columnNo,
        error: error
    });
    return false;
};