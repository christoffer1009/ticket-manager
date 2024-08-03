@props(['topTechnicians'])
<div class="p-4 bg-white rounded shadow">
    <h2 class="mb-4 text-xl font-semibold">Top Technicians</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Technician</th>
                <th class="py-2">Closed Tickets</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topTechnicians as $technician)
                <tr>
                    <td class="py-2">{{ $technician['name'] }}</td>
                    <td class="py-2 text-center">{{ $technician['total_closed'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
