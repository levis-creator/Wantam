<header x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show" x-transition:enter="transition ease-out duration-700"
    x-transition:enter-start="opacity-0 -translate-y-5" x-transition:enter-end="opacity-100 translate-y-0"
    class="sticky top-0 z-50">
    {{-- Topbar --}}
    <div class="bg-zinc-100 dark:bg-zinc-800 px-4 md:px-28 py-3 flex items-center justify-between gap-2 text-sm">
        <div>
            {{ config('app.company_info.email') }}
        </div>
        <div class="flex items-center gap-4">
            {{-- Dark Mode Toggle --}}
            <livewire:components.theme-toggle />
            <a href="/admin/login" wire:navigate class="hover:underline">{{ __('Admin Login') }}</a>
        </div>
    </div>

    {{-- Navigation Bar --}}
    <nav class="bg-white dark:bg-zinc-900 px-4 md:px-28 py-4 md:py-6 flex items-center justify-between gap-4 shadow-md">
        {{-- Logo --}}
        <div class="inline-flex items-center">
            <x-app-logo class="w-8 h-8 md:w-10 md:h-10" />
        </div>

        {{-- Search Section --}}
        <div class="w-full hidden md:w-auto md:flex flex-col sm:flex-row items-center gap-2 md:gap-4">
            <flux:input icon="magnifying-glass" placeholder="Search products, brands and categories"
                class="w-full sm:w-64" />
            <flux:button variant="primary" class="w-full sm:w-auto">Search</flux:button>
        </div>

        {{-- Icon Buttons --}}
        <div class="flex items-center gap-3">
            <flux:button icon="shopping-cart" variant="ghost" />
            <flux:button icon="user" variant="ghost" />
        </div>
    </nav>
</header>
