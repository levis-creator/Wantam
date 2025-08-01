<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $widget;
}
?>
<div class="widget {{ $widget['type'] === 'about' ? 'widget-about' : '' }}">
    @if ($widget['type'] === 'about')
        <img src="{{ asset($widget['content']['logo']) }}" class="footer-logo" alt="Footer Logo" width="105" height="25">
        <p>{{ $widget['content']['description'] }}</p>
        <div class="social-icons">
            @foreach ($widget['content']['social_links'] as $link)
                <a href="{{ $link['url'] }}" class="social-icon" title="{{ $link['title'] }}" target="_blank"
                    aria-label="Visit our {{ $link['title'] }} page">
                    <i class="{{ $link['icon'] }}"></i>
                </a>
            @endforeach
        </div>
    @else
        <h4 class="widget-title">{{ $widget['title'] }}</h4>
        <ul class="widget-list">
            @foreach ($widget['content'] as $link)
                <li>
                    <a href="{{ $link['url'] }}" title="{{ $link['name'] }}">{{ $link['name'] }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
