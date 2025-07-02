<button
x-on:click="darkMode = !darkMode"
class="text-zinc-700 dark:text-zinc-200 hover:text-black dark:hover:text-white transition"
title="Toggle Theme"
>
<template x-if="!darkMode">
    <flux:icon name="sun" class="w-5 h-5" />
</template>
<template x-if="darkMode">
    <flux:icon name="moon" class="w-5 h-5" />
</template>
</button>