<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public string $activeTab = 'all';
    public $products;

    public function mount()
    {
        $this->loadProducts();
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->loadProducts();
    }

    private function loadProducts(): void
    {
        $query = Product::query()
            ->active()
            ->with(['category', 'brand', 'reviews', 'variants'])
            ->isFeatured()
            ->latest();

        if ($this->activeTab === 'women') {
            $query->whereHas('category', fn($q) => $q->where('name', 'like', 'Women%'));
        } elseif ($this->activeTab === 'men') {
            $query->whereHas('category', fn($q) => $q->where('name', 'like', 'Men%'));
        }

        $this->products = $query->limit(12)->get();
    }
};
?>

<div class="bg-light pt-5 pb-10 mb-3">
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title-lg">New Arrivals</h2>
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 'all' ? 'active' : '' }}"
                        @click.prevent="$wire.switchTab('all')" role="tab">All</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 'women' ? 'active' : '' }}"
                        @click.prevent="$wire.switchTab('women')" role="tab">Women's</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === 'men' ? 'active' : '' }}"
                        @click.prevent="$wire.switchTab('men')" role="tab">Men's</button>
                </li>
            </ul>
        </div>

        <div class="tab-content tab-content-carousel">
            <div class="tab-pane tab-pane-shadow p-0 fade show active" id="new-tab" role="tabpanel">
                @if ($products->isEmpty())
                    <div class="text-center py-5">
                        <p class="text-muted">No products found in this category.</p>
                    </div>
                @else
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
                @endif
            </div>
        </div>
    </div>
</div>