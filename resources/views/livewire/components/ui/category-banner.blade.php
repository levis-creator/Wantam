<?php


use Livewire\Volt\Component;

new class extends Component {
    public string $image;
    public string $title;
    public string $subtitle;
    public string $link = '#';
}?>
<div class="col-sm-6 col-md-4">
    <div class="banner banner-cat">
        <a href="{{ $link ?? '#' }}">
            <img src="{{ asset($image) }}" alt="Banner">
        </a>

        <div class="banner-content banner-content-overlay text-center">
            <h3 class="banner-title font-weight-normal">{{ $title }}</h3>
            <h4 class="banner-subtitle">{{ $subtitle }}</h4>
            <a href="{{ $link ?? '#' }}" class="banner-link">SHOP NOW</a>
        </div>
    </div>
</div>