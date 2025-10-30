document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart for Badge Requests
    const badgeRequestsCtx = document.getElementById('badgeRequestsChart').getContext('2d');
    new Chart(badgeRequestsCtx, {
        type: 'bar',
        data: {
            labels: ['1', '2', '3', '4', '5'],
            datasets: [{
                label: 'Pending Requests',
                data: [12, 19, 8, 15, 10],
                backgroundColor: 'rgba(106, 76, 147, 0.5)',
                borderColor: 'rgba(106, 76, 147, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Pie Chart for Categories Distribution
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'pie',
        data: {
            labels: ['1', '2', '3', '4', '5'],
            datasets: [{
                data: [20, 25, 15, 20, 20],
                backgroundColor: [
                    'rgba(106, 76, 147, 0.8)',
                    'rgba(146, 106, 197, 0.8)',
                    'rgba(166, 126, 217, 0.8)',
                    'rgba(186, 146, 237, 0.8)',
                    'rgba(206, 166, 255, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});