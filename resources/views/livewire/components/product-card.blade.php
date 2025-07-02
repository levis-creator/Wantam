<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $product;
};
?>

<a href="#"
   class="block bg-white overflow-hidden dark:bg-zinc-800 rounded-xl shadow transition-all duration-300 group hover:shadow-2xl hover:-translate-y-1">
    <div class="relative aspect-[4/3] w-full overflow-hidden">
        <img src="{{ $product['image'] }}"
             alt="{{ $product['name'] }}"
             class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105">

        @if (isset($product['discount']))
            <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                -{{ $product['discount'] }}%
            </span>
        @endif
    </div>

    <div class="p-4 flex flex-col gap-2">
        <h3 class="text-base md:text-lg font-semibold text-zinc-800 dark:text-white">
            {{ $product['name'] }}
        </h3>
        
        <div class="flex items-center gap-2">
            @if (isset($product['original_price']))
                <span class="text-sm text-red-600 font-bold">{{ $product['price'] }}</span>
                <span class="text-xs line-through text-zinc-500 dark:text-zinc-400">
                    {{ $product['original_price'] }}
                </span>
            @else
                <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $product['price'] }}</span>
            @endif
        </div>

        @if (isset($product['rating']))
            <div class="flex items-center text-yellow-400 text-xs">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $product['rating'])
                        ★
                    @else
                        ☆
                    @endif
                @endfor
                <span class="ml-2 text-zinc-500 dark:text-zinc-400">({{ $product['rating'] }}/5)</span>
            </div>
        @endif
    </div>
</a>
