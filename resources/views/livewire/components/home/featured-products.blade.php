<?php

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;


new class extends Component {
    public $products;
    public function mount()
    {
        $this->products = Product::featured()->limit(8)->get();
    }
};
?>

<section class="py-12 px-4 md:px-10 bg-white dark:bg-zinc-900 mt-10">
    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">Featured Products</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
        <livewire:components.product-card :product="$product" />
        @endforeach
    </div>
</section>