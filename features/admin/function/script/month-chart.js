document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('salesChart').getContext('2d');
    var chartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Current Month Sales',
                data: [], // will be populated from server
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
                data: [], // will be populated from server
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
                    max: 100000, // Adjust as needed
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
        fetch('?action=getPayments')
            .then(response => response.json())
            .then(data => {
                // Clear existing data
                salesChart.data.datasets[0].data = Array(12).fill(0); // Current Month Sales
                salesChart.data.datasets[1].data = Array(12).fill(0); // Last Month Sales

                // Populate datasets
                salesChart.data.datasets[0].data = data.currentMonth;
                salesChart.data.datasets[1].data = data.lastMonth;

                salesChart.update();
            });
    }

    fetchPaymentData();
});
