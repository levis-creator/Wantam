<?php

use Livewire\Volt\Component;

new class extends Component {
    public $record;

    public function mount($record)
    {
        $this->record = $record ?? new \App\Models\Advertisement();
    }
} ?>

<div class="intro-slide">
    <figure class="slide-image">
        <picture>
            <source media="(max-width: 480px)"
                srcset="{{ $record->image_mobile ? asset($record->image_mobile) : asset($record->image_default) }}"
                alt="{{ $record->mobile_alt ?? $record->default_alt ?? 'Mobile advertisement image' }}">
            <img src="{{ $record->image_default ? asset($record->image_default) : asset($record->image_mobile) }}"
                alt="{{ $record->default_alt ?? 'Advertisement image' }}" loading="lazy">
        </picture>
    </figure><!-- End .slide-image -->

    <div class="intro-content">
        <h3 class="intro-subtitle text-white">{!! $record->subtitle ?? 'No subtitle provided' !!}</h3>
        <h1 class="intro-title text-white">{{ $record->title ?? 'Untitled Advertisement' }}</h1>
        <div class="intro-price text-white">{{ $record->price ?? 'No price provided' }}</div>

        @if($record->link)
            <a href="{{ $record->link }}" class="btn btn-white-primary btn-round" target="_blank" rel="noopener noreferrer">
                <span>SHOP NOW</span>
                <i class="icon-long-arrow-right"></i>
            </a>
        @else
            <span class="text-gray-400 italic">No link available</span>
        @endif
    </div><!-- End .intro-content -->
</div><!-- End .intro-slide -->
