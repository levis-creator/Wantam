<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new
    #[Layout('components.layouts.guest')]
    #[Title('404')]
    class extends Component {
    // You can define properties, mount), computed), or actions here.
};

?>

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">404</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="error-content text-center" style="background-image: url(assets/images/backgrounds/error-bg.jpg)">
        <div class="container">
            <h1 class="error-title">Error 404</h1><!-- End .error-title -->
            <p>We are sorry, the page you've requested is not available.</p>
            <a href="index.html" class="btn btn-outline-primary-2 btn-minwidth-lg">
                <span>BACK TO HOMEPAGE</span>
                <i class="icon-long-arrow-right"></i>
            </a>
        </div><!-- End .container -->
    </div><!-- End .error-content text-center -->
</main><!-- End .main -->
