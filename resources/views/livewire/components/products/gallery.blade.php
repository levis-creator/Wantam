@props(['product'])
<div class="product-gallery product-gallery-vertical">
    <div class="row">
        <figure class="product-main-image">
            <img id="product-zoom" src="{{ $product['main_image'] ?? asset('images/default.png') }}"
                alt="{{ $product['name'] }}"
                data-zoom-image="{{ $product['main_image'] ?? asset('images/default.png') }}">

            <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                <i class="icon-arrows"></i>
            </a>
        </figure>

        <div id="product-zoom-gallery" class="product-image-gallery">
            @foreach ($product['images'] as $image)
                <a class="product-gallery-item" href="#" data-image="{{ $image }}" data-zoom-image="{{ $image}}">
                    <img src="{{ $image }}" alt="{{ $product['name'] }}">
                </a>
            @endforeach
        </div>
    </div>
</div>