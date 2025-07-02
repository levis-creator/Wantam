<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $categories = [
        [
            'name' => 'Headphones',
            'image' => 'https://picsum.photos/id/1030/400/300',
        ],
        [
            'name' => 'Watches',
            'image' => 'https://picsum.photos/id/1031/400/300',
        ],
        [
            'name' => 'Cameras',
            'image' => 'https://picsum.photos/id/1032/400/300',
        ],
        [
            'name' => 'Fitness',
            'image' => 'https://picsum.photos/id/1033/400/300',
        ],
        [
            'name' => 'Gaming',
            'image' => 'https://picsum.photos/id/1034/400/300',
        ],
        [
            'name' => 'Accessories',
            'image' => 'https://picsum.photos/id/1035/400/300',
        ],
    ];
};
?>

<section class="py-12 px-4 md:px-10 bg-white dark:bg-zinc-900 my-10">
    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">
        Top Categories
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach ($categories as $category)
            <a href="#"
               class="group rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 hover:shadow-lg transition-all duration-300 block">
                <div class="aspect-[4/3] w-full overflow-hidden">
                    <img src="{{ $category['image'] }}"
                         alt="{{ $category['name'] }}"
                         class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105" />
                </div>
                <div class="text-center py-3">
                    <h3 class="text-sm font-medium text-zinc-700 dark:text-white group-hover:underline">
                        {{ $category['name'] }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>
</section>
