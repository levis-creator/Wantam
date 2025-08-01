<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Rule;

new class extends Component {
    #[Rule('required|email')]
    public string $email = '';

    public function subscribe()
    {
        $this->validate();
        // Add subscription logic (e.g., save to database)
        session()->flash('message', 'Subscribed successfully!');
        $this->redirect(route('shop.index'));
    }
}; ?>

<form wire:submit.prevent="subscribe" class="input-group input-group-round" aria-label="Newsletter Subscription">
    <input type="email" wire:model.live="email" class="form-control form-control-white" placeholder="Your Email Address"
        aria-label="Email Address" required>
    <div class="input-group-append">
        <button class="btn" type="submit" title="Subscribe"><span>Go</span></button>
    </div>
    @error('email') <span class="error tw-text-red-500">{{ $message }}</span> @enderror
</form>
