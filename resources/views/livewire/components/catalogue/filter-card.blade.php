<?php

use Livewire\Volt\Component;

new class extends Component {
    public $categories;
    public $minPrice = null;
    public $maxPrice = null;
    public $availability = [];
    public $ratings = [];

    public function updated($property)
    {
        // Dispatch filter event on update
        $this->dispatch('filters-applied', [
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'availability' => $this->availability,
            'ratings' => $this->ratings,
        ]);
    }
};
?>



<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6 space-y-8">

    <!-- Category Section -->
    <div class="space-y-4">
        <h3
            class="text-lg font-semibold text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-zinc-700">
            Categories
        </h3>
        <ul class="space-y-2 text-sm">
            @foreach ($categories as $category)
                <li>
                    <a href="/category/{{ $category->slug }}" wire:navigate
                        class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Price Range Filter -->
    <div class="space-y-4 mb-4">
        <h3
            class="text-lg font-semibold text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-zinc-700">
            Filter by Price
        </h3>
        <div class="flex flex-col gap-3">
            <input type="number" wire:model.lazy="minPrice" placeholder="Min"
                class="flex-1 px-4 py-2 border rounded-md bg-white dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
            <input type="number" wire:model.lazy="maxPrice" placeholder="Max"
                class="flex-1 px-4 py-2 border rounded-md bg-white dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
    </div>

    <!-- Availability Filter -->
    <div class="space-y-4 mb-4">
        <h3
            class="text-lg font-semibold text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-zinc-700">
            Availability
        </h3>
        <div class="flex flex-col gap-2 text-sm text-gray-700 dark:text-gray-300">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" wire:model.lazy="availability" value="in_stock" class="accent-primary">
                <span>In Stock</span>
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" wire:model.lazy="availability" value="out_of_stock" class="accent-primary">
                <span>Out of Stock</span>
            </label>
        </div>
    </div>

    <!-- Rating Filter -->
    <div class="space-y-4">
        <h3
            class="text-lg font-semibold text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-zinc-700">
            Customer Rating
        </h3>
        <div class="flex flex-col gap-2 text-sm text-gray-700 dark:text-gray-300">
            @for ($i = 5; $i >= 1; $i--)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model.lazy="ratings" value="{{ $i }}" class="accent-primary">
                    <span>{{ $i }} star{{ $i > 1 ? 's' : '' }} & up</span>
                </label>
            @endfor
        </div>
    </div>

</div>
