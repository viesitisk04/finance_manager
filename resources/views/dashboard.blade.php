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

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-gray-700 mb-1">Monthly Spending by Category</h3>
                    <p class="text-sm text-gray-500 mb-4">Automatically generated from your expense transactions.</p>
                    <canvas id="categorySpendingChart" height="220"></canvas>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-gray-700 mb-1">Last 7 Days Spending Trend</h3>
                    <p class="text-sm text-gray-500 mb-4">Daily expense totals based on your inputted spending.</p>
                    <canvas id="weeklySpendingTrendChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const categoryLabels = @json($monthlyExpensesByCategory->pluck('category'));
        const categoryValues = @json($monthlyExpensesByCategory->pluck('total')->map(fn ($value) => (float) $value));

        const trendLabels = @json($trendLabels);
        const trendValues = @json($trendValues);

        const categoryCanvas = document.getElementById('categorySpendingChart');
        if (categoryCanvas) {
            if (categoryLabels.length > 0) {
                new Chart(categoryCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryValues,
                            backgroundColor: ['#4f46e5', '#16a34a', '#dc2626', '#f59e0b', '#0891b2', '#7c3aed', '#ea580c'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } else {
                categoryCanvas.parentElement.insertAdjacentHTML('beforeend', '<p class="text-sm text-gray-500 mt-3">No expense data available for this month yet.</p>');
            }
        }

        const trendCanvas = document.getElementById('weeklySpendingTrendChart');
        if (trendCanvas) {
            new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Daily Expenses',
                        data: trendValues,
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.12)',
                        tension: 0.35,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
