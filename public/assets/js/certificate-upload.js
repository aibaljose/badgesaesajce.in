$(document).ready(function() {
    
     console.log("page loaded")
    
        $.ajax({
    url: '/api',
    type: 'POST',
    data: {
        method: 'getCertificateCategories'
    },
    dataType: 'json',
    success: function (response) {
        const categorySelect = $('#certificate_categories');
        categorySelect.empty();
        categorySelect.append('<option value="">Select Certificate Category</option>');

        if (response && Array.isArray(response)) {
            response.forEach(function (item) {
                categorySelect.append(`<option value="${item.id}">${item.name}</option>`);
            });
        } else {
            categorySelect.append('<option disabled>No categories found</option>');
        }
    },
    error: function () {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Could not load certificate categories. Please try again later.',
            confirmButtonColor: '#800080'
        });
    }
});


    
    
    // Form submission handler
    $('#studentForm').on('submit', function(e) {
        e.preventDefault();
        
        console.log("submitting")
        
        // Check form validity before proceeding
        // if (!this.checkValidity()) {
        //     e.stopPropagation();
        //     $(this).addClass('was-validated');
        //     return;
        // }
        
        
        
        


        
        
        
          let form = this;
        let isValid = true;

        $(form).find('input, textarea, select').each(function () {
            const input = $(this);
            const feedback = input.siblings('.invalid-feedback');

            if (!this.checkValidity()) {
                isValid = false;
                input.addClass('border-red-500');
                if (feedback.length) feedback.removeClass('hidden');
            } else {
                input.removeClass('border-red-500');
                if (feedback.length) feedback.addClass('hidden');
            }
        });

        if (!isValid) {
            e.stopPropagation();
            Swal.fire({
                icon: 'error',
                title: 'Form Incomplete',
                text: 'Please correct the highlighted fields before submitting.',
                confirmButtonColor: '#800080'
            });
            return;
        }


        // Show loading state
        Swal.fire({
            title: 'Uploading...',
            text: 'Please wait while we upload your certificate',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create FormData and append files
        var formData = new FormData(this);
        var fileData = $('#certification_file')[0].files[0];
        formData.append('certification_file', fileData);
        formData.append('method', 'storeStudentDetails');

        // Debug: Log form data
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: '/api',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) { 
                console.log('Raw server response:', response);
                
                // Handle empty response
                if (!response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Server returned an empty response. Please try again.',
                        confirmButtonColor: '#800080'
                    });
                    return;
                }

                // Parse response if it's a string
                let parsedResponse;
                if (typeof response === 'string') {
                    try {
                        parsedResponse = JSON.parse(response);
                        console.log('Parsed response:', parsedResponse);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.log('Raw response that failed to parse:', response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Invalid response from server. Please try again.',
                            confirmButtonColor: '#800080'
                        });
                        return;
                    }
                } else {
                    parsedResponse = response;
                    console.log('Response was already JSON:', parsedResponse);
                }

                if (parsedResponse && parsedResponse.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: parsedResponse.message || 'Certificate uploaded successfully! Waiting for teacher approval.',
                        confirmButtonColor: '#800080',
                        allowOutsideClick: false
                    }).then((result) => {
                        window.location.href = '/student/';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: (parsedResponse && parsedResponse.message) || 'Failed to upload certificate. Please try again.',
                        confirmButtonColor: '#800080'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    responseJSON: xhr.responseJSON,
                    statusText: xhr.statusText
                });

                let errorMessage = 'Something went wrong. Please try again later.';
                
                if (xhr.responseText) {
                    try {
                        const errorResponse = JSON.parse(xhr.responseText);
                        console.log('Parsed error response:', errorResponse);
                        errorMessage = errorResponse.message || errorMessage;
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                        if (xhr.responseText.length < 100) {
                            errorMessage = xhr.responseText;
                        }
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    confirmButtonColor: '#800080'
                });
            }
        });
    });

    // Add validation classes on form inputs
    // $('.needs-validation').find('input, select, textarea').on('input change', function() {
    //     $(this).addClass('was-validated');
    // });
    
    $('.needs-validation').find('input, select, textarea').on('input change', function () {
    const input = $(this);
    const feedback = input.siblings('.invalid-feedback');

    if (this.checkValidity()) {
        input.removeClass('border-red-500');
        feedback.addClass('hidden');
    } else {
        input.addClass('border-red-500');
        feedback.removeClass('hidden');
    }
});

    
    
    
}); 