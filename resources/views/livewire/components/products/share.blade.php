@props(['product'])
@php
    // Prepare URL-encoded values for social sharing
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($product['meta_title'] ?? $product['name']);
    $shareDescription = urlencode($product['meta_description'] ?? $product['description']);
    $shareImage = urlencode($product['main_image'] ?? asset('images/placeholder.png'));
@endphp

<div class="social-icons social-icons-sm">
    <span class="social-label">Share:</span>

    {{-- External share links should open in a new tab (no wire:navigate needed) --}}

    {{-- Facebook --}}
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" class="social-icon" title="Share on Facebook"
        target="_blank" rel="noopener noreferrer">
        <i class="icon-facebook-f"></i>
    </a>

    {{-- Twitter --}}
    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" class="social-icon"
        title="Share on Twitter" target="_blank" rel="noopener noreferrer">
        <i class="icon-twitter"></i>
    </a>

    {{-- Pinterest --}}
    <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}&media={{ $shareImage }}&description={{ $shareDescription }}"
        class="social-icon" title="Share on Pinterest" target="_blank" rel="noopener noreferrer">
        <i class="icon-pinterest"></i>
    </a>

    {{-- WhatsApp --}}
    <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" class="social-icon"
        title="Share on WhatsApp" target="_blank" rel="noopener noreferrer">
        <i class="icon-whatsapp"></i>
    </a>
</div>