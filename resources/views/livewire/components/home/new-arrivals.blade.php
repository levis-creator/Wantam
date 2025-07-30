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
                'name' => 'The North Face Back-To-Berkeley Remtlz Mesh',
                'slug' => 'the-north-face-back-to-berkeley-remtlz-mesh',
                'image_path' => 'assets/images/demos/demo-10/products/product-1.jpg',
                'hover_image_path' => null,
                'regular_price' => 84.00,
                'sale_price' => 50.00,
                'discount_percentage' => 30,
                'is_new' => false,
                'is_on_sale' => true,
                'in_stock' => true,
                'category' => collect([['name' => 'Men’s'], ['name' => 'Boots']]),
                'reviews' => collect([['rating' => 3], ['rating' => 3], ['rating' => 3], ['rating' => 3]]),
                'variants' => collect([['color' => '#5f554b'], ['color' => '#806f55']])
            ],
            [
                'id' => 2,
                'name' => 'Nike Air Zoom Wildhorse 4',
                'slug' => 'nike-air-zoom-wildhorse-4',
                'image_path' => 'assets/images/demos/demo-10/products/product-2.jpg',
                'hover_image_path' => null,
                'regular_price' => 77.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => true,
                'category' => collect([['name' => 'Men’s'], ['name' => 'Sneakers']]),
                'reviews' => collect([]),
                'variants' => collect([])
            ],
            [
                'id' => 3,
                'name' => 'Eric Michael Joan',
                'slug' => 'eric-michael-joan',
                'image_path' => 'assets/images/demos/demo-10/products/product-3.jpg',
                'hover_image_path' => 'assets/images/demos/demo-10/products/product-3-2.jpg',
                'regular_price' => 35.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => true,
                'is_on_sale' => false,
                'in_stock' => true,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Sandals']]),
                'reviews' => collect([['rating' => 2], ['rating' => 2]]),
                'variants' => collect([['color' => '#666666'], ['color' => '#b58853']])
            ],
            [
                'id' => 4,
                'name' => 'Nike Air Max Motion LW Racer',
                'slug' => 'nike-air-max-motion-lw-racer',
                'image_path' => 'assets/images/demos/demo-10/products/product-4.jpg',
                'hover_image_path' => null,
                'regular_price' => 54.99,
                'sale_price' => null,
                'discount_percentage' => 0,
                'is_new' => false,
                'is_on_sale' => false,
                'in_stock' => false,
                'category' => collect([['name' => 'Women’s'], ['name' => 'Sneakers']]),
                'reviews' => collect([['rating' => 4], ['rating' => 4], ['rating' => 4]]),
                'variants' => collect([])
            ],
            [
                'id' => 5,
                'name' => 'ASICS Tiger Gel-Lyte MT',
                'slug' => 'asics-tiger-gel-lyte-mt',
                'image_path' => 'assets/images/demos/demo-10/products/product-5.jpg',
                'hover_image_path' => null,
                'regular_price' => 130.00,
                'sale_price' => 77.99,
                'discount_percentage' => 40,
                'is_new' => false,
                'is_on_sale' => true,
                'in_stock' => true,
                'category' => collect([['name' => 'Men’s'], ['name' => 'Sneakers']]),
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
<div class="bg-light pt-5 pb-10 mb-3">
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title-lg">New Arrivals</h2>
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'all' ? 'active' : '' }}" wire:click="switchTab('all')"
                        id="new-all-link" role="tab" aria-controls="new-tab"
                        aria-selected="{{ $activeTab === 'all' ? 'true' : 'false' }}">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'women' ? 'active' : '' }}" wire:click="switchTab('women')"
                        id="new-women-link" role="tab" aria-controls="new-tab"
                        aria-selected="{{ $activeTab === 'women' ? 'true' : 'false' }}">Women's</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'men' ? 'active' : '' }}" wire:click="switchTab('men')"
                        id="new-men-link" role="tab" aria-controls="new-tab"
                        aria-selected="{{ $activeTab === 'men' ? 'true' : 'false' }}">Men's</a>
                </li>
            </ul>
        </div>

        <div class="tab-content tab-content-carousel">
            <div class="tab-pane tab-pane-shadow p-0 fade show active" id="new-tab" role="tabpanel"
                aria-labelledby="new-{{ $activeTab }}-link">
                <div class="owl-carousel owl-simple carousel-equal-height" data-toggle="owl" data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "margin": 0,
                    "loop": false,
                    "responsive": {
                        "0": {"items": 2},
                        "480": {"items": 2},
                        "768": {"items": 3},
                        "992": {"items": 4},
                        "1200": {"items": 4, "nav": true}
                    }
                }'>
                    @foreach ($products as $product)
                        <livewire:components.ui.product-card :product="$product" :key="$product->id" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>