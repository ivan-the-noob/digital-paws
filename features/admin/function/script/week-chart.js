document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('weekSalesChart').getContext('2d');
    
    var chartData = {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], // Weeks based on your defined ranges
        datasets: [
            {
                label: 'Current Month Sales',
                data: [], // Will be populated from server
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)'
            },
            {
                label: 'Last Month Sales',
                data: [], // Will be populated from server
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(255, 99, 132, 1)'
            }
        ]
    };

    var salesChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 50000, // Adjust as needed based on your weekly data range
                    ticks: {
                        callback: function(value, index, values) {
                            return value + '₱';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw + '₱';
                            return label;
                        }
                    }
                }
            }
        }
    });

    function fetchPaymentData() {
        fetch('?action=getWeeklyPayments')
            .then(response => response.json())
            .then(data => {
                var currentWeekData = data.currentWeek; // Data for current month
                var lastWeekData = data.lastWeek; // Data for last month

                // Reset datasets
                salesChart.data.datasets[0].data = currentWeekData;
                salesChart.data.datasets[1].data = lastWeekData;

                // Update the chart
                salesChart.update();
            });
    }

    fetchPaymentData();
});
