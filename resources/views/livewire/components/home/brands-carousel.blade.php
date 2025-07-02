<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $brands = [
        ['name' => 'Samsung', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg'],
        ['name' => 'Apple', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg'],
        ['name' => 'Sony', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/Sony_logo.svg'],
        ['name' => 'HP', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4f/HP_logo_2012.svg'],
        ['name' => 'Lenovo', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Lenovo_Global_Corporate_Logo.png'],
        ['name' => 'LG', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/27/LG_logo_%282015%29.svg'],
    ];
};
?>

<section class="py-12 bg-white dark:bg-zinc-900 my-10">
    <h2 class="text-2xl md:text-3xl font-bold text-center text-zinc-800 dark:text-white mb-10">Our Trusted Brands</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 px-6 items-center justify-items-center">
        @foreach ($brands as $brand)
            <div class="grayscale hover:grayscale-0 transition duration-300 ease-in-out">
                <img src="{{ $brand['logo'] }}" alt="{{ $brand['name'] }}" class="h-12 object-contain" loading="lazy">
            </div>
        @endforeach
    </div>
</section>
