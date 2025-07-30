<?php
use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {
    public $menuItems = [];
    public $cartItems = [];

    public function mount()
    {
        $this->menuItems = [
            [
                'label' => 'Home',
                'href' => 'index',
                'active' => request()->routeIs('index'),
                'megamenu' => [
                    'title' => 'Choose your demo',
                    'items' => [
                        ['href' => 'index-1', 'title' => 'Furniture Store Demo 1', 'image' => 'assets/images/menu/demos/1.jpg'],
                        ['href' => 'index-2', 'title' => 'Furniture Store Demo 2', 'image' => 'assets/images/menu/demos/2.jpg'],
                        ['href' => 'index-3', 'title' => 'Electronic Store Demo', 'image' => 'assets/images/menu/demos/3.jpg'],
                        ['href' => 'index-4', 'title' => 'Electronic Store Demo 2', 'image' => 'assets/images/menu/demos/4.jpg'],
                        ['href' => 'index-5', 'title' => 'Fashion Store Demo 1', 'image' => 'assets/images/menu/demos/5.jpg'],
                        ['href' => 'index-6', 'title' => 'Fashion Store Demo 2', 'image' => 'assets/images/menu/demos/6.jpg'],
                        ['href' => 'index-7', 'title' => 'Fashion Store Demo 3', 'image' => 'assets/images/menu/demos/7.jpg'],
                        ['href' => 'index-8', 'title' => 'Fashion Store Demo 4', 'image' => 'assets/images/menu/demos/8.jpg'],
                        ['href' => 'index-9', 'title' => 'Fashion Store Demo 5', 'image' => 'assets/images/menu/demos/9.jpg'],
                        ['href' => 'index-10', 'title' => 'Shoes Store Demo', 'image' => 'assets/images/menu/demos/10.jpg'],
                    ],
                    'action' => ['label' => 'View All Demos', 'href' => 'demos', 'icon' => 'icon-long-arrow-right'],
                ],
            ],
            [
                'label' => 'Shop',
                'href' => 'category',
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Shop with Sidebar',
                            'items' => Category::where('parent_id', null)->take(5)->get()->map(fn($category) => [
                                'href' => 'category.' . $category->slug,
                                'label' => $category->name,
                            ])->toArray()
                        ],
                        [
                            'title' => 'Shop no Sidebar',
                            'items' => [
                                ['href' => 'category-boxed', 'label' => 'Shop Boxed No Sidebar', 'badge' => 'Hot'],
                                ['href' => 'category-fullwidth', 'label' => 'Shop Fullwidth No Sidebar'],
                            ]
                        ],
                        [
                            'title' => 'Product Category',
                            'items' => [
                                ['href' => 'product-category-boxed', 'label' => 'Product Category Boxed'],
                                ['href' => 'product-category-fullwidth', 'label' => 'Product Category Fullwidth', 'badge' => 'New'],
                            ]
                        ],
                        [
                            'title' => 'Shop Pages',
                            'items' => [
                                ['href' => 'cart', 'label' => 'Cart'],
                                ['href' => 'checkout', 'label' => 'Checkout'],
                                ['href' => 'wishlist', 'label' => 'Wishlist'],
                                ['href' => 'dashboard', 'label' => 'My Account'],
                                ['href' => 'lookbook', 'label' => 'Lookbook'],
                            ]
                        ],
                    ],
                    'banner' => ['href' => 'category', 'image' => 'assets/images/menu/banner-1.jpg', 'title' => 'Last Chance Sale'],
                ],
            ],
            [
                'label' => 'Product',
                'href' => 'product',
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Product Details',
                            'items' => [
                                ['href' => 'product', 'label' => 'Default'],
                                ['href' => 'product-centered', 'label' => 'Centered'],
                                ['href' => 'product-extended', 'label' => 'Extended Info', 'badge' => 'New'],
                                ['href' => 'product-gallery', 'label' => 'Gallery'],
                                ['href' => 'product-sticky', 'label' => 'Sticky Info'],
                                ['href' => 'product-sidebar', 'label' => 'Boxed With Sidebar'],
                                ['href' => 'product-fullwidth', 'label' => 'Full Width'],
                                ['href' => 'product-masonry', 'label' => 'Masonry Sticky Info'],
                            ]
                        ],
                    ],
                    'banner' => ['href' => 'category', 'image' => 'assets/images/menu/banner-2.jpg', 'title' => 'New Trends Spring 2019'],
                ],
            ],
            [
                'label' => 'Pages',
                'href' => 'about',
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'About',
                            'items' => [
                                ['href' => 'about', 'label' => 'About 01'],
                                ['href' => 'about-2', 'label' => 'About 02'],
                            ]
                        ],
                        [
                            'title' => 'Contact',
                            'items' => [
                                ['href' => 'contact', 'label' => 'Contact 01'],
                                ['href' => 'contact-2', 'label' => 'Contact 02'],
                            ]
                        ],
                        [
                            'title' => 'Other Pages',
                            'items' => [
                                ['href' => 'login', 'label' => 'Login'],
                                ['href' => 'faq', 'label' => 'FAQs'],
                                ['href' => '404', 'label' => 'Error 404'],
                                ['href' => 'coming-soon', 'label' => 'Coming Soon'],
                            ]
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Blog',
                'href' => 'blog',
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Blog',
                            'items' => [
                                ['href' => 'blog', 'label' => 'Classic'],
                                ['href' => 'blog-listing', 'label' => 'Listing'],
                            ]
                        ],
                        [
                            'title' => 'Grid',
                            'items' => [
                                ['href' => 'blog-grid-2cols', 'label' => 'Grid 2 Columns'],
                                ['href' => 'blog-grid-3cols', 'label' => 'Grid 3 Columns'],
                                ['href' => 'blog-grid-4cols', 'label' => 'Grid 4 Columns'],
                                ['href' => 'blog-grid-sidebar', 'label' => 'Grid Sidebar'],
                            ]
                        ],
                        [
                            'title' => 'Masonry',
                            'items' => [
                                ['href' => 'blog-masonry-2cols', 'label' => 'Masonry 2 Columns'],
                                ['href' => 'blog-masonry-3cols', 'label' => 'Masonry 3 Columns'],
                                ['href' => 'blog-masonry-4cols', 'label' => 'Masonry 4 Columns'],
                                ['href' => 'blog-masonry-sidebar', 'label' => 'Masonry Sidebar'],
                            ]
                        ],
                        [
                            'title' => 'Mask',
                            'items' => [
                                ['href' => 'blog-mask-grid', 'label' => 'Blog Mask Grid'],
                                ['href' => 'blog-mask-masonry', 'label' => 'Blog Mask Masonry'],
                            ]
                        ],
                        [
                            'title' => 'Single Post',
                            'items' => [
                                ['href' => 'single', 'label' => 'Default with Sidebar'],
                                ['href' => 'single-fullwidth', 'label' => 'Fullwidth No Sidebar'],
                                ['href' => 'single-fullwidth-sidebar', 'label' => 'Fullwidth with Sidebar'],
                            ]
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Elements',
                'href' => 'elements-list',
                'megamenu' => [
                    'sidebar' => [
                        [
                            'title' => 'Elements',
                            'items' => [
                                ['href' => 'elements-products', 'label' => 'Products'],
                                ['href' => 'elements-typography', 'label' => 'Typography'],
                                ['href' => 'elements-titles', 'label' => 'Titles'],
                                ['href' => 'elements-banners', 'label' => 'Banners'],
                                ['href' => 'elements-product-category', 'label' => 'Product Category'],
                                ['href' => 'elements-video-banners', 'label' => 'Video Banners'],
                                ['href' => 'elements-buttons', 'label' => 'Buttons'],
                                ['href' => 'elements-accordions', 'label' => 'Accordions'],
                                ['href' => 'elements-tabs', 'label' => 'Tabs'],
                                ['href' => 'elements-testimonials', 'label' => 'Testimonials'],
                                ['href' => 'elements-blog-posts', 'label' => 'Blog Posts'],
                                ['href' => 'elements-portfolio', 'label' => 'Portfolio'],
                                ['href' => 'elements-cta', 'label' => 'Call to Action'],
                                ['href' => 'elements-icon-boxes', 'label' => 'Icon Boxes'],
                            ]
                        ],
                    ],
                ],
            ],
        ];

        $this->cartItems = auth()->check() ? auth()->user()->cart->items->map(fn($item) => [
            'title' => $item->product->name,
            'href' => 'product.' . $item->product->slug,
            'qty' => $item->quantity,
            'price' => $item->product->price,
            'image' => $item->product->image,
        ])->toArray() : [];
    }
}
?>

<div class="header-middle sticky-header">
    <div class="container">
        <div class="header-left">
            <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars" aria-hidden="true"></i>
            </button>
            <a href="{{ route('index') }}" class="logo" title="Molla E-commerce">
                <img src="{{ asset('assets/images/demos/demo-10/logo.png') }}" alt="Molla E-commerce Logo" width="105"
                    height="25">
            </a>
        </div><!-- End .header-left -->
        <div class="header-right">
            <livewire:components.header.main-nav :items="$menuItems" />
            <livewire:components.header.search-bar />
            <livewire:components.header.cart-dropdown :items="$cartItems" />
        </div><!-- End .header-right -->
    </div><!-- End .container -->
</div><!-- End .header-middle -->