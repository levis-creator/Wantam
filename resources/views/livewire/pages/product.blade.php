<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Services\ProductService;
use Illuminate\View\View;

new
    #[Layout('components.layouts.guest')]
    class extends Component {
    private string $slug = '';
    private $product = null;

    public function mount(string $product = '')
    {
        $this->slug = $product;
    }

    public function with(ProductService $productService)
    {
        $this->product = $productService->getProductBySlug($this->slug);
        $relatedProducts = $productService->getRelatedProducts($this->product['id']);

        return [
            'product' => $this->product,
            'relatedProducts' => $relatedProducts
        ];
    }

    /**
     * Dynamically inject SEO meta tags into <head>.
     */
    public function rendering(View $view)
    {
        // ✅ Page Title
        $view->title($this->product['meta_title'] ?? $this->product['name']);

        // ✅ Meta Description (fallback to product short description if missing)
        $description = $this->product['meta_description'] ?? $this->product['description'] ?? '';

        // ✅ Product Image (fallback to placeholder if none exists)
        $image = $this->product['main_image'] ?? asset('images/placeholder.png');

        // ✅ Inject meta + OpenGraph tags
        $view->with([
            'meta' => [
                'description' => $description,
                'og' => [
                    'title' => $this->product['meta_title'] ?? $this->product['name'],
                    'description' => $description,
                    'image' => $image,
                    'url' => url()->current(),
                    'type' => 'product',
                ],
                'twitter' => [
                    'card' => 'summary_large_image',
                    'title' => $this->product['meta_title'] ?? $this->product['name'],
                    'description' => $description,
                    'image' => $image,
                ],
            ]
        ]);
    }
};
?>

<main class="main">
    <x-volt-livewire::products.breadcumb :product="$product">

    </x-volt-livewire::products.breadcumb>
    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <x-volt-livewire::products.gallery :product="$product" />
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <x-volt-livewire::products.details :product="$product">
                            <div class="details-filter-row details-row-size">
                                <label>Color:</label>

                                <div class="product-nav product-nav-thumbs">
                                    <a href="#" class="active">
                                        <img src="assets/images/products/single/1-thumb.jpg" alt="product desc">
                                    </a>
                                    <a href="#">
                                        <img src="assets/images/products/single/2-thumb.jpg" alt="product desc">
                                    </a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .details-filter-row -->

                            <div class="details-filter-row details-row-size">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select name="size" id="size" class="form-control">
                                        <option value="#" selected="selected">Select a size</option>
                                        <option value="s">Small</option>
                                        <option value="m">Medium</option>
                                        <option value="l">Large</option>
                                        <option value="xl">Extra Large</option>
                                    </select>
                                </div><!-- End .select-custom -->

                                <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                            </div><!-- End .details-filter-row -->

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control" value="1" min="1" max="10"
                                        step="1" data-decimals="0" required>
                                </div><!-- End .product-details-quantity -->
                            </div><!-- End .details-filter-row -->

                            <div class="product-details-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>

                                <div class="details-action-wrapper">
                                    <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                            Wishlist</span></a>
                                </div><!-- End .details-action-wrapper -->
                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">Women</a>,
                                    <a href="#">Dresses</a>,
                                    <a href="#">Yellow</a>
                                </div><!-- End .product-cat -->

                                <x-volt-livewire::products.share :product="$product" />
                            </div><!-- End .product-details-footer -->
                        </x-volt-livewire::products.details>

                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->
            <x-volt-livewire::products.tabs :product="$product" />

            <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

            <x-volt-livewire::products.related :products="$relatedProducts" />
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->