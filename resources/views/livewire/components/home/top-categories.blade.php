<?php

use Livewire\Volt\Component;
use App\Models\Category;
use Illuminate\Support\Collection;

new class extends Component {
    public Collection $categories;
    public function mount()
    {
        $this->categories = Category::parents()->active()->limit(6)->get();
    }
};
?>

<section class="py-12 px-4 md:px-10 bg-white dark:bg-zinc-900 my-10">
    <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-8 text-center">
        Top Categories
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach ($categories as $category)
            <a href="{{ $category->slug }}"
                class="group rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 hover:shadow-lg transition-all duration-300 block">

                <div class="aspect-[4/3] w-full overflow-hidden">
                    <img src="{{ $category->image ?? asset('images/placeholder.jpg') }}" alt="{{ $category->name }}"
                        class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105" />
                </div>

                <div class="text-center py-3">
                    <h3 class="text-sm font-medium text-zinc-700 dark:text-white group-hover:underline">
                        {{ $category->name }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>
</section>
