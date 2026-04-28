<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $now = now();

        $dailyIncome = $user->transactions()
            ->whereDate('date', $today)
            ->where('type', 'income')
            ->sum('amount');

        $dailyExpenses = $user->transactions()
            ->whereDate('date', $today)
            ->where('type', 'expense')
            ->sum('amount');

        $monthlyIncome = $user->transactions()
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->where('type', 'income')
            ->sum('amount');

        $monthlyExpenses = $user->transactions()
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->where('type', 'expense')
            ->sum('amount');

        $allTimeIncome = $user->transactions()
            ->where('type', 'income')
            ->sum('amount');

        $allTimeExpenses = $user->transactions()
            ->where('type', 'expense')
            ->sum('amount');

        $currentBalance = $allTimeIncome - $allTimeExpenses;

        $budgetLimit = (float) optional($user->budget)->monthly_limit;
        $budgetUsagePercent = $budgetLimit > 0 ? min(($monthlyExpenses / $budgetLimit) * 100, 100) : 0;
        $budgetRemaining = max($budgetLimit - $monthlyExpenses, 0);

        $monthlyExpensesByCategory = $user->transactions()
            ->select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $expenseTrend = $user->transactions()
            ->select('date', DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->whereBetween('date', [$now->copy()->subDays(6)->toDateString(), $now->toDateString()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(fn ($item) => \Carbon\Carbon::parse($item->date)->toDateString());

        $trendLabels = [];
        $trendValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dateKey = $day->toDateString();
            $trendLabels[] = $day->format('M d');
            $trendValues[] = (float) ($expenseTrend[$dateKey]->total ?? 0);
        }

        return view('dashboard', compact(
            'dailyIncome',
            'dailyExpenses',
            'monthlyIncome',
            'monthlyExpenses',
            'currentBalance',
            'budgetLimit',
            'budgetUsagePercent',
            'budgetRemaining',
            'monthlyExpensesByCategory',
            'trendLabels',
            'trendValues'
        ));
    }
}
