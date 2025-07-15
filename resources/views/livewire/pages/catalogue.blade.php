<?php

use App\Service\CatalogueService;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

new #[Layout('components.layouts.guest')] class extends Component {
    use WithPagination;

    public $slug;
    public $categories = [];

    // Filters bound to query string
    public $min_price = '';
    public $max_price = '';
    public $availability = '';
    public $ratings = '';

    protected $queryString = [
        'min_price' => ['except' => ''],
        'max_price' => ['except' => ''],
        'availability' => ['except' => ''],
        'ratings' => ['except' => ''],
    ];

    public function mount(CatalogueService $catalogue)
    {
        $this->slug = request('slug');
        $this->categories = $catalogue->fetchCategories($this->slug)->take(7);
    }

    public function updated($property)
    {
        $this->resetPage();
    }

    #[On('filters-applied')]
    public function filterData(array $param)
    {
        $this->resetPage();

        $this->min_price = $param['minPrice'] ?? '';
        $this->max_price = $param['maxPrice'] ?? '';
        $this->availability = $param['availability'] ?? '';
        $this->ratings = $param['ratings'] ?? [];
    }

    public function getProductsProperty()
    {
        $filters = [
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'availability' => $this->availability,
            'ratings' => $this->ratings,
        ];

        return $this->slug
            ? app(CatalogueService::class)->filterProductsPaginated(array_merge(['category_id' => [$this->slug]], $filters))
            : app(CatalogueService::class)->filterProductsPaginated($filters);
    }
};
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Sidebar Filter --}}
        <div class="col-span-1">
            <livewire:components.catalogue.filter-card :categories="$categories" wire:listen="filters-applied" />
        </div>

        {{-- Product Section --}}
        <div class="col-span-1 md:col-span-3 space-y-4">
            <div class="border-b pb-3 mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Products</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($this->products as $product)
                    <livewire:components.product-card :product="$product" />
                @empty
                    <p class="text-gray-500 dark:text-gray-300">No products found.</p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pt-4">
                {{ $this->products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
