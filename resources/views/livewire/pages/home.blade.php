<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new
    #[Layout('components.layouts.guest')]
    class extends Component {
    //
}; ?>

<main class="main">
    <livewire:components.home.intro-slider />
    <livewire:components.home.banner-group />
    <livewire:components.home.icon-box-container />
    <livewire:components.home.new-arrivals />
    <livewire:components.home.category-section />
    <div class="mb-4"></div><!-- End .mb-4 -->
    <livewire:components.home.top-selling />
    <div class="mb-5"></div><!-- End .mb5 -->
    <livewire:components.home.ad-banner />
    <livewire:components.home.blog-section />
</main><!-- End .main -->