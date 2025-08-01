<?php
use Livewire\Volt\Component;

new class extends Component {
    public $menuItems = [];
    public $cartItems = [];

    public function mount()
    {
        $this->menuItems = [
            [
                'label' => 'Home',
                'href' => route('home'),
                'active' => request()->routeIs('home'),
                'megamenu' => null,
            ],
            [
                'label' => 'Shop',
                'href' => route('shop.index'),
                'active' => request()->routeIs('shop.*'),
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Shop Categories',
                            'items' => [
                                ['href' => route('shop.category', 'electronics'), 'label' => 'Electronics'],
                                ['href' => route('shop.category', 'clothing'), 'label' => 'Clothing'],
                                ['href' => route('shop.category', 'home-decor'), 'label' => 'Home Decor'],
                                ['href' => route('shop.category', 'accessories'), 'label' => 'Accessories'],
                                ['href' => route('shop.category', 'sports'), 'label' => 'Sports'],
                            ]
                        ],
                        [
                            'title' => 'Shop Pages',
                            'items' => [
                                ['href' => route('cart'), 'label' => 'Cart'],
                                ['href' => route('checkout'), 'label' => 'Checkout'],
                                ['href' => route('wishlist'), 'label' => 'Wishlist'],
                                ['href' => route('dashboard'), 'label' => 'My Account'],
                                ['href' => route('track-order'), 'label' => 'Track Order'],
                            ]
                        ],
                    ],
                    'banner' => ['href' => route('shop.index'), 'image' => 'assets/images/menu/banner-1.jpg', 'title' => 'Last Chance Sale'],
                ],
            ],
            [
                'label' => 'Product',
                'href' => route('product.show', 'sample-t-shirt'),
                'active' => request()->routeIs('product.show'),
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Product Details',
                            'items' => [
                                ['href' => route('product.show', 'sample-t-shirt'), 'label' => 'Product Page'],
                            ]
                        ],
                    ],
                    'banner' => ['href' => route('shop.index'), 'image' => 'assets/images/menu/banner-2.jpg', 'title' => 'New Trends Spring 2019'],
                ],
            ],
            [
                'label' => 'Blog',
                'href' => route('blog.index'),
                'active' => request()->routeIs('blog.*'),
                'megamenu' => null
            ],
        ];

        $this->cartItems = [
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
    }
}; ?>

<div class="header-middle sticky-header">
    <div class="container">
        <nav class="header-left" aria-label="Main navigation">
            <button class="mobile-menu-toggler" aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars" aria-hidden="true"></i>
            </button>
            <a href="{{ route('home') }}" class="logo" title="{{ config('app.name') }} E-commerce">
                <img src="{{ asset('assets/images/demos/demo-10/logo.png') }}"
                    alt="{{ config('app.name') }} E-commerce Logo" width="105" height="25">
            </a>
        </nav><!-- End .header-left -->
        <div class="header-right">
            <livewire:components.header.main-nav :items="$menuItems" />
            <livewire:components.header.search-bar />
            <livewire:components.header.cart-dropdown :items="$cartItems" />
        </div><!-- End .header-right -->
    </div><!-- End .container -->
</div><!-- End .header-middle -->
