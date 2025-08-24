@props(['product'])

<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ is_array($product) ? $product['name'] : $product->name }}
            </li>
        </ol>
        {{ $slot }}
    </div>
</nav>