<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Transaction</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('transactions.store') }}" class="space-y-4">
                    @csrf
                    @include('transactions.partials.form')
                    <div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
