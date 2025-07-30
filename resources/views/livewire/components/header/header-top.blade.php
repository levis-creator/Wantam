<?php
use Livewire\Volt\Component;

new class extends Component {
    public $currencies = ['USD', 'EUR'];
    public $languages = [
        ['name' => 'English', 'code' => 'en', 'hreflang' => 'en-US'],
        ['name' => 'French', 'code' => 'fr', 'hreflang' => 'fr-FR'],
        ['name' => 'Spanish', 'code' => 'es', 'hreflang' => 'es-ES'],
    ];
    public $topMenuItems = [
        ['label' => 'Call Us', 'href' => 'tel:+0123456789', 'icon' => 'icon-phone', 'title' => 'Contact our support team'],
        ['label' => 'My Wishlist', 'href' => 'wishlist', 'icon' => 'icon-heart-o', 'badge' => 3, 'title' => 'View your wishlist'],
        ['label' => 'About Us', 'href' => 'about', 'icon' => null, 'title' => 'Learn about our company'],
        ['label' => 'Contact Us', 'href' => 'contact', 'icon' => null, 'title' => 'Get in touch with us'],
        ['label' => 'Login', 'href' => 'login', 'icon' => 'icon-user', 'data-toggle' => 'modal', 'title' => 'Sign in to your account'],
    ];
}
?>

<div class="header-top">
    <div class="container">
        <div class="header-left">
            <livewire:components.header.currency-dropdown :currencies="$currencies" />
            <livewire:components.header.language-dropdown :languages="$languages" />
        </div><!-- End .header-left -->
        <div class="header-right">
            <livewire:components.header.top-menu :items="$topMenuItems" />
        </div><!-- End .header-right -->
    </div><!-- End .container -->
</div><!-- End .header-top -->