<x-layouts.guest.main :title="__('Home')">
    {{-- 1. Hero Section (Top Banner + Categories Sidebar) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 max-h-[500px]">
        <livewire:components.home.category-sidebar />
        <div class="md:col-span-3 bg-white dark:bg-zinc-800 p-0 rounded shadow-sm flex h-full">
            <livewire:components.home.hero-carousel />
        </div>
    </div>

    {{-- 2. Flash Sale or Promo Banner --}}
    {{-- <livewire:components.home.flash-sale-banner /> --}}

    {{-- 3. Featured Products --}}
    <livewire:components.home.featured-products />

    {{-- 4. New Arrivals (fresh inventory) --}}
    <livewire:components.home.new-arrivals />

    {{-- 5. Best Sellers (popular with users) --}}
    <livewire:components.home.best-sellers />

    {{-- 6. Top Categories (browse by interests) --}}
    <livewire:components.home.top-categories />

    {{-- 7. Testimonials (builds trust) --}}
    <livewire:components.home.testimonials />

    {{-- 8. Brands Carousel (shows known partners/brands) --}}
    <livewire:components.home.brands-carousel />

    {{-- 9. Blog Snippets or Shopping Tips (optional) --}}
    <livewire:components.home.blog-snippets />

    {{-- 10. Newsletter Signup --}}
    <livewire:components.home.newsletter />
</x-layouts.guest.main>
