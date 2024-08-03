@props(['data'])

<div class="p-4 bg-white rounded shadow">
    <h2 class="mb-4 text-xl font-semibold">Ticket Status Distribution</h2>
    <div class="relative w-full h-64 max-w-lg mx-auto">
        <!-- Canvas will fill the container -->
        <canvas id="{{ $attributes->get('id', 'pieChart') }}" class="absolute inset-0 w-full h-full"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('{{ $attributes->get('id', 'pieChart') }}').getContext('2d');

        // Certifique-se de que chartData está disponível
        const chartData = @json($data);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Ticket Status Distribution',
                    data: chartData.values,
                    backgroundColor: [
                        '#28A745',
                        '#FFC107',
                        '#DC3545'
                    ],
                    hoverOffset: 4
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
                                let label = context.label || '';
                                if (context.parsed !== null) {
                                    label += `: ${context.parsed} tickets`;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
