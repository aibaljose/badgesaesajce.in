$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '/api_services/index.php',
            type: 'POST',
            data: {
                method: 'isAuthUser',
                ...$(this).serialize()
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.status && response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message || 'Login failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('Login error:', error);
                alert('Login failed. Please try again.');
            }
        });
    });
});
