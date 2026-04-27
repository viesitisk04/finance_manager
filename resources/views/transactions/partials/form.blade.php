<div>
    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
    <input type="number" step="0.01" min="0" name="amount" id="amount" value="{{ old('amount', $transaction->amount ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
    @error('amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300" required>
        <option value="income" @selected(old('type', $transaction->type ?? '') === 'income')>Income</option>
        <option value="expense" @selected(old('type', $transaction->type ?? '') === 'expense')>Expense</option>
    </select>
    @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
    <input type="text" name="category" id="category" value="{{ old('category', $transaction->category ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
    @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $transaction->description ?? '') }}</textarea>
    @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
    <input type="date" name="date" id="date" value="{{ old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
    @error('date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>
