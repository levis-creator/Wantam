<?php

use Livewire\Volt\Component;
use App\Service\CatalogueService;

new class extends Component {
    public $products;
    public function mount(CatalogueService $catalogue)
    {
        $this->categories = $catalogue->fetchCategories();
    }
}; ?>


<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    {{-- Sidebar Filter --}}
    <div class="col-span-1">
        <livewire:components.catalogue.filter-card />

    </div>

    {{-- Product Section --}}
    <div class=" col-span-1 md:col-span-3 space-y-4">
        {{-- Example: Heading --}}
        <div class="border-b pb-3 mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Products</h2>
        </div>

        {{-- Example: Product Cards (Placeholder) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach (range(1, 9) as $i)
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                    <div class="h-40 bg-gray-200 dark:bg-zinc-700 mb-3 rounded"></div>
                    <h4 class="font-medium text-gray-700 dark:text-white mb-1">Product {{ $i }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">$19.99</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
