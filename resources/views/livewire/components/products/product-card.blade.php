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
    <div class="product" wire:key="{{ $product['id'] }}">
        <figure class="product-media">
            @if($product['discount'] > 0)
                <span class="product-label label-sale">{{ number_format($product['discount'], 0) }}% off</span>
            @elseif($product['is_featured'])
                <span class="product-label label-top">Top</span>
            @endif
            <a href="{{ route('product.show', $product['slug']) }}" aria-label="View {{ $product['name'] }}">
                <img src="{{ $product['main_image'] ?? asset('assets/images/products/placeholder.jpg') }}"
                    alt="{{ $product['name'] }} product image" class="product-image" loading="lazy">
            </a>

            <div class="product-action-vertical">
                <button wire:click="addToWishlist" class="btn-product-icon btn-wishlist btn-expandable"
                    aria-label="Add {{ $product['name'] }} to wishlist">
                    <span>add to wishlist</span>
                </button>
            </div>

            <div class="product-action action-icon-top">
                <button wire:click="addToCart" class="btn-product btn-cart"
                    aria-label="Add {{ $product['name'] }} to cart" @if(!$product['is_active']) disabled @endif>
                    <span>add to cart</span>
                </button>
                <a href="#" class="btn-product btn-quickview" title="Quick view of {{ $product['name'] }}"
                    aria-label="Quick view of {{ $product['name'] }}">
                    <span>quick view</span>
                </a>
            </div>
        </figure>

        <div class="product-body">
            <div class="product-cat">
                <a
                    href="{{ route('shop.category', is_array($product['category']) ? $product['category']['slug'] : 'uncategorized') }}">
                    {{ is_array($product['category']) ? $product['category']['name'] : 'Uncategorized' }}
                </a>
            </div>
            <h3 class="product-title">
                <a href="{{ route('product.show', $product['slug']) }}">{{ $product['name'] }}</a>
            </h3>
            <div class="product-price">
                @if(!$product['is_active'])
                    <span class="out-price">${{ $product['formatted_price'] }}</span>
                @elseif($product['discount'] > 0)
                    <span class="new-price">${{ $product['formatted_price'] }}</span>
                    <span class="old-price">${{ $product['formatted_original_price'] }}</span>
                @else
                    ${{ $product['formatted_price'] }}
                @endif
            </div>
            <div class="ratings-container">
                <div class="ratings">
                    <div class="ratings-val" style="width: {{ ($product['rating'] ?? 0) * 20 }}%;"></div>
                </div>
                <span class="ratings-text">( {{ $product['reviews'] ?? 0 }} Reviews )</span>
            </div>

            @if(is_array($product['images']) && !empty($product['images']))
                <div class="product-nav product-nav-dots">
                    @foreach($product['images'] as $image)
                        <a href="#" style="background: #ffffff;" class="{{ ($image['active'] ?? false) ? 'active' : '' }}">
                            <span class="sr-only">{{ $image['name'] ?? 'Default' }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>