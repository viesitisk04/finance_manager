<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        return view('dashboard', compact(
            'dailyIncome',
            'dailyExpenses',
            'monthlyIncome',
            'monthlyExpenses',
            'currentBalance',
            'budgetLimit',
            'budgetUsagePercent',
            'budgetRemaining'
        ));
    }
}
