<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $blogs = [
        [
            'title' => 'Top 10 Gadgets to Buy in 2025',
            'excerpt' => 'Explore the latest and greatest tech gadgets you should consider adding to your collection this year.',
            'image' => 'https://source.unsplash.com/random/800x600?tech',
            'author' => 'Levis Nyingi',
            'date' => 'June 25, 2025',
            'link' => '#',
        ],
        [
            'title' => 'How to Choose the Right Smartwatch',
            'excerpt' => 'Confused about which smartwatch to buy? Here’s a detailed guide to help you pick the best one.',
            'image' => 'https://source.unsplash.com/random/800x600?smartwatch',
            'author' => 'Codile Insights',
            'date' => 'June 20, 2025',
            'link' => '#',
        ],
        [
            'title' => '5 Tips to Improve Your Work-From-Home Setup',
            'excerpt' => 'Make your home office more productive with these helpful tech tips and gadgets.',
            'image' => 'https://source.unsplash.com/random/800x600?homeoffice',
            'author' => 'Tech Team',
            'date' => 'June 15, 2025',
            'link' => '#',
        ],
    ];
};
?>

<section class="py-12 bg-zinc-50 dark:bg-zinc-900">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-zinc-800 dark:text-white mb-10">
            Latest From Our Blog
        </h2>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($blogs as $blog)
                <a href="{{ $blog['link'] }}" class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden shadow hover:shadow-lg transition-all duration-300 group">
                    <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">

                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white group-hover:underline">
                            {{ $blog['title'] }}
                        </h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-300 mt-2">
                            {{ $blog['excerpt'] }}
                        </p>
                        <div class="mt-4 text-xs text-zinc-500 dark:text-zinc-400 flex justify-between items-center">
                            <span>By {{ $blog['author'] }}</span>
                            <span>{{ $blog['date'] }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
