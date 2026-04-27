<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions</h2>
            <a href="{{ route('transactions.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">Add Transaction</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $transaction->date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-sm capitalize">{{ $transaction->type }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $transaction->category }}</td>
                                    <td class="px-4 py-3 text-sm font-medium {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $transaction->description ?: '-' }}</td>
                                    <td class="px-4 py-3 text-right text-sm">
                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">Edit</a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Delete this transaction?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
