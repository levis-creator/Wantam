<?php
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new
    #[Layout('components.layouts.guest')]
    #[Title('Home')]
    class extends Component {
    public string $title = 'Home';
    public array $meta = [];

    public function mount()
    {
        $this->meta = [
            'description' => 'Shop the best products at ' . config('app.name') . '. Discover our wide range of categories and deals.',
            'keywords' => 'e-commerce, shopping, home, ' . config('app.name'),
        ];
    }
}; ?>

<main class="main">
    <livewire:components.home.intro-slider />
    <livewire:components.home.banner-group />
    <livewire:components.home.icon-box-container />
    <livewire:components.home.new-arrivals />
    <livewire:components.home.category-section />
    <div class="mb-4"></div><!-- End .mb-4 -->
    {{-- <livewire:components.home.top-selling /> --}}
    <div class="mb-5"></div><!-- End .mb-5 -->
    <livewire:components.home.ad-banner />
    <livewire:components.home.blog-section />
</main><!-- End .main -->
