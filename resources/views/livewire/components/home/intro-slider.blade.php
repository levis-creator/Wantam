<?php

use Livewire\Volt\Component;
use App\Models\Advertisement;

new class extends Component {
    public $slides;

    public function mount()
    {
        $this->slides = Advertisement::current()->get();
    }
};
?>

<div class="container">
    <div class="intro-slider-container slider-container-ratio mb-2">
        <div class="intro-slider owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl"
            data-owl-options='{"nav": false}'>
            @foreach ($slides as $slide)
                <livewire:components.ui.slide :record="$slide" />
            @endforeach
        </div><!-- End .intro-slider -->
        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->
</div><!-- End .container -->
