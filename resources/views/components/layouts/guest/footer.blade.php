<footer class="px-4 md:px-28 py-10 bg-zinc-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

        {{-- Left Section --}}
        <div>
            <div class="inline-flex items-center space-x-2 mb-4">
                <x-app-logo class="w-10 h-10" />
                <span class="text-lg font-semibold">{{ config('app.company_info.name') }}</span>
            </div>
            <ul class="text-sm space-y-1">
                <li><strong>{{ __('Address') }}:</strong> {{ config('app.company_info.address') }}</li>
                <li><strong>{{ __('Phone') }}:</strong> {{ config('app.company_info.phone') }}</li>
                <li><strong>{{ __('Email') }}:</strong> {{ config('app.company_info.email') }}</li>
            </ul>
        </div>

        {{-- Useful Links --}}
        <div>
            <h3 class="font-semibold mb-3 text-base">Useful Links</h3>
            <ul class="text-sm space-y-2">
                <li><a href="#" class="hover:underline">Home</a></li>
                <li><a href="#" class="hover:underline">About</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>

        {{-- Socials --}}
        <div>
            <h3 class="font-semibold mb-3 text-base">Socials</h3>
            <ul class="text-sm space-y-2">
                <li><a href="#" class="hover:underline">Twitter</a></li>
                <li><a href="#" class="hover:underline">Facebook</a></li>
                <li><a href="#" class="hover:underline">Instagram</a></li>
            </ul>
        </div>

    </div>

    {{-- Footer Bottom --}}
    <div
        class="mt-10 border-t border-zinc-300 dark:border-zinc-600 pt-4 text-center text-sm text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} {{ config('app.company_info.name') }}. All rights reserved.
    </div>
</footer>
