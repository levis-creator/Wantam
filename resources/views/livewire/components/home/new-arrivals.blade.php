<?php

use App\Models\Product;
use Livewire\Volt\Component;

new class extends Component {
    public $newArrivals;
    public function mount()
    {
        $this->newArrivals = Product::active()->take(4)->latest()->get();
    }
};
?>

<section class="py-12 px-4 md:px-10 bg-white dark:bg-zinc-900 my-10"">
    <h2 class=" text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">
    New Arrivals
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($newArrivals as $product)
        <livewire:components.product-card :product="$product" />
        @endforeach
    </div>
</section>
