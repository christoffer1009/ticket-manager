@props(['searchTerm', 'statuses', 'selectedStatus', 'priorities', 'selectedPriority'])

<form action="{{ route('tickets.index') }}" method="GET" class="mb-4">
    <div class="flex flex-col items-center md:flex-row">
        <input type="text" name="search" id="search" value="{{ $searchTerm }}"
            placeholder="Search by title or description"
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none md:w-1/3 focus:outline-none focus:shadow-outline" />

        <select name="status" id="status"
            class="w-full px-2 py-1 pr-8 mt-2 leading-tight bg-white border border-gray-400 rounded shadow appearance-none md:w-1/3 md:mt-0 md:ml-2 hover:border-gray-500 focus:outline-none focus:shadow-outline">
            <option value="">All Statuses</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" {{ $selectedStatus == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>

        <select name="priority" id="priority"
            class="w-full px-2 py-1 pr-8 mt-2 leading-tight bg-white border border-gray-400 rounded shadow appearance-none md:w-1/3 md:mt-0 md:ml-2 hover:border-gray-500 focus:outline-none focus:shadow-outline">
            <option value="">All Priorities</option>
            @foreach ($priorities as $priority)
                <option value="{{ $priority->id }}" {{ $selectedPriority == $priority->id ? 'selected' : '' }}>
                    {{ $priority->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            class="mx-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2  focus:outline-none">
            Search
        </button>
    </div>
</form>
