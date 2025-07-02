<!DOCTYPE html>
<html x-data="{ darkMode: $persist(false) }" x-bind:class="{ 'dark': darkMode }" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-slate-50 dark:bg-zinc-800">
    <x-layouts.guest.header />
    <main class="px-4 md:px-28 py-10 min-h-screen">
        {{ $slot }}
    </main>
    <x-layouts.guest.footer />
    @fluxScripts
</body>
</html>
