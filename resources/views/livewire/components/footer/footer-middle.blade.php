<?php
use Livewire\Volt\Component;

new class extends Component {
    public $widgets = [];

    public function mount()
    {
        $this->widgets = [
            [
                'title' => 'About',
                'type' => 'about',
                'content' => [
                    'logo' => 'assets/images/demos/demo-10/logo-footer.png',
                    'description' => 'Welcome to ' . config('app.name') . ', your trusted online store for quality products and exceptional service.',
                    'social_links' => array_map(fn($platform, $url) => [
                        'url' => $url,
                        'title' => ucfirst($platform),
                        'icon' => 'icon-' . strtolower($platform) . '-f',
                    ], array_keys(config('social.links', [])), config('social.links', [])),
                ],
            ],
            [
                'title' => 'Useful Links',
                'type' => 'links',
                'content' => [
                    ['name' => 'About Molla', 'url' => route('about')],
                    ['name' => 'How to shop on Molla', 'url' => route('how-to-shop')],
                    ['name' => 'FAQ', 'url' => route('faq')],
                    ['name' => 'Contact us', 'url' => route('contact')],
                    ['name' => 'Log in', 'url' => route('login')],
                ],
            ],
            [
                'title' => 'Customer Service',
                'type' => 'links',
                'content' => [
                    ['name' => 'Payment Methods', 'url' => route('payment-methods')],
                    ['name' => 'Money-back guarantee!', 'url' => route('money-back')],
                    ['name' => 'Returns', 'url' => route('returns')],
                    ['name' => 'Shipping', 'url' => route('shipping')],
                    ['name' => 'Terms and conditions', 'url' => route('terms')],
                    ['name' => 'Privacy Policy', 'url' => route('privacy')],
                ],
            ],
            [
                'title' => 'My Account',
                'type' => 'links',
                'content' => [
                    ['name' => 'Sign In', 'url' => route('login')],
                    ['name' => 'View Cart', 'url' => route('cart')],
                    ['name' => 'My Wishlist', 'url' => route('wishlist')],
                    ['name' => 'Track My Order', 'url' => route('track-order')],
                    ['name' => 'Help', 'url' => route('help')],
                ],
            ],
        ];
    }
}; ?>

<div class="footer-middle">
    <div class="container">
        <div class="row">
            @foreach ($widgets as $widget)
                <div class="col-sm-6 col-lg-3">
                    <livewire:components.footer.footer-widget :widget="$widget" :key="$widget['title']" />
                </div>
            @endforeach
        </div>
    </div>
</div>
