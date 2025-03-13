<div class="max-w-md mx-auto p-6 bg-white shadow-md rounded">
    <form wire:submit.prevent="login">
        <div>
            <label>Email:</label>
            <input type="email" wire:model="email" class="w-full p-2 border rounded">
            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label>Password:</label>
            <input type="password" wire:model="password" class="w-full p-2 border rounded">
            @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4 flex items-center">
            <input type="checkbox" wire:model="remember">
            <span class="ml-2">Remember Me</span>
        </div>

        <button type="submit" class="w-full mt-4 bg-blue-500 text-white p-2 rounded">Login</button>
    </form>
</div>
