<?php

use App\Models\Advertisement;
use Livewire\Volt\Component;

new class extends Component {
    public $slides;

    public function mount()
    {
        $this->slides = Advertisement::current()
            ->whereNotNull('image')
            ->orderBy('starts_at', 'desc')
            ->take(5)
            ->select('id', 'title', 'image', 'link', 'description')
            ->get()
            ->map(function ($slide) {
                // Use asset() instead of secure_asset() for local dev
                $slide->image = app()->environment('production')
                    ? secure_asset('storage/' . $slide->image)
                    : asset('storage/' . $slide->image);
                return $slide;
            });
    }
};
?>

<div x-data="{
    slides: @js($slides),
    activeSlide: 0,
    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
    init() {
        setInterval(() => this.next(), 6000);
    }
}" x-init="init" class="relative w-full h-full rounded-lg overflow-hidden">

    {{-- Slides --}}
    <template x-for="(slide, index) in slides" :key="slide.id">
        <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0 w-full h-full">

            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">

            <div
                class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/20 to-transparent flex items-center px-10">
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

    {{-- Navigation Controls --}}
    <button @click="prev"
        class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/40 text-white px-3 py-2 rounded-r hover:bg-black/70 z-10">
        ‹
    </button>
    <button @click="next"
        class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/40 text-white px-3 py-2 rounded-l hover:bg-black/70 z-10">
        ›
    </button>
</div>