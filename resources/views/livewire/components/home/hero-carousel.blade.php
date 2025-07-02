<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $slides = [
        [
            'id' => 1,
            'image' => 'https://picsum.photos/id/1015/1200/500',
            'title' => 'Wireless Headphones',
            'description' => 'Experience premium sound quality with our latest noise-cancelling headphones.',
            'link' => '#',
        ],
        [
            'id' => 2,
            'image' => 'https://picsum.photos/id/1025/1200/500',
            'title' => 'Stylish Men’s Watch',
            'description' => 'Upgrade your style with our classic and modern watch collections.',
            'link' => '#',
        ],
        [
            'id' => 3,
            'image' => 'https://fastly.picsum.photos/id/1044/1200/500.jpg?hmac=4kX2Fpz780LzsF1oNougfExnsGCqmFLvcomllkEm-ww',
            'title' => 'Kitchen Essentials',
            'description' => 'Blend, cook and create with our best-in-class kitchen appliances.',
            'link' => '#',
        ],
    ];
};
?>


<div 
    x-data="{
        slides: @js($slides),
        activeSlide: 0,
        next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
        prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
        init() {
            setInterval(() => this.next(), 6000);
        }
    }"
    x-init="init"
    class="relative w-full h-[500px] rounded-lg overflow-hidden"
>
    {{-- Slides --}}
    <template x-for="(slide, index) in slides" :key="slide.id">
        <div
            x-show="activeSlide === index"
            x-transition
            class="absolute inset-0 w-full h-full"
        >
            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/20 to-transparent flex items-center px-10">
                <div class="text-white max-w-md space-y-4">
                    <h2 class="text-3xl font-bold" x-text="slide.title"></h2>
                    <p class="text-sm md:text-base opacity-90" x-text="slide.description"></p>
                    <a :href="slide.link"
                       class="inline-block bg-white text-black px-5 py-2 rounded hover:bg-zinc-100 text-sm font-semibold transition">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </template>

    {{-- Controls --}}
    <button @click="prev"
        class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/40 text-white px-3 py-2 rounded-r hover:bg-black/70 z-10">
        ‹
    </button>
    <button @click="next"
        class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/40 text-white px-3 py-2 rounded-l hover:bg-black/70 z-10">
        ›
    </button>
</div>
