<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proposals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('proposals.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Proposal</a>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposals as $proposal)
                                <tr>
                                    <td>{{ $proposal->customer->name }}</td>
                                    <td>{{ $proposal->title }}</td>
                                    <td>{{ number_format($proposal->amount, 2) }}</td>
                                    <td>{{ $proposal->status }}</td>
                                    <td>
                                        <a href="{{ route('proposals.edit', $proposal) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        <form action="{{ route('proposals.updateStatus', $proposal) }}" method="POST" class="inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="pending" {{ $proposal->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="accepted" {{ $proposal->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                <option value="rejected" {{ $proposal->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>