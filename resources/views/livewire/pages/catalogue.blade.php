<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Services\ProductService;

new #[Layout('components.layouts.guest')]
    class extends Component {
    use WithPagination;

    public $query = '';
    protected $paginationTheme = 'bootstrap'; // optional if you use Bootstrap

    public function with(ProductService $productService): array
    {
        return [
            'products' => $productService->getPaginatedProducts(12), // 12 per page example
        ];
    }
};
?>

<div class="page-content">
    <div class="container">

        {{-- Toolbox --}}
        <livewire:components.products.toolbox />

        <div class="products">
            <div class="row">
                @foreach ($products as $product)
                    <livewire:components.products.product-card :product="$product" :key="$product['id']" />
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $products->links()}}
            </div>
        </div>

        {{-- Sidebar Filter --}}
        <div class="sidebar-filter-overlay"></div>
        <x-volt-livewire::products.filter />
    </div>
</div>