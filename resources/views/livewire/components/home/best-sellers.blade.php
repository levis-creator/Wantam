<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $bestSellers = [
        [
            'name' => 'Noise Cancelling Headphones',
            'price' => 'Ksh 9,500',
            'original_price' => 'Ksh 12,000',
            'discount' => 21,
            'rating' => 5,
            'image' => 'https://picsum.photos/id/1024/400/300',
        ],
        [
            'name' => 'Smartphone Gimbal Stabilizer',
            'price' => 'Ksh 6,300',
            'original_price' => 'Ksh 8,000',
            'discount' => 21,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1025/400/300',
        ],
        [
            'name' => 'Wireless Mechanical Keyboard',
            'price' => 'Ksh 4,800',
            'original_price' => null,
            'discount' => null,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1026/400/300',
        ],
        [
            'name' => 'Ergonomic Office Chair',
            'price' => 'Ksh 18,500',
            'original_price' => 'Ksh 22,000',
            'discount' => 16,
            'rating' => 5,
            'image' => 'https://picsum.photos/id/1027/400/300',
        ],
    ];
};
?>

<section class="py-12 px-4 md:px-10 bg-zinc-50 dark:bg-zinc-900">
    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">
        Best Sellers
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($bestSellers as $product)
            <livewire:components.product-card :product="$product" />
        @endforeach
    </div>
</section>
