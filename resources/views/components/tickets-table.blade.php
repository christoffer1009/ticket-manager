@props(['tickets'])

<!-- Tabela de Tickets -->
<div class="overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                    Title
                </th>
                <th scope="col"
                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                    Status
                </th>
                <th scope="col"
                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                    Priority
                </th>
                <th scope="col"
                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                    Requester</th>
                <th scope="col"
                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                    Assignee</th>
                <th scope="col"
                    class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($tickets as $ticket)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-left text-gray-900 break-words whitespace-normal">
                        {{ $ticket->title }}</td>
                    <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                        <x-status-badge :status="$ticket->status" />
                    </td>
                    <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                        <x-priority-badge :priority="$ticket->priority" />
                    </td>
                    <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                        {{ $ticket->requester->name }}</td>
                    <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                        {{ $ticket->assignee ? $ticket->assignee->name : 'None' }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-left whitespace-nowrap">
                        <a href="{{ route('tickets.show', $ticket->id) }}"
                            class="text-indigo-600 hover:text-indigo-900">View</a>
                        @if (auth()->user()->role->name === 'admin')
                            <a href="{{ route('tickets.edit', $ticket->id) }}"
                                class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                class="inline-block ml-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
