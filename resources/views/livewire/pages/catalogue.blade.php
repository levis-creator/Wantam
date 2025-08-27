<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Services\ProductService;

new #[Layout('components.layouts.guest')]
    class extends Component {
    use WithPagination;

    public string $query = '';
    public string $category = '';
    public int $itemsPerPage = 12;

    protected $paginationTheme = 'bootstrap'; // or 'bootstrap' if views are published

    // Reset pagination when search changes
    public function updatedQuery()
    {
        $this->resetPage();
    }

    public function mount(string $slug = '')
    {
        $this->category = $slug;
    }

    public function with(ProductService $productService): array
    {
        $products = !empty($this->category)
            ? $productService->getProductsByCategory($this->category, $this->itemsPerPage, $this->query)
            : $productService->getPaginatedProducts($this->itemsPerPage, $this->query);

        return [
            'products' => $products,
            'itemsPerPage' => $this->itemsPerPage,
            'totalItems' => $products->total(),
        ];
    }
};
?>



<div class="page-content">
    <div class="container">

        {{-- Toolbox --}}
        <livewire:components.products.toolbox :itemsPerPage="$itemsPerPage" :totalItems="$totalItems" />

        <div class="products">
            <div class="row">
                @foreach ($products as $product)

                    <livewire:components.products.product-card :product="$product" :key="$product['id']" />

                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>

        {{-- Sidebar Filter --}}
        <div class="sidebar-filter-overlay"></div>
        <x-volt-livewire::products.filter />
    </div>
</div>
