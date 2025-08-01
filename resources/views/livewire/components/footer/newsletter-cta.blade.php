<?php

use Livewire\Volt\Component;

new class extends Component {
    public $email = '';

    public function subscribe()
    {
        $this->validate(['email' => 'required|email']);
        session()->flash('message', 'Thank you for subscribing!');
        $this->reset('email');
    }
}
?>
<div class="cta bg-image bg-dark pt-4 pb-5 mb-0"
    style="background-image: url({{ asset('images/demos/demo-10/bg-2.jpg') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="cta-heading text-center">
                    <h3 class="cta-title text-white">Subscribe for Our Newsletter</h3>
                    <p class="cta-desc text-white">
                        and receive <span class="font-weight-normal">$20 coupon</span> for first shopping
                    </p>
                </div>

                <form wire:submit.prevent="subscribe">
                    <div class="input-group input-group-round">
                        <input type="email" class="form-control form-control-white"
                            placeholder="Enter your Email Address" aria-label="Email Address" wire:model="email"
                            required>
                        <div class="input-group-append">
                            <button class="btn btn-white" type="submit" aria-label="Subscribe to newsletter">
                                <span>Subscribe</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    @if (session('message')) <span class="text-success">{{ session('message') }}</span> @endif
                </form>
            </div>
        </div>
    </div>
</div>
