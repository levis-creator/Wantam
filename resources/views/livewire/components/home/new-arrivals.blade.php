<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $newArrivals = [
        [
            'name' => 'Noise Cancelling Earbuds',
            'price' => 'Ksh 6,800',
            'original_price' => 'Ksh 8,500',
            'discount' => 20,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1020/400/300',
        ],
        [
            'name' => '4K Action Camera',
            'price' => 'Ksh 12,000',
            'original_price' => 'Ksh 15,000',
            'discount' => 20,
            'rating' => 5,
            'image' => 'https://picsum.photos/id/1021/400/300',
        ],
        [
            'name' => 'Portable Projector',
            'price' => 'Ksh 10,500',
            'original_price' => null,
            'discount' => null,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1022/400/300',
        ],
        [
            'name' => 'Smart Home Light Bulb',
            'price' => 'Ksh 2,400',
            'original_price' => 'Ksh 3,000',
            'discount' => 20,
            'rating' => 3,
            'image' => 'https://picsum.photos/id/1023/400/300',
        ],
    ];
};
?>

<section class="py-12 px-4 md:px-10 bg-white dark:bg-zinc-900 my-10"">
    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">
        New Arrivals
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($newArrivals as $product)
            <livewire:components.product-card :product="$product" />
        @endforeach
    </div>
</section>
