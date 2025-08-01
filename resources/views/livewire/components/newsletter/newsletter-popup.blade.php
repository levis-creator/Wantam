<?php
use Livewire\Volt\Component;

new class extends Component {
    public array $content = [];

    public function mount()
    {
        $this->content = [
            'logo' => 'images/demos/demo-10/popup/newsletter/logo.png',
            'title' => 'get <span>25<light>%</light></span> off',
            'description' => 'Subscribe to the ' . config('app.name') . ' newsletter to receive timely updates from your favorite products.',
            'image' => 'images/demos/demo-10/popup/newsletter/img-1.jpg',
        ];
    }
}; ?>

<div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
    <div class="row tw-justify-center">
        <div class="col-10">
            <div class="row no-gutters tw-bg-white newsletter-popup-content">
                <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                    <div class="banner-content tw-text-center">
                        <img src="{{ asset($content['logo']) }}" class="logo" alt="{{ config('app.name') }} Logo"
                            width="60" height="15" loading="lazy">
                        <h2 class="banner-title" x-html="{{ $content['title'] }}"></h2>
                        <p>{{ $content['description'] }}</p>
                        <livewire:components.newsletter.newsletter-form />
                        <livewire:components.newsletter.newsletter-checkbox />
                    </div>
                </div>
                <div class="col-xl-2-5col col-lg-5">
                    <img src="{{ asset($content['image']) }}" class="newsletter-img" alt="Newsletter Image"
                        loading="lazy">
                </div>
            </div>
        </div>
    </div>
</div>
