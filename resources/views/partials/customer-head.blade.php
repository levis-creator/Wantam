<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ $title ?? config('app.name') }} - E-commerce Store</title>
<meta name="description"
    content="{{ $meta['description'] ?? config('app.name') . ' - Your trusted online store for quality products and exceptional service.' }}">
<meta name="keywords"
    content="{{ $meta['keywords'] ?? 'e-commerce, shopping, ' . config('app.name') . ', products, online store' }}">
<meta name="author" content="{{ config('app.name') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $title ?? config('app.name') }}">
<meta property="og:description"
    content="{{ $meta['description'] ?? config('app.name') . ' - Shop quality products online.' }}">
<meta property="og:image" content="{{ asset('assets/images/demos/demo-10/logo.png') }}">
<meta property="og:url" content="{{ url()->current() }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? config('app.name') }}">
<meta name="twitter:description"
    content="{{ $meta['description'] ?? config('app.name') . ' - Shop quality products online.' }}">
<meta name="twitter:image" content="{{ asset('assets/images/demos/demo-10/logo.png') }}">

<!-- Permissions Policy -->
<meta http-equiv="Permissions-Policy" content="geolocation=(), camera=(), microphone=()">

<!-- Favicon and PWA -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/icons/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/icons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/icons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/images/icons/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
<link rel="shortcut icon" href="{{ asset('assets/images/icons/favicon.ico') }}">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
<meta name="application-name" content="{{ config('app.name') }}">
<meta name="msapplication-TileColor" content="#cc9966">
<meta name="msapplication-config" content="{{ asset('assets/images/icons/browserconfig.xml') }}">
<meta name="theme-color" content="#ffffff">

<!-- Plugins CSS File -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery.countdown.css') }}">

<!-- Main CSS File -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/skins/skin-demo-10.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/demos/demo-10.css') }}">

<!-- Tailwind CSS -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!-- Alpine.js with Persist Plugin -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script>

<!-- Livewire Styles -->
@livewireStyles
