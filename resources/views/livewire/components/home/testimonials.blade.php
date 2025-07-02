<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $testimonials = [
        [
            'name' => 'Alice Wambui',
            'title' => 'Verified Buyer',
            'message' => 'I absolutely love the quality of the products. Fast delivery and amazing service!',
            'avatar' => 'https://i.pravatar.cc/100?img=1',
        ],
        [
            'name' => 'Brian Otieno',
            'title' => 'Loyal Customer',
            'message' => 'Customer support was super helpful. I highly recommend this store!',
            'avatar' => 'https://i.pravatar.cc/100?img=2',
        ],
        [
            'name' => 'Faith Mwikali',
            'title' => 'First-time Buyer',
            'message' => 'The products arrived just as described. Very happy with my purchase.',
            'avatar' => 'https://i.pravatar.cc/100?img=3',
        ],
    ];
};
?>

<section class="py-16 px-4 md:px-10 bg-zinc-50 dark:bg-zinc-900 my-10">
    <h2 class="text-2xl md:text-3xl font-bold text-center text-zinc-800 dark:text-white mb-10">What Our Customers Say</h2>

    <div class="grid gap-6 md:grid-cols-3">
        @foreach ($testimonials as $testimonial)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full">
                    <div>
                        <p class="font-semibold text-zinc-800 dark:text-white">{{ $testimonial['name'] }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $testimonial['title'] }}</p>
                    </div>
                </div>
                <p class="text-zinc-600 dark:text-zinc-300 text-sm">“{{ $testimonial['message'] }}”</p>
            </div>
        @endforeach
    </div>
</section>
