<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('proposals.update', $proposal) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select name="customer_id" id="customer_id" class="mt-1 block w-full" required>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $proposal->customer_id === $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" value="{{ $proposal->title }}" class="mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" class="mt-1 block w-full" required>{{ $proposal->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" name="amount" id="amount" step="0.01" value="{{ $proposal->amount }}" class="mt-1 block w-full" required>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>