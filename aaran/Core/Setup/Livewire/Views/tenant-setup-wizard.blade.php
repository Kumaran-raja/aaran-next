<div>
    <!-- Global Loading Component -->
    <x-Ui::loadings.loading/>

    <!-- Banner -->
    <div>
        <x-Ui::web.home-new.items.banner
            label="Setup"
            desc="Empowering your digital dreams"
            padding="sm:px-[160px]"
            padding_mob="px-[70px]"
        />
    </div>

    <div class="mt-10 max-w-3xl mx-auto bg-white shadow-lg border border-neutral-200 rounded-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Setup</h2>
            <p class="text-gray-600">Step {{ $step }} of 3</p>
        </div>

        <!-- Step 1: Tenant Details -->
        @if($step === 1)
            <div class="mb-4">
                <label class="block text-gray-700">Business Name</label>
                <input type="text" wire:model.debounce.500ms="b_name"
                       class="w-full border rounded px-3 py-2 mt-1 @error('b_name') border-red-500 @enderror">
                @error('b_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Tenant Name</label>
                <input type="text" wire:model.debounce.500ms="t_name"
                       class="w-full border rounded px-3 py-2 mt-1 @error('t_name') border-red-500 @enderror">
                @error('t_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" wire:model.debounce.500ms="email"
                       class="w-full border rounded px-3 py-2 mt-1 @error('email') border-red-500 @enderror">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <!-- Step 2: Database Setup -->
        @if($step === 2)
            <div class="mb-4">
                <label class="block text-gray-700">Database Name</label>
                <input type="text" wire:model.debounce.500ms="db_name"
                       class="w-full border rounded px-3 py-2 mt-1 @error('db_name') border-red-500 @enderror">
                @error('db_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Database User</label>
                <input type="text" wire:model.debounce.500ms="db_user"
                       class="w-full border rounded px-3 py-2 mt-1 @error('db_user') border-red-500 @enderror">
                @error('db_user') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Database Password</label>
                <input type="password" wire:model.debounce.500ms="db_pass"
                       class="w-full border rounded px-3 py-2 mt-1 @error('db_pass') border-red-500 @enderror">
                @error('db_pass') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <!-- Step 3: Subscription & Security -->
        @if($step === 3)
            <div class="mb-4">
                <label class="block text-gray-700">Plan</label>
                <select wire:model="plan" class="w-full border rounded px-3 py-2 mt-1 @error('plan') border-red-500 @enderror">
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>
                @error('plan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Storage Limit (GB)</label>
                <input type="number" wire:model="storage_limit"
                       class="w-full border rounded px-3 py-2 mt-1 @error('storage_limit') border-red-500 @enderror">
                @error('storage_limit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            @if($step > 1)
                <button wire:click="prevStep" class="bg-gray-500 text-white px-4 py-2 rounded cursor-pointer">Previous</button>
            @endif
            @if($step < 3)
                <button wire:click="nextStep" class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer">Next</button>
            @endif
            @if($step === 3)
                <button wire:click="createTenant" class="bg-green-500 text-white px-4 py-2 rounded cursor-pointer">Submit</button>
            @endif
        </div>
    </div>

    <div class="mt-5 max-w-3xl mx-auto">
        <!-- Success Alert -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="bg-green-500 text-white p-3 rounded-lg shadow-md mb-4">
                <strong>✅ Success:</strong> {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert -->
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)"
                 class="bg-red-500 text-white p-3 rounded-lg shadow-md mb-4">
                <strong>⚠️ Error:</strong> {{ session('error') }}
            </div>
        @endif

        <canvas id="confetti-canvas" class="fixed inset-0 pointer-events-none"></canvas>
    </div>
</div>

<!-- Confetti Effect -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.addEventListener('tenant-created', function () {
            let duration = 2 * 1000;
            let animationEnd = Date.now() + duration;
            let colors = ['#bb0000', '#ffffff', '#0000ff'];

            (function frame() {
                confetti({
                    particleCount: 5,
                    spread: 80,
                    origin: { y: 0.6 },
                    colors: colors
                });

                if (Date.now() < animationEnd) {
                    requestAnimationFrame(frame);
                }
            })();

            // ⏳ Wait before redirecting
            setTimeout(() => {
                document.getElementById('success-message')?.classList.add('opacity-0');
            }, 3000);

            setTimeout(() => {
                window.location.href = "{{ route('dashboard') }}";
            }, 5000);
        });
    });
</script>
