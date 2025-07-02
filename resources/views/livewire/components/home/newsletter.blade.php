<?php

use Livewire\Volt\Component;

new class extends Component {
    #[State]
    public string $email = '';

    #[State]
    public string $success = '';

    #[Action]
    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        // Handle actual subscription logic here (e.g., store, send to external API)
        $this->success = 'Thank you for subscribing!';
        $this->email = '';
    }
};
?>

<section class="bg-zinc-100 dark:bg-zinc-900 py-12 my-10">
    <div class="container mx-auto px-4 max-w-3xl text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-zinc-800 dark:text-white mb-4">
            Subscribe to Our Newsletter
        </h2>
        <p class="text-zinc-600 dark:text-zinc-400 mb-6">
            Get updates on new products, promotions, and helpful tips.
        </p>

        <form @submit.prevent="subscribe" class="flex flex-col sm:flex-row items-center gap-4">
            <input
                type="email"
                @bind="email"
                placeholder="Enter your email"
                class="w-full px-4 py-3 rounded-md border border-zinc-300 dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
            />
            <button
                type="submit"
                class="px-6 py-3 bg-black text-white dark:bg-white dark:text-black rounded-md hover:bg-opacity-90 transition"
            >
                Subscribe
            </button>
        </form>

        <div class="mt-4">
            @if ($success)
                <p class="text-green-600 dark:text-green-400">{{ $success }}</p>
            @endif

            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>
