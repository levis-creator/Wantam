@php
    $banners = [
        [
            'image' => 'assets/images/demos/demo-10/banners/banner-5.jpg',
            'title' => "Women's",
            'subtitle' => '125 Products',
            'link' => route('shop.category', ['slug' => 'women']),
        ],
        [
            'image' => 'assets/images/demos/demo-10/banners/banner-6.jpg',
            'title' => "Men's",
            'subtitle' => '97 Products',
            'link' => route('shop.category', ['slug' => 'men']),
        ],
        [
            'image' => 'assets/images/demos/demo-10/banners/banner-7.jpg',
            'title' => "Kid's",
            'subtitle' => '48 Products',
            'link' => route('shop.category', ['slug' => 'kids']),
        ],
    ];
@endphp

<div class="container">
    <div class="row justify-content-center">
        @foreach ($banners as $banner)
            <livewire:components.ui.category-banner :image="$banner['image']" :title="$banner['title']"
                :subtitle="$banner['subtitle']" :link="$banner['link']" />
        @endforeach
    </div>
</div>