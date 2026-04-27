<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Monthly Budget</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ route('budget.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="monthly_limit" class="block text-sm font-medium text-gray-700">Monthly Budget Limit</label>
                        <input type="number" step="0.01" min="0" id="monthly_limit" name="monthly_limit" value="{{ old('monthly_limit', $budget->monthly_limit ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                        @error('monthly_limit') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Save Budget</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-3">Current Month Usage</h3>
                <p class="text-sm text-gray-600 mb-2">Spent this month: ${{ number_format($monthlyExpense, 2) }}</p>
                <p class="text-sm text-gray-600 mb-2">Remaining: ${{ number_format($remaining, 2) }}</p>
                <p class="text-sm text-gray-600 mb-3">Usage: {{ number_format($usagePercent, 1) }}%</p>
                <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-3 bg-indigo-600" style="width: {{ $usagePercent }}%"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
