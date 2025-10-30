
  let allCategories = [];
let remainingCategories = [];
$(document).ready(function() {
    // Call the function to fetch stats when the page loads
  
      fetchStudentDetails(14117);
    fetchCertificateStats();
    fetchBadgeCategories();
    fetchStudentBadgeCategoryStats();
    $('#show-more-btn').on('click', function () {
    const container = $('#badge-category-container');
    remainingCategories.forEach(badge => container.append(createCardHTML(badge)));
    $(this).addClass('d-none'); // Hide button after expanding
});
         
});









   function fetchStudentDetails(studentCode) {
            // Show a loading message
            $('#result-container').html('<p class="text-center text-gray-500">Loading...</p>');

            $.ajax({
                url: '/api/', // Your backend API script
                method: 'POST',
                dataType: 'json',
                data: {
                    // This data is sent to the PHP script
                    method: 'getStudInfo',
                    scode: studentCode 
                },
                success: function(response) {
                    // This function runs if the API call is successful
                    if (response.status) {
                        // If the API reports success, display the data
                        let html = '<h2 class="text-xl font-bold text-gray-700 mb-4">Results:</h2>';
                        html += '<div class="bg-gray-50 p-4 rounded-md border"><ul class="space-y-2">';
                        $.each(response.data, function(key, value) {
                            const formattedKey = key.replace(/_/g, ' ');
                            html += `<li class="flex justify-between"><strong class="text-gray-600 capitalize">${formattedKey}:</strong> <span class="text-gray-800 text-right">${value}</span></li>`;
                        });
                        html += '</ul></div>';
                        $('#result-container').html(html);
                    } else {
                        // If the API reports an error, display the message
                        const errorMsg = response.message || 'An unknown error occurred.';
                        $('#result-container').html(`<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md">${errorMsg}</div>`);
                    }
                },
                error: function(xhr, status, error) {
                    // This function runs if there's a network or server error
                    console.error('AJAX Error:', error);
                    $('#result-container').html(`<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md">Error fetching data from the server.</div>`);
                }
            });
        }



    function fetchBadgeCategories() {
        $.ajax({
            url: '/api/',
            method: 'POST',
            dataType: 'json',
            data: { method: 'getStudentBadgeCategoryStats' },
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
    
    
 
function renderCategoryButtons() {
    const container = $('#badge-category-container');
    container.empty();
    if (allCategories.length === 0) {
        container.append(`
            <div class="col-12 text-center my-5">
                <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">No badge categories found.</h5>
                <p class="text-secondary">You haven't earned any badges yet.</p>
            </div>
        `);
        $('#show-more-btn').addClass('d-none');
        return;
    }


    const first8 = allCategories.slice(0, 8);
    remainingCategories = allCategories.slice(8);

    first8.forEach(badge => container.append(createCardHTML(badge)));

    // Show "Show More" button only if there are more than 8
    if (remainingCategories.length > 0) {
        $('#show-more-btn').removeClass('d-none');
    } else {
        $('#show-more-btn').addClass('d-none');
    }
}

function createCardHTML(badge) {
    const iconClass = badge.icon_class;
    const badgeCountText = badge.badge_count == 1 ? '1 badge' : `${badge.badge_count} badges`;

    return `
        <div class="col-lg-3 col-md-6">
            <a href="/badges?${badge.category_id}" class="stats-card card h-100 border-0 shadow-sm text-decoration-none">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="${iconClass} text-primary fs-4"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2">${badge.category_name}</h5>
                    <p class="card-text text-muted mb-1">${badgeCountText}</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="text-primary small fw-medium me-2">Explore</span>
                        <i class="fas fa-arrow-right text-primary small"></i>
                    </div>
                </div>
            </a>
        </div>
    `;
}

 function fetchStudentBadgeCategoryStats() {
        $.ajax({
            url: '/api/',
            method: 'POST',
            dataType: 'json',
            data: { method: 'getStudentBadgeCategoryStats' },
            success: function(response) {
                if (response.status) {
                    console.log(response.data) ;
                    } else {
                    console.error('Failed to fetch categories:', response.message);
                }
            },
            error: (xhr, status, error) => console.error('AJAX Error:', error)
        });
    }






/**
 * Fetches certificate statistics from the API and updates the dashboard cards.
 */
function fetchCertificateStats() {
    $.ajax({
        url: '/api/', // Your API endpoint
        method: 'POST',
        dataType: 'json',
        data: { method: 'getStudentCertificateStats' },
        success: function(response) {
            // Check if the API call was successful
            if (response.status) {
                // Update the text of each card's count using the new IDs
                $('#approved-count').text(response.data.approved);
                $('#pending-count').text(response.data.pending);
                $('#rejected-count').text(response.data.rejected);
                $('#reverted-count').text(response.data.reverted);
                 $('#total-badges').text(response.data.badges);
          
            } else {
                // Log the error message from the server
                console.error('Failed to fetch stats:', response.message);
                // You could also display an error message to the user here
            }
        },
        error: (xhr, status, error) => console.error('AJAX Error:', error)
    });
    
    
         

    
    
    
    
}