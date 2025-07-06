<?php

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {
    public $categories;

    public function mount()
    {
        $this->categories = Category::parents()
            ->active()
            ->select('id', 'name', 'slug') // Optional: optimize fields
            ->orderBy('name')
            ->limit(9)
            ->get();
    }
};
?>
<aside x-data="{ show: false, openList: false }" x-init="setTimeout(() => show = true, 200)" x-show="show" x-transition:enter="transition ease-out duration-700"
    x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
    class="md:col-span-1 bg-white dark:bg-zinc-900 p-6 rounded shadow-sm absolute top-0 z-10 w-full lg:block h-full">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Categories</h2>

        <!-- Toggle visible only on small screens -->
        <button @click="openList = !openList" class="lg:hidden">
            <flux:icon name="bars-3" />
        </button>
    </div>

    <!-- 👇 Mobile dropdown list -->
    <ul x-show="openList" class="space-y-3 text-sm lg:hidden">
        @foreach ($categories as $category)
            <li>
                <a href="{{ $category->slug }}"
                    class="block px-3 py-2 rounded hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- 👇 Desktop list -->
    <ul class="space-y-3 text-sm hidden lg:block">
        @foreach ($categories as $category)
            <li>
                <a href="{{ $category->slug }}" wire:navigate
                    class="block px-3 py-2 rounded hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</aside>
