<!DOCTYPE html>
<html x-data="{ darkMode: $persist(false) }" x-bind:class="{ 'dark': darkMode }"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.customer-head')
    @livewireStyles
</head>

<body class="bg-slate-50 dark:bg-zinc-800">
    <div class="page-wrapper">
        <livewire:components.header.header />
        <livewire:components.header.mobile.mobile-menu />

        {{ $slot }}
        <x-layouts.guest.footer />
    </div>

    @include('partials.customer-script')
</body>

</html>
