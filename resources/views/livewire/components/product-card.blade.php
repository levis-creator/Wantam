<?php

use Livewire\Volt\Component;

new class extends Component {
    public $product; // explicitly declare as array
};
?>

<a href="#"
    class="block bg-white overflow-hidden dark:bg-zinc-800 rounded-xl shadow transition-all duration-300 group hover:shadow-2xl hover:-translate-y-1">
    <div class="relative aspect-[4/3] w-full overflow-hidden">
        @if (isset($product['main_image']))
            <img src="{{ asset('storage/' . $product['main_image']) }}" alt="{{ $product['name'] ?? '' }}"
                class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105">
        @else
            <div class="w-full h-full bg-zinc-300 flex items-center justify-center text-sm text-zinc-600">
                No Image
            </div>
        @endif
        {{-- Discount badge (optional) --}}
        @if (!empty($product['discount']))
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
            @if (!empty($product['original_price']))
                <span class="text-sm text-red-600 font-bold">
                    Ksh {{$product['price']}}
                </span>
                <span class="text-xs line-through text-zinc-500 dark:text-zinc-400">
                    Ksh {{ number_format((float) $product['original_price'], 2) }}
                </span>
            @else
                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                    Ksh {{ number_format(floatval($product['price']), 2) }}
                </span>
            @endif
        </div>

        @if (!empty($product['rating']))
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
