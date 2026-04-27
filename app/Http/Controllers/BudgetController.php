<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBudgetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function show(): View
    {
        $budget = Auth::user()->budget;
        $monthlyExpense = Auth::user()
            ->transactions()
            ->where('type', 'expense')
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('amount');

        $budgetLimit = (float) ($budget->monthly_limit ?? 0);
        $usagePercent = $budgetLimit > 0 ? min(($monthlyExpense / $budgetLimit) * 100, 100) : 0;
        $remaining = max($budgetLimit - $monthlyExpense, 0);

        return view('budget.show', compact('budget', 'monthlyExpense', 'usagePercent', 'remaining'));
    }

    public function update(UpdateBudgetRequest $request): RedirectResponse
    {
        Auth::user()->budget()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['monthly_limit' => $request->validated('monthly_limit')]
        );

        return redirect()
            ->route('budget.show')
            ->with('success', 'Monthly budget saved successfully.');
    }
}
