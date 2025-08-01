<?php
use Livewire\Volt\Component;

new class extends Component {
    public $menuItems = [];

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
                ],
            ],
            [
                'label' => 'Pages',
                'href' => route('about'),
                'active' => request()->routeIs('about', 'contact', 'faq', 'terms', 'privacy', 'how-to-shop', 'payment-methods', 'money-back', 'returns', 'shipping', 'help', 'track-order', '404'),
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'About',
                            'items' => [
                                ['href' => route('about'), 'label' => 'About'],
                            ]
                        ],
                        [
                            'title' => 'Contact',
                            'items' => [
                                ['href' => route('contact'), 'label' => 'Contact'],
                            ]
                        ],
                        [
                            'title' => 'Other Pages',
                            'items' => [
                                ['href' => route('login'), 'label' => 'Login'],
                                ['href' => route('faq'), 'label' => 'FAQs'],
                                ['href' => route('404'), 'label' => 'Error 404'],
                                ['href' => route('terms'), 'label' => 'Terms and Conditions'],
                                ['href' => route('privacy'), 'label' => 'Privacy Policy'],
                                ['href' => route('how-to-shop'), 'label' => 'How to Shop'],
                                ['href' => route('payment-methods'), 'label' => 'Payment Methods'],
                                ['href' => route('money-back'), 'label' => 'Money Back Guarantee'],
                                ['href' => route('returns'), 'label' => 'Returns'],
                                ['href' => route('shipping'), 'label' => 'Shipping'],
                                ['href' => route('help'), 'label' => 'Help'],
                                ['href' => route('track-order'), 'label' => 'Track Order'],
                            ]
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Blog',
                'href' => route('blog.index'),
                'active' => request()->routeIs('blog.*'),
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Blog',
                            'items' => [
                                ['href' => route('blog.index'), 'label' => 'Blog Home'],
                            ]
                        ],
                        [
                            'title' => 'Single Post',
                            'items' => [
                                ['href' => route('blog.show', 'summer-fashion-trends'), 'label' => 'Summer Fashion Trends'],
                                ['href' => route('blog.show', 'tech-gadgets-2025'), 'label' => 'Tech Gadgets 2025'],
                                ['href' => route('blog.show', 'home-decoration-tips'), 'label' => 'Home Decoration Tips'],
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
}; ?>

<div class="">
    <div class="mobile-menu-overlay"></div><!-- End .mobile-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>
            <livewire:components.header.mobile.mobile-search />
            <livewire:components.header.mobile.mobile-nav :items="$menuItems" />
            <livewire:components.header.mobile.social-icons />
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
</div>
