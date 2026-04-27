<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Finance Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="flex justify-end gap-3 mb-8">
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-white border rounded-md">Log in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Register</a>
            @endauth
        </div>

        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold mb-4">Personal Finance Manager</h1>
            <p class="text-gray-600 mb-6">
                Track your income and expenses, monitor your monthly budget, and view daily and monthly financial insights in one place.
            </p>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="p-4 border rounded-md bg-gray-50">
                    <h2 class="font-semibold mb-2">Guest access</h2>
                    <p class="text-sm text-gray-600">You can preview this homepage, but creating or editing data requires authentication.</p>
                </div>
                <div class="p-4 border rounded-md bg-gray-50">
                    <h2 class="font-semibold mb-2">Authenticated users</h2>
                    <p class="text-sm text-gray-600">Manage transactions, set a monthly budget, and view finance statistics on your dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
