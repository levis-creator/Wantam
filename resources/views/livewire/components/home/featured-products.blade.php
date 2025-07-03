<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $products = [
        [
            'name' => 'Wireless Headphones',
            'price' => 'Ksh 4,500',
            'original_price' => 'Ksh 6,000',
            'discount' => 25,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1010/400/300',
        ],
        [
            'name' => 'Smart Watch',
            'price' => 'Ksh 7,200',
            'original_price' => 'Ksh 9,000',
            'discount' => 20,
            'rating' => 5,
            'image' => 'https://picsum.photos/id/1011/400/300',
        ],
        [
            'name' => 'Bluetooth Speaker',
            'price' => 'Ksh 3,000',
            'original_price' => 'Ksh 3,500',
            'discount' => 14,
            'rating' => 3,
            'image' => 'https://picsum.photos/id/1012/400/300',
        ],
        [
            'name' => 'Digital Camera',
            'price' => 'Ksh 15,000',
            'original_price' => 'Ksh 18,000',
            'discount' => 17,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1013/400/300',
        ],
        [
            'name' => 'Fitness Tracker',
            'price' => 'Ksh 5,000',
            'original_price' => 'Ksh 6,000',
            'discount' => 16,
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1014/400/300',
        ],
        [
            'name' => 'Gaming Mouse',
            'price' => 'Ksh 2,200',
            'original_price' => 'Ksh 2,500',
            'discount' => 12,
            'rating' => 5,
            'image' => 'https://picsum.photos/id/1015/400/300',
        ],
        [
            'name' => 'USB-C Charger',
            'price' => 'Ksh 1,500',
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1016/400/300',
        ],
        [
            'name' => 'LED Desk Lamp',
            'price' => 'Ksh 3,800',
            'rating' => 4,
            'image' => 'https://picsum.photos/id/1017/400/300',
        ],
    ];
};
?>

<section class="py-12 px-4 md:px-10 bg-white dark:bg-zinc-900 mt-10">
    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">Featured Products</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <livewire:components.product-card :product="$product" />
        @endforeach
    </div>
</section>
