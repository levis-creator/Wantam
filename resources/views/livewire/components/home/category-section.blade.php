<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {
    public $banners = [];

    public function mount()
    {
        $this->banners = Category::active()
            ->isFeatured()
            ->hasImage()
            ->take(3)
            ->get()
            ->map(function ($category) {
                return [
                    'image' => $category->image_url ?? 'assets/images/demos/demo-10/banners/placeholder.jpg',
                    'title' => $category->name,
                    'productsCount' => $category->product_count,
                    'slug' => $category->slug,
                ];
            })->toArray();
    }
};
?>

<div class="container">
    <div class="row justify-content-center">
        @foreach ($banners as $banner)
            <livewire:components.ui.category-banner :banner="$banner" />
        @endforeach
    </div>
</div>
