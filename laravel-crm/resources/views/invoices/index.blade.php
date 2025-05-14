<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('invoices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Invoice</a>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->customer->name }}</td>
                                    <td>{{ number_format($invoice->amount, 2) }}</td>
                                    <td>{{ $invoice->status }}</td>
                                    <td>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        <form action="{{ route('invoices.updateStatus', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="pending" {{ $invoice->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="failed" {{ $invoice->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                            </select>
                                        </form>
                                        <a href="{{ route('invoices.send', $invoice) }}" class="text-green-500">Send</a>
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