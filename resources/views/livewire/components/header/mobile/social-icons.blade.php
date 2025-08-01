<?php
use Livewire\Volt\Component;

new class extends Component {
    public $socialLinks = [];

    public function mount()
    {
        $this->socialLinks = config('social.links', []);
    }
}; ?>

<div class="social-icons">
    @foreach($socialLinks as $platform => $url)
        <a href="{{ $url }}" class="social-icon" target="_blank" title="{{ ucfirst($platform) }} link">
            <i class="icon-{{ strtolower($platform) }}-f" aria-hidden="true"></i>
        </a>
    @endforeach
</div><!-- End .social-icons -->
