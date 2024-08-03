@props(['data'])

<div class="p-4 bg-white rounded shadow">
    <h2 class="mb-4 text-xl font-semibold">Tickets Created and Closed Over Time</h2>
    <div class="relative w-full h-64">
        <canvas id="lineChart" class="w-full h-full"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('lineChart').getContext('2d');

        const data = @json($data);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                        label: 'Created Tickets',
                        data: data.created,
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 175, 80, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Closed Tickets',
                        data: data.closed,
                        borderColor: '#F44336',
                        backgroundColor: 'rgba(244, 67, 54, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (context.parsed.y !== null) {
                                    label += `: ${context.parsed.y}`;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
