<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $image;
    public string $subtitle;
    public string $title;
    public string $text = '';
    public string $btnText = 'Discover Now';
    public string $btnClass = 'btn-outline-white';
    public string $titleClass = 'text-white';
    public string $subtitleClass = '';
    public string $textClass = '';
    public string $overlayClass = 'banner-overlay';
    public string $contentPosition = '';

};
?>

<div class="banner {{ $overlayClass }}">
    <a href="#">
        <img src="{{ asset($image) }}" alt="Banner">
    </a>
    <div class="banner-content {{ $contentPosition }}">
        <h4 class="banner-subtitle {{ $subtitleClass }}">
            <a href="#">{{ $subtitle }}</a>
        </h4>
        <h3 class="banner-title {{ $titleClass }}">
            <a href="#">{!! nl2br(e($title)) !!}</a>
        </h3>
        @if($text)
            <div class="banner-text {{ $textClass }}">
                <a href="#">{{ $text }}</a>
            </div>
        @endif
        <a href="#" class="btn {{ $btnClass }} banner-link btn-round">{{ $btnText }}</a>
    </div>
</div>