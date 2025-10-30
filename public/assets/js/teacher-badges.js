
// Wait for document ready
$(document).ready(function() {
    

    // Handle form submission
    $('#badgeRequestForm').on('submit', function(e) {
        e.preventDefault();
        
        // Collect form data
        var data = {
            method: 'createBadgeRequest',
            badge_name: $('#badge_name').val(),
            badge_icon: $('#badge_icon').val(),
            badge_description: $('#badge_description').val(),
            primary_color: $('#primary_color').val(),
            secondary_color: $('#secondary_color').val(),
            badge_shape: $('#badge_shape').val()
        };
        
        // Show loading state
        Swal.fire({
            title: 'Submitting Request...',
            text: 'Please wait while we process your request',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit request
        $.post('/api', data, function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Badge request submitted successfully!',
                confirmButtonColor: '#6c4298'
            }).then(function() {
                $('#badgeRequestForm')[0].reset();
                location.reload();
            });
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Could not submit the badge request. Please try again.',
                confirmButtonColor: '#6c4298'
            });
        });
    });
});