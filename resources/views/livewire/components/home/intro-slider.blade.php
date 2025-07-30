<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $slides = [
        [
            'image' => [
                'default' => 'assets/images/demos/demo-10/slider/slide-1.jpg',
                'mobile' => 'assets/images/demos/demo-10/slider/slide-1-480w.jpg',
            ],
            'subtitle' => 'Deals and Promotions',
            'title' => 'Sneakers & Athletic Shoes',
            'price' => 'from $9.99',
            'link' => 'category.html',
        ],
        [
            'image' => [
                'default' => 'assets/images/demos/demo-10/slider/slide-2.jpg',
                'mobile' => 'assets/images/demos/demo-10/slider/slide-2-480w.jpg',
            ],
            'subtitle' => 'Trending Now',
            'title' => "This Week's Most Wanted",
            'price' => 'from $49.99',
            'link' => 'category.html',
        ],
        [
            'image' => [
                'default' => 'assets/images/demos/demo-10/slider/slide-3.jpg',
                'mobile' => 'assets/images/demos/demo-10/slider/slide-3-480w.jpg',
            ],
            'subtitle' => 'Deals and Promotions',
            'title' => "Can’t-miss Clearance:",
            'price' => 'starting at 60% off',
            'link' => 'category.html',
        ],
    ];
};
?>

<div class="container">
    <div class="intro-slider-container slider-container-ratio mb-2">
        <div class="intro-slider owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl"
            data-owl-options='{"nav": false}'>
            @foreach ($slides as $slide)
                <div class="intro-slide">
                    <figure class="slide-image">
                        <picture>
                            <source media="(max-width: 480px)" srcset="{{ asset($slide['image']['mobile']) }}">
                            <img src="{{ asset($slide['image']['default']) }}" alt="Slide Image">
                        </picture>
                    </figure><!-- End .slide-image -->

                    <div class="intro-content">
                        <h3 class="intro-subtitle text-white">{{ $slide['subtitle'] }}</h3>
                        <h1 class="intro-title text-white">{{ $slide['title'] }}</h1>
                        <div class="intro-price text-white">{{ $slide['price'] }}</div>

                        <a href="{{ $slide['link'] }}" class="btn btn-white-primary btn-round">
                            <span>SHOP NOW</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                    </div><!-- End .intro-content -->
                </div><!-- End .intro-slide -->
            @endforeach
        </div><!-- End .intro-slider -->
        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->
</div><!-- End .container -->