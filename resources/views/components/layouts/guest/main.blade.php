<!DOCTYPE html>
<html x-data="{ darkMode: $persist(false) }" x-bind:class="{ 'dark': darkMode }"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.customer-head')
    @laravelPWA

</head>

<body>
    <div class="page-wrapper">
        <livewire:components.header.header />
        {{ $slot }}
        <x-layouts.guest.footer />
    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <div class="mobile-menu-overlay"></div><!-- End .mobile-menu-overlay -->
    <livewire:components.header.mobile.mobile-menu />
    {{-- <livewire:components.newsletter.newsletter-popup /> --}}
    @include('partials.customer-script')
</body>

</html>