document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    
    fetch('/admin/api/sales-data')
        .then(response => response.json())
        .then(data => {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: data.dates,
                    datasets: [{
                        label: 'Daily Sales',
                        data: data.amounts,
                        borderColor: '#4CAF50',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });

    // Real-time updates
    const eventSource = new EventSource('/admin/api/real-time-updates');
    eventSource.onmessage = function(e) {
        const update = JSON.parse(e.data);
        if (update.type === 'verification') {
            document.querySelector('.verification-pending p').textContent = update.count;
        }
        if (update.type === 'sales') {
            const salesChart = Chart.getChart('salesChart');
            salesChart.data.datasets[0].data.push(update.amount);
            salesChart.data.labels.push(new Date().toLocaleDateString());
            salesChart.update();
        }

    };
});