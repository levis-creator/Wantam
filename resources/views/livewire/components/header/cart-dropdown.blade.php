<?php
use Livewire\Volt\Component;

new class extends Component {
    public $items = [];
    public $cartCount = 0;

    public function mount($items = null)
    {
        $this->items = $items ?? [
            [
                'title' => 'Sample T-Shirt',
                'href' => route('product.show', 'sample-t-shirt'),
                'qty' => 2,
                'price' => 19.99,
                'image' => 'assets/images/products/t-shirt.jpg',
            ],
            [
                'title' => 'Sample Sneakers',
                'href' => route('product.show', 'sample-sneakers'),
                'qty' => 1,
                'price' => 59.99,
                'image' => 'assets/images/products/sneakers.jpg',
            ],
            [
                'title' => 'Sample Backpack',
                'href' => route('product.show', 'sample-backpack'),
                'qty' => 1,
                'price' => 34.99,
                'image' => 'assets/images/products/backpack.jpg',
            ],
        ];
        $this->cartCount = array_sum(array_column($this->items, 'qty'));
    }

    public function increment($index)
    {
        $this->items[$index]['qty']++;
        $this->cartCount = array_sum(array_column($this->items, 'qty'));
    }

    public function decrement($index)
    {
        if ($this->items[$index]['qty'] > 1) {
            $this->items[$index]['qty']--;
            $this->cartCount = array_sum(array_column($this->items, 'qty'));
        }
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->cartCount = array_sum(array_column($this->items, 'qty'));
    }

    public function getTotalProperty()
    {
        return array_sum(array_map(fn($item) => $item['qty'] * $item['price'], $this->items));
    }
}; ?>

<div class="dropdown cart-dropdown" x-data="{ open: false }">
    <a href="#" class="dropdown-toggle" role="button" x-on:click="open = !open" aria-haspopup="true"
        aria-expanded="false" data-display="static" aria-label="View shopping cart"
        title="View your shopping cart ({{ $cartCount }} items)">
        <i class="icon-shopping-cart" aria-hidden="true"></i>
        <span class="cart-count">{{ $cartCount }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" x-show="open" x-on:click.outside="open = false">
        <div class="dropdown-cart-products">
            @forelse($items as $index => $item)
                <div class="product">
                    <div class="product-cart-details">
                        <h4 class="product-title">
                            <a href="{{ $item['href'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                        </h4>
                        <span class="cart-product-info">
                            <span class="cart-product-qty">{{ $item['qty'] }}</span>
                            x ${{ number_format($item['price'], 2) }}
                        </span>
                    </div><!-- End .product-cart-details -->
                    <figure class="product-image-container">
                        <a href="{{ $item['href'] }}" class="product-image">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}">
                        </a>
                    </figure>
                    <a href="#" class="btn-remove" wire:click="removeItem({{ $index }})"
                        title="Remove {{ $item['title'] }} from cart">
                        <i class="icon-close" aria-hidden="true"></i>
                    </a>
                </div><!-- End .product -->
            @empty
                <p>Your cart is empty.</p>
            @endforelse
        </div><!-- End .dropdown-cart-products -->
        <div class="dropdown-cart-total">
            <span>Total</span>
            <span class="cart-total-price">${{ number_format($this->total, 2) }}</span>
        </div><!-- End .dropdown-cart-total -->
        <div class="dropdown-cart-action">
            <a href="{{ route('cart') }}" class="btn btn-primary" title="View your shopping cart">View Cart</a>
            <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2" title="Proceed to checkout">
                <span>Checkout</span>
                <i class="icon-long-arrow-right" aria-hidden="true"></i>
            </a>
        </div><!-- End .dropdown-cart-action -->
    </div><!-- End .dropdown-menu -->
</div><!-- End .cart-dropdown -->
