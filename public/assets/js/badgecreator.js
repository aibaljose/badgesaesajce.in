$(document).ready(function () {
    // DOM elements
    const badgeForm = $('#addBadgeForm'); // Make sure this matches the form ID
    const badgeTitle = $('#badgeTitle');
    const recipientType = $('#recipientType');
    const badgeShape = $('#badgeShape');
    const primaryColor = $('#primaryColor');
    const secondaryColor = $('#secondaryColor');
    const badgeIcon = $('#badgeIcon');
    const badgeDescription = $('#badgeDescription');
    const status = $('#status');
    
    // Request ID field (hidden)
    let requestId = null;

    // Preview elements
    const badgePreview = $('#badgePreview');

    // Add a hidden container for SVG rendering
    $('body').append('<div id="svgContainer" style="display: none;"></div>');

    // Check if we have parameters from a badge request
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
    
    // Check if we're coming from a badge request
    const fromRequest = getUrlParameter('from_request') === 'true';
    if (fromRequest) {
        // Get the request ID
        requestId = getUrlParameter('request_id');
        
        // Set form values from URL parameters
        badgeTitle.val(getUrlParameter('badge_name'));
        badgeDescription.val(getUrlParameter('badge_description'));
        
        // Handle colors if provided
        const primaryColorValue = getUrlParameter('primary_color');
        if (primaryColorValue) {
            primaryColor.val(primaryColorValue);
        }
        
        const secondaryColorValue = getUrlParameter('secondary_color');
        if (secondaryColorValue) {
            secondaryColor.val(secondaryColorValue);
        }
        
        // Handle badge shape if provided
        const badgeShapeValue = getUrlParameter('badge_shape');
        if (badgeShapeValue && badgeShape.find(`option[value="${badgeShapeValue}"]`).length > 0) {
            badgeShape.val(badgeShapeValue);
        }
        
        // Handle badge icon if provided
        const badgeIconValue = getUrlParameter('badge_icon');
        if (badgeIconValue && badgeIcon.find(`option[value="${badgeIconValue}"]`).length > 0) {
            badgeIcon.val(badgeIconValue);
        }
        
        // Set status to active by default for approved requests
        status.val('1');
        
        $('#addBadgeModal').modal('show');
        
        // Show notification that we're creating from a request
        Swal.fire({
            icon: 'info',
            title: 'Creating Badge from Request',
            text: 'The form has been pre-filled with the badge request data. You can make adjustments before creating the badge.',
            timer: 5000,
            timerProgressBar: true
        });
        
        // Add a notification/header to the form
        if ($('#requestNotification').length === 0) {
            badgeForm.prepend(`
                <div id="requestNotification" class="alert alert-info mb-4">
                    <i class="fas fa-info-circle"></i> Creating badge from request #${requestId}
                </div>
            `);
        }
    }

    // Function to update preview (using CSS for live preview)
    function updatePreview() {
        const badgeContainer = $('<div>', {
            class: `badge ${badgeShape.val()}`,
            style: `
                --primary-color: ${primaryColor.val()};
                --secondary-color: ${secondaryColor.val()};
            `
        });

        const badgeContent = $('<div>', {
            class: 'badge-content'
        }).appendTo(badgeContainer);

        $('<div>', {
            class: 'badge-icon'
        }).append(
            $('<i>', {
                class: `fas ${badgeIcon.val()}`
            })
        ).appendTo(badgeContent);

        $('<div>', {
            class: 'badge-title',
            text: badgeTitle.val() || 'Badge Title'
        }).appendTo(badgeContent);

        $('<div>', {
            class: 'badge-recipient',
            text: recipientType.val() || 'Recipient'
        }).appendTo(badgeContent);

        badgePreview.empty().append(badgeContainer);
    }

    // Function to generate SVG for saving
    function generateSVGForSaving() {
        const config = {
            primaryColor: primaryColor.val(),
            secondaryColor: secondaryColor.val(),
            title: badgeTitle.val() || 'Badge Title',
            recipient: recipientType.val() || 'Recipient'
        };

        const shape = badgeShape.val();
        const svgTemplate = BadgeSvgTemplates[shape](config);
        
        // Create a temporary container
        const container = document.createElement('div');
        container.innerHTML = svgTemplate;
        const svgElement = container.querySelector('svg');
        
        return svgElement;
    }

    // Bind events to update preview
    badgeTitle.on('input', updatePreview);
    recipientType.on('change', updatePreview);
    badgeShape.on('change', updatePreview);
    primaryColor.on('input', updatePreview);
    secondaryColor.on('input', updatePreview);
    badgeIcon.on('change', updatePreview);

    // Manual submit button click handler
    $('#createBadge').on('click', function () {
        badgeForm.trigger('submit');
    });

    // Helper function to draw hexagon
    function drawHexagon(ctx, x, y, size) {
        ctx.beginPath();
        for (let i = 0; i < 6; i++) {
            const angle = (i * Math.PI) / 3;
            const xPoint = x + size * Math.cos(angle);
            const yPoint = y + size * Math.sin(angle);
            if (i === 0) {
                ctx.moveTo(xPoint, yPoint);
            } else {
                ctx.lineTo(xPoint, yPoint);
            }
        }
        ctx.closePath();
    }

    // Helper function to create gradient
    function createGradient(ctx, width, height, primaryColor, secondaryColor) {
        const gradient = ctx.createLinearGradient(0, 0, width, height);
        gradient.addColorStop(0, primaryColor);
        gradient.addColorStop(1, secondaryColor);
        return gradient;
    }

    // Add to gradient options
    function createMetallicGradient(ctx, size, color) {
        const gradient = ctx.createLinearGradient(0, 0, size, size);
        gradient.addColorStop(0, lightenColor(color, 20));
        gradient.addColorStop(0.5, color);
        gradient.addColorStop(1, darkenColor(color, 20));
        return gradient;
    }

    function drawBadgeToCanvas(canvas, config) {
        const ctx = canvas.getContext('2d');
        const size = canvas.width;
        
        ctx.imageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';

        const gradient = ctx.createLinearGradient(0, 0, size, size);
        gradient.addColorStop(0, config.primaryColor);
        gradient.addColorStop(1, config.secondaryColor);

        const centerX = size / 2;
        const centerY = size / 2;
        const shapeSize = size * 0.9;

        switch (config.shape) {
            case 'hexagon':
                // Using the ribbon's hexagon proportions as it looks better
                ctx.beginPath();
                for (let i = 0; i < 6; i++) {
                    const angle = (i * Math.PI) / 3 - Math.PI / 6;
                    const xPoint = centerX + (shapeSize/2) * Math.cos(angle);
                    const yPoint = centerY + (shapeSize/2) * Math.sin(angle);
                    if (i === 0) ctx.moveTo(xPoint, yPoint);
                    else ctx.lineTo(xPoint, yPoint);
                }
                ctx.closePath();
                break;

            case 'shield':
                // Improved shield shape to match preview
                ctx.beginPath();
                const shieldWidth = shapeSize * 0.85;
                const shieldHeight = shapeSize * 0.95;
                
                // Start from top center
                ctx.moveTo(centerX, centerY - shieldHeight/2);
                
                // Right curve
                ctx.quadraticCurveTo(
                    centerX + shieldWidth/2, centerY - shieldHeight/2,
                    centerX + shieldWidth/2, centerY
                );
                
                // Bottom right curve
                ctx.quadraticCurveTo(
                    centerX + shieldWidth/2, centerY + shieldHeight/2,
                    centerX, centerY + shieldHeight/2
                );
                
                // Bottom left curve
                ctx.quadraticCurveTo(
                    centerX - shieldWidth/2, centerY + shieldHeight/2,
                    centerX - shieldWidth/2, centerY
                );
                
                // Left curve
                ctx.quadraticCurveTo(
                    centerX - shieldWidth/2, centerY - shieldHeight/2,
                    centerX, centerY - shieldHeight/2
                );
                
                ctx.closePath();
                break;

            case 'circle':
                ctx.beginPath();
                ctx.arc(centerX, centerY, shapeSize/2, 0, Math.PI * 2);
                ctx.closePath();
                break;

            case 'ribbon':
                ctx.beginPath();
                const ribbonWidth = shapeSize * 0.8;
                const ribbonHeight = shapeSize;
                
                ctx.moveTo(centerX, centerY - ribbonHeight/2);
                ctx.lineTo(centerX + ribbonWidth/2, centerY - ribbonHeight/4);
                ctx.lineTo(centerX + ribbonWidth/2, centerY + ribbonHeight/4);
                ctx.lineTo(centerX, centerY + ribbonHeight/2);
                ctx.lineTo(centerX - ribbonWidth/2, centerY + ribbonHeight/4);
                ctx.lineTo(centerX - ribbonWidth/2, centerY - ribbonHeight/4);
                ctx.closePath();
                
                // Ribbon tail
                ctx.moveTo(centerX, centerY + ribbonHeight/2);
                ctx.lineTo(centerX - ribbonWidth/4, centerY + ribbonHeight/3);
                ctx.lineTo(centerX, centerY + ribbonHeight/2.5);
                ctx.lineTo(centerX + ribbonWidth/4, centerY + ribbonHeight/3);
                break;

            case 'star': {
                // Improved star with better proportions
                ctx.beginPath();
                const spikes = 5;
                const outerRadius = shapeSize/2;
                const innerRadius = outerRadius * 0.5; // Increased from 0.4 for better proportions
                const rotation = Math.PI / 2; // Rotate to point upward
                
                for(let i = 0; i < spikes * 2; i++) {
                    const radius = i % 2 === 0 ? outerRadius : innerRadius;
                    const angle = (i * Math.PI) / spikes - rotation;
                    const x = centerX + radius * Math.cos(angle);
                    const y = centerY + radius * Math.sin(angle);
                    
                    if(i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.closePath();
                break;
            }

            case 'pentagon': {
                // New pentagon shape - clean and professional
                ctx.beginPath();
                const sides = 5;
                const radius = shapeSize/2;
                const rotation = -Math.PI/2; // Point upward
                
                for(let i = 0; i < sides; i++) {
                    const angle = (i * 2 * Math.PI / sides) + rotation;
                    const x = centerX + radius * Math.cos(angle);
                    const y = centerY + radius * Math.sin(angle);
                    
                    if(i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.closePath();
                break;
            }

            case 'octagon': {
                // Fixed octagon shape with correct gradient filling
                ctx.beginPath();
                const sides = 8;
                const radius = shapeSize/2;
                
                for(let i = 0; i < sides; i++) {
                    const angle = (i * 2 * Math.PI / sides) + Math.PI / 8; // Rotate by 1/8 PI for flat top
                    const x = centerX + radius * Math.cos(angle);
                    const y = centerY + radius * Math.sin(angle);
                    
                    if(i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.closePath();
                break;
            }
        }

        // Fill shape with gradient and add depth
        ctx.fillStyle = gradient;
        
        // Add subtle shadow for depth
        ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
        ctx.shadowBlur = size * 0.02;
        ctx.shadowOffsetY = size * 0.01;
        ctx.fill();
        
        // Reset shadow
        ctx.shadowColor = 'transparent';
        ctx.shadowBlur = 0;
        ctx.shadowOffsetY = 0;

        // Adjust content positioning based on shape
        let iconY = centerY - size/8;
        let titleY = centerY + size/16;
        let recipientY = centerY + size/4;

        // Adjust positions for specific shapes
        if (config.shape === 'star') {
            iconY = centerY - size/6;
            titleY = centerY + size/12;
            recipientY = centerY + size/3.5;
        } else if (config.shape === 'medal') {
            iconY = centerY - size/4;
            titleY = centerY;
            recipientY = centerY + size/6;
        }

        // Draw icon with glow
        if (config.icon) {
            ctx.shadowColor = 'rgba(255, 255, 255, 0.4)';
            ctx.shadowBlur = size * 0.03;
            ctx.font = `900 ${size/7}px "Font Awesome 5 Free"`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = 'white';
            ctx.fillText(config.icon, centerX, iconY);
            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
        }

        // Draw text with better visibility
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        
        // Title with shadow
        ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
        ctx.shadowBlur = 3;
        ctx.font = `bold ${size/12}px Inter, Arial`;
        ctx.fillStyle = 'white';
        ctx.fillText(config.title, centerX, titleY);

        // Recipient text
        ctx.font = `${size/16}px Inter, Arial`;
        ctx.fillText(config.recipient, centerX, recipientY);
    }

    // Modified form submission
    badgeForm.on('submit', function (e) {
        e.preventDefault();

        const submitBtn = $('#createBadge');
        submitBtn.prop('disabled', true).text('Saving...');

        // Create high-resolution canvas
        const canvas = document.createElement('canvas');
        canvas.width = 1000;  // High resolution
        canvas.height = 1000;

        // Get the Font Awesome icon character
        const iconElement = $('#badgePreview .badge-icon i')[0];
        const computedStyle = window.getComputedStyle(iconElement, ':before');
        const iconContent = computedStyle.content;

        // Configure badge
        const config = {
            shape: badgeShape.val(),
            primaryColor: primaryColor.val(),
            secondaryColor: secondaryColor.val(),
            title: badgeTitle.val() || 'Badge Title',
            recipient: recipientType.val() || 'Recipient',
            icon: iconContent.replace(/['"]/g, '') // Clean up icon content
        };

        // Load fonts before drawing
        Promise.all([
            document.fonts.load('900 10px "Font Awesome 5 Free"'),
            document.fonts.load('bold 10px Inter'),
            document.fonts.load('10px Inter')
        ]).then(() => {
            drawBadgeToCanvas(canvas, config);
            
            canvas.toBlob(function(blob) {
                const formData = new FormData();
                formData.append('method', 'createBadgeCategory');
                formData.append('badge_name', badgeTitle.val());
                formData.append('badge_description', badgeDescription.val());
                formData.append('badge_status', status.val());
                formData.append('badge_icon', blob, 'badge.png');
                
                if (requestId) {
                    formData.append('from_request_id', requestId);
                }

                $.ajax({
                    url: '/api',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: res.message || 'Badge saved successfully!'
                            }).then(() => {
                                badgeForm[0].reset();
                                updatePreview();
                                $('#addBadgeModal').modal('hide');
                                
                                if (typeof window.fetchBadges === 'function') {
                                    window.fetchBadges();
                                }
                                
                                if (requestId) {
                                    window.location.href = '/public/views/admin/adminlanding.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: res.message || 'Failed to save badge'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Server error while saving badge.'
                        });
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Create Badge');
                    }
                });
            }, 'image/png', 1.0);
        });
    });

    // Initial preview render
    updatePreview();
});