<?php

use Livewire\Volt\Component;
use Illuminate\Support\Collection;

new class extends Component {
    public $activeTab = 'all';
    public $products = [];

    public function mount()
    {
        $this->loadProducts();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadProducts();
    }

    private function loadProducts()
    {
        $dummyProducts = [
            [
                'id' => 1,
                'name' => 'ASICS Tiger Gel-Lyte MT',
                'slug' => 'asics-tiger-gel-lyte-mt',
                'image_path' => 'assets/images/demos/demo-10/products/product-5.jpg',
                'hover_image_path' => null,
                'regular_price' => 130.00,
                'sale_price' => 77.99,
                'discount_percentage' => 30,
                'is_new' => false,
                'is_on_sale' => true,
                'in_stock' => true,
                'countdown_until' => '2025-08-31', // Updated for testing
                'category' => collect([['name' => 'Men’s'], ['name' => 'Sneakers']]),
                'reviews' => collect([['rating' => 3], ['rating' => 3], ['rating' => 3], ['rating' => 3]]),
                'variants' => collect([['color' => '#af5f23'], ['color' => '#806f55'], ['color' => '#333333']])
            ],
            [
                'id' => 2,
                'name' => 'Eric Michael Sandra',
                'slug' => 'eric-michael-sandra',
                'image_path' => 'assets/images/demos/demo-10/products/product-6.jpg',
                'hover_image_path' => null,
                'regular_price' => 42.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => true,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Sandals']]),
                'reviews' => collect([['rating' => 3], ['rating' => 3]]),
                'variants' => collect([])
            ],
            [
                'id' => 3,
                'name' => 'Jessica Simpson Blayke',
                'slug' => 'jessica-simpson-blayke',
                'image_path' => 'assets/images/demos/demo-10/products/product-7.jpg',
                'hover_image_path' => null,
                'regular_price' => 20.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Heels']]),
                'reviews' => collect([['rating' => 2], ['rating' => 2]]),
                'variants' => collect([['color' => '#cc6666'], ['color' => '#ccccff']])
            ],
            [
                'id' => 4,
                'name' => 'Native Shoes Miles Denim Print',
                'slug' => 'native-shoes-miles-denim-print-men',
                'image_path' => 'assets/images/demos/demo-10/products/product-8.jpg',
                'hover_image_path' => null,
                'regular_price' => 20.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Men’s'], ['name' => 'Sneakers']]),
                'reviews' => collect([]),
                'variants' => collect([['color' => '#ffca51'], ['color' => '#bb8379'], ['color' => '#666666']])
            ],
            [
                'id' => 5,
                'name' => 'The North Face Raedonda Boot Sneaker',
                'slug' => 'the-north-face-raedonda-boot-sneaker',
                'image_path' => 'assets/images/demos/demo-10/products/product-9.jpg',
                'hover_image_path' => null,
                'regular_price' => 97.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Boots']]),
                'reviews' => collect([['rating' => 5], ['rating' => 5], ['rating' => 5], ['rating' => 5]]),
                'variants' => collect([])
            ],
            [
                'id' => 6,
                'name' => 'Native Shoes Miles Denim Print',
                'slug' => 'native-shoes-miles-denim-print-women',
                'image_path' => 'assets/images/demos/demo-10/products/product-10.jpg',
                'hover_image_path' => null,
                'regular_price' => 57.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Sneakers']]),
                'reviews' => collect([['rating' => 5], ['rating' => 5], ['rating' => 5], ['rating' => 5]]),
                'variants' => collect([])
            ],
            [
                'id' => 7,
                'name' => 'Splendid Roselyn II',
                'slug' => 'splendid-roselyn-ii',
                'image_path' => 'assets/images/demos/demo-10/products/product-11.jpg',
                'hover_image_path' => null,
                'regular_price' => 97.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Boots']]),
                'reviews' => collect([['rating' => 4], ['rating' => 4], ['rating' => 4]]),
                'variants' => collect([['color' => '#78645f'], ['color' => '#b89474'], ['color' => '#666666']])
            ],
            [
                'id' => 8,
                'name' => 'Marc Jacobs Somewhere Sport Sandal',
                'slug' => 'marc-jacobs-somewhere-sport-sandal',
                'image_path' => 'assets/images/demos/demo-10/products/product-12.jpg',
                'hover_image_path' => null,
                'regular_price' => 275.00,
                'sale_price' => 125.99,
                'discount_percentage' => 55,
                'is_new' => false,
                'is_on_sale' => true,
                'in_stock' => true,
                'countdown_until' => '2025-08-31',
                'category' => collect([['name' => 'Women’s'], ['name' => 'Heels']]),
                'reviews' => collect([]),
                'variants' => collect([])
            ],
            [
                'id' => 9,
                'name' => 'Crocs Crocband Clog',
                'slug' => 'crocs-crocband-clog',
                'image_path' => 'assets/images/demos/demo-10/products/product-13.jpg',
                'hover_image_path' => null,
                'regular_price' => 25.75,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => true,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Mules']]),
                'reviews' => collect([['rating' => 2], ['rating' => 2], ['rating' => 2], ['rating' => 2], ['rating' => 2], ['rating' => 2], ['rating' => 2]]),
                'variants' => collect([])
            ],
            [
                'id' => 10,
                'name' => 'Vasque Sundowner GTX',
                'slug' => 'vasque-sundowner-gtx',
                'image_path' => 'assets/images/demos/demo-10/products/product-14.jpg',
                'hover_image_path' => null,
                'regular_price' => 109.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'countdown_until' => null,
                'category' => collect([['name' => 'Men’s'], ['name' => 'Boots']]),
                'reviews' => collect([]),
                'variants' => collect([])
            ]
        ];

        $products = collect($dummyProducts);

        if ($this->activeTab === 'women') {
            $products = $products->filter(fn($product) => $product['category']->pluck('name')->contains('Women’s'));
        } elseif ($this->activeTab === 'men') {
            $products = $products->filter(fn($product) => $product['category']->pluck('name')->contains('Men’s'));
        }

        $this->products = $products->map(fn($product) => (object) $product);
    }
}
?>
<div class="container">
    <div class="heading heading-center mb-3">
        <h2 class="title-lg mb-2">Top Selling Products</h2>
        <ul class="nav nav-pills justify-content-center" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'all' ? 'active' : '' }}" wire:click="switchTab('all')"
                    id="top-all-link" role="tab" aria-controls="top-all-tab"
                    aria-selected="{{ $activeTab === 'all' ? 'true' : 'false' }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'women' ? 'active' : '' }}" wire:click="switchTab('women')"
                    id="top-women-link" role="tab" aria-controls="top-women-tab"
                    aria-selected="{{ $activeTab === 'women' ? 'true' : 'false' }}">Women's</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'men' ? 'active' : '' }}" wire:click="switchTab('men')"
                    id="top-men-link" role="tab" aria-controls="top-men-tab"
                    aria-selected="{{ $activeTab === 'men' ? 'true' : 'false' }}">Men's</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane p-0 fade {{ $activeTab === 'all' ? 'show active' : '' }}" id="top-all-tab" role="tabpanel"
            aria-labelledby="top-all-link">
            <div class="products just-action-icons-sm">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <livewire:components.ui.product-card :product="$product" :key="$product->id" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane p-0 fade {{ $activeTab === 'women' ? 'show active' : '' }}" id="top-women-tab"
            role="tabpanel" aria-labelledby="top-women-link">
            <div class="products just-action-icons-sm">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <livewire:components.ui.product-card :product="$product" :key="$product->id" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane p-0 fade {{ $activeTab === 'men' ? 'show active' : '' }}" id="top-men-tab" role="tabpanel"
            aria-labelledby="top-men-link">
            <div class="products just-action-icons-sm">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <livewire:components.ui.product-card :product="$product" :key="$product->id" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="more-container text-center mt-5">
        <a href="{{ route('shop.index') }}" class="btn btn-outline-lightgray btn-more btn-round"
            title="View more products in catalogue">
            <span>View more products</span>
            <i class="icon-long-arrow-right"></i>
        </a>
    </div>
</div>