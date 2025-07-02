<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $categories = [
        'Electronics',
        'Fashion',
        'Home & Kitchen',
        'Beauty & Health',
        'Books',
        'Sports & Outdoors',
        'Toys & Games',
        'Automotive',
        'Groceries',
        'Office Supplies',
        'Garden & Outdoor',
        'Pet Supplies',
        
    ];
};
?>

<aside
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 200)"
    x-show="show"
    x-transition:enter="transition ease-out duration-700"
    x-transition:enter-start="opacity-0 -translate-x-4"
    x-transition:enter-end="opacity-100 translate-x-0"
    class="md:col-span-1 bg-white dark:bg-zinc-900 p-6 rounded shadow-sm"
>
    <h2 class="text-lg font-semibold mb-4 text-zinc-800 dark:text-zinc-100">Categories</h2>
    <ul class="space-y-3 text-sm">
        @foreach(array_slice($categories, 0, 9) as $category)
            <li>
                <a href="#" class="block px-3 py-2 rounded hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                    {{ $category }}
                </a>
            </li>
        @endforeach
    </ul>
</aside>
