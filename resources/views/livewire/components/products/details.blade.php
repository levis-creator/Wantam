@props(['product'])
<div class="product-details">
    <h1 class="product-title">{{ $product['name'] }}</h1>

    <div class="ratings-container">
        <div class="ratings">
            <div class="ratings-val" style="width: {{ $product['rating'] * 20 }}%;"></div>
        </div>
        <a class="ratings-text" href="#product-review-link" id="review-link">
            ( {{ $product['reviews'] }} Reviews )
        </a>
    </div>

    <div class="product-price">
        Ksh {{ $product['formatted_price'] }}
    </div>

    <div class="product-content">
        {{ $product['description'] ?? 'No description available.' }}
    </div>

    {{ $slot }}
</div>