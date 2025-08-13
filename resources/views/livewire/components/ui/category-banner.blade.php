<?php

namespace App\Livewire;

use Livewire\Volt\Component;

new class extends Component {
    public array $banner;

    public function mount(array $banner): void
    {
        $this->banner = $banner;
    }
} ?>

<div class="col-sm-6 col-md-4">
    <div class="banner banner-cat">
        <a href="{{ route('shop.category', ['slug' => $banner['slug'] ?? '']) ?? '#' }}"
            aria-label="Shop {{ $banner['title'] }}">
            <img src="{{ asset($banner['image']) }}" alt="{{ $banner['title'] }} Banner" loading="lazy">
        </a>
        <div class="banner-content banner-content-overlay text-center">
            <h3 class="banner-title font-weight-normal">{{ $banner['title'] }}</h3>
            <h4 class="banner-subtitle">{{ $banner['productsCount'] }} Products</h4>
            <a href="{{ route('shop.category', ['slug' => $banner['slug'] ?? '']) ?? '#' }}" class="banner-link">SHOP
                NOW</a>
        </div>
    </div>
</div>
