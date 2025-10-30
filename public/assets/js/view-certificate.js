$(document).ready(function() {
    
    
    function getStatusFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get('status') || 'pending'; // default to 'pending' if not set
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
        // You can now loop through response.data and display it
        console.log(response.data);
        renderCertificateTable(response.data);
      } else {
        alert('Failed to fetch: ' + response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX Error:', error);
    }
  });
}

const status = getStatusFromUrl();
  fetchCertificatesByStatus(status);

    
    
});