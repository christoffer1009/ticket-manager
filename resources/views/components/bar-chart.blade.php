@props(['data'])

<div class="p-4 bg-white rounded shadow">
    <h2 class="mb-4 text-xl font-semibold">Tickets by Priority</h2>
    <div class="relative w-full h-64">
        <canvas id="barChart" class="w-full h-full"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('barChart').getContext('2d');

        const data = @json($data);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Tickets',
                    data: data.values,
                    backgroundColor: [
                        '#4CAF50', // Low
                        '#FFC107', // Medium
                        '#FF5722', // High
                        '#F44336' // Critical
                    ],
                }]
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
