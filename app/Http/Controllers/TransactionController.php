<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Auth::user()
            ->transactions()
            ->latest('date')
            ->latest('id')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        return view('transactions.create');
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Auth::user()->transactions()->create($request->validated());

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('transactions.index');
    }

    public function edit(string $id): View
    {
        $transaction = Auth::user()->transactions()->findOrFail($id);

        return view('transactions.edit', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, string $id): RedirectResponse
    {
        $transaction = Auth::user()->transactions()->findOrFail($id);
        $transaction->update($request->validated());

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $transaction = Auth::user()->transactions()->findOrFail($id);
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
