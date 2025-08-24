<?php

namespace App\Livewire\Components\Products;

use Livewire\Volt\Component;

new class extends Component {
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function addToWishlist()
    {
        // Implement wishlist functionality
    }

    public function addToCart()
    {
        // Implement add to cart functionality
    }
} ?>
<div class="col-6 col-md-4 col-lg-4 col-xl-3">

    @if ($product)
        <div class="product product-3 text-center">
            <figure class="product-media">
                @if ($product->discount > 0)
                    <span class="product-label label-primary">Sale</span>
                    <span class="product-label label-sale">{{ $product->discount }}% off</span>
                @elseif (!$product->in_stock)
                    <span class="product-label label-primary">Out Of Stock</span>
                @endif

                <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
                    <img src="{{ $product->main_image_url ?? asset('images/default.png') }}" alt="{{ $product->name }}"
                        class="product-image">
                    @if (!empty($product->images_urls))
                        <img src="{{ $product->images_urls[0] }}" alt="{{ $product->name }} hover image"
                            class="product-image-hover">
                    @endif
                </a>

                @if (!empty($product->countdown_until))
                    <div class="product-countdown-container">
                        <span class="product-contdown-title">offer ends in:</span>
                        <div class="product-countdown countdown-compact"
                            data-until="{{ \Carbon\Carbon::parse($product->countdown_until)->format('Y, m, d') }}"
                            data-compact="true">
                        </div>
                    </div>
                @endif

                <div class="product-action-vertical">
                    <a href="#" wire:click.prevent="addToWishlist" class="btn-product-icon btn-wishlist btn-expandable"
                        aria-label="Add {{ $product->name }} to Wishlist">
                        <span>add to wishlist</span>
                    </a>
                </div>
            </figure>

            <div class="product-body">
                @if ($product->category?->name)
                    <div class="product-cat">
                        <a href="{{ route('shop.category', Str::slug($product->category->name)) }}">
                            {{ $product->category->name }}
                        </a>
                    </div>
                @endif

                <h3 class="product-title">
                    <a href="{{ route('product.show', $product->slug) }}">
                        {{ $product->name }}
                    </a>
                </h3>

                <div class="product-price">
                    @if ($product->discount > 0)
                        <span class="new-price">${{ number_format($product->price, 2) }}</span>
                        <span class="old-price">${{ number_format($product->original_price, 2) }}</span>
                    @else
                        <span class="{{ !$product->in_stock ? 'out-price' : '' }}">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="product-footer">
                <div class="ratings-container">
                    <div class="ratings">
                        <div class="ratings-val" style="width: {{ ($product->rating ?? 0) * 20 }}%;">
                        </div>
                    </div>
                    <span class="ratings-text">
                        ({{ $product->reviews->count() }} Reviews)
                    </span>
                </div>

                @if ($product->variants->isNotEmpty())
                    <div class="product-nav product-nav-dots">
                        @foreach ($product->variants as $variant)
                            <a href="#" class="{{ $loop->first ? 'active' : '' }}"
                                style="background: {{ $variant->color ?? '#000' }};">
                                <span class="sr-only">Color</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="product-action">
                    <a href="#" wire:click.prevent="addToCart" class="btn-product btn-cart"
                        aria-label="Add {{ $product->name }} to Cart">
                        <span>add to cart</span>
                    </a>

                    <a href="#" wire:click.prevent="quickView" class="btn-product btn-quickview"
                        aria-label="Quick view of {{ $product->name }}">
                        <span>quick view</span>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-3">
            <p class="text-muted">No product data available.</p>
        </div>
    @endif
</div>