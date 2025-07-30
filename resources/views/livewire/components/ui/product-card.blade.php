<?php

use Livewire\Volt\Component;
use Illuminate\Support\Str;

new class extends Component {
    public object $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function addToWishlist()
    {
        // Logic to add product to wishlist
    }

    public function addToCart()
    {
        // Logic to add product to cart
    }

    public function quickView()
    {
        // Logic to trigger quick view modal
    }
}
?>
<div class="product product-3 text-center">
    <figure class="product-media">
        @if ($product->is_on_sale)
            <span class="product-label label-primary">Sale</span>
            @if ($product->discount_percentage)
                <span class="product-label label-sale">{{ $product->discount_percentage }}% off</span>
            @endif
        @elseif ($product->is_new)
            <span class="product-label label-primary">New</span>
        @elseif (!$product->in_stock)
            <span class="product-label label-primary">Out Of Stock</span>
        @endif

        <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
            <img src="{{ asset($product->image_path ?? 'images/default.png') }}" alt="{{ $product->name }} image"
                class="product-image">
            @if ($product->hover_image_path)
                <img src="{{ asset($product->hover_image_path) }}" alt="{{ $product->name }} hover image"
                    class="product-image-hover">
            @endif
        </a>

        @if ($product->is_on_sale && property_exists($product, 'countdown_until') && $product->countdown_until)
            <div class="product-countdown-container">
                <span class="product-contdown-title">offer ends in:</span>
                <div class="product-countdown countdown-compact"
                    data-until="{{ \Carbon\Carbon::parse($product->countdown_until)->format('Y, m, d') }}"
                    data-compact="true"></div>
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
        <div class="product-cat">
            @foreach (collect($product->category ?? []) as $category)
                <a href="{{ route('shop.category', Str::slug($category['name'])) }}">{{ $category['name'] }}</a>
                @if (!$loop->last), @endif
            @endforeach
        </div>

        <h3 class="product-title">
            <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a>
        </h3>

        <div class="product-price">
            @if ($product->is_on_sale)
                <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                <span class="old-price">${{ number_format($product->regular_price, 2) }}</span>
            @else
                <span class="{{ !$product->in_stock ? 'out-price' : '' }}">
                    ${{ number_format($product->regular_price, 2) }}
                </span>
            @endif
        </div>
    </div>

    <div class="product-footer">
        <div class="ratings-container">
            <div class="ratings">
                <div class="ratings-val"
                    style="width: {{ collect($product->reviews ?? [])->avg('rating') * 20 ?? 0 }}%;"></div>
            </div>
            <span class="ratings-text">({{ collect($product->reviews ?? [])->count() ?? 0 }} Reviews)</span>
        </div>

        @if (collect($product->variants ?? [])->isNotEmpty())
            <div class="product-nav product-nav-dots">
                @foreach (collect($product->variants ?? []) as $variant)
                    <a href="#" class="{{ $loop->first ? 'active' : '' }}"
                        style="background: {{ $variant['color'] ?? '#000' }};">
                        <span class="sr-only">Color name</span>
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