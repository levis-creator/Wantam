<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $title = '';
    public string $description = '';
    public string $buttonText = '';
    public string $buttonUrl = '#';
    public string $background = ''; // URL to the background image
}
?>
<div class="container">
    <div class="cta cta-horizontal cta-horizontal-box bg-image mb-4 mb-lg-6"
        style="background-image: url('{{ asset($background) }}');">
        <div class="row flex-column flex-lg-row align-items-lg-center">
            <div class="col">
                <h3 class="cta-title text-primary">{{ $title }}</h3>
                <p class="cta-desc">{!! $description !!}</p>
            </div>
            <div class="col-auto">
                <a href="{{ $buttonUrl }}" class="btn btn-white-primary btn-round">
                    <span>{{ $buttonText }}</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>