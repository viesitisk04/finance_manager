<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finance Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Daily Income</p>
                    <p class="text-2xl font-semibold text-green-600">${{ number_format($dailyIncome, 2) }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Daily Expenses</p>
                    <p class="text-2xl font-semibold text-red-600">${{ number_format($dailyExpenses, 2) }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Monthly Income</p>
                    <p class="text-2xl font-semibold text-green-600">${{ number_format($monthlyIncome, 2) }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Monthly Expenses</p>
                    <p class="text-2xl font-semibold text-red-600">${{ number_format($monthlyExpenses, 2) }}</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-gray-700 mb-2">Current Balance</h3>
                    <p class="text-3xl font-bold {{ $currentBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($currentBalance, 2) }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-gray-700 mb-2">Budget Usage</h3>
                    @if ($budgetLimit > 0)
                        <p class="text-sm text-gray-500 mb-2">
                            ${{ number_format($budgetRemaining, 2) }} remaining from ${{ number_format($budgetLimit, 2) }}
                        </p>
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-3 bg-indigo-600" style="width: {{ $budgetUsagePercent }}%"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ number_format($budgetUsagePercent, 1) }}% used</p>
                    @else
                        <p class="text-sm text-gray-500">No monthly budget set yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
