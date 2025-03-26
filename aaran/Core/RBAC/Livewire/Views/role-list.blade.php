<div class="p-6 bg-gray-100">
    <h1 class="text-xl font-bold">Welcome to {{ $tenant->name }}'s Dashboard</h1>

<div class="mt-4">
    <p><strong>Domain:</strong> {{ $tenant->domain }}</p>
    <p><strong>Database:</strong> {{ $tenant->database }}</p>
    <p><strong>Status:</strong> {{ ucfirst($tenant->status) }}</p>
</div>

<div class="mt-6">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Manage Users</button>
    <button class="px-4 py-2 bg-green-600 text-white rounded">Settings</button>
</div>
</div>

