<?php
use Livewire\Volt\Component;

new class extends Component {
    public $items;
}
?>

<nav class="main-nav" aria-label="Main navigation">
    <ul class="menu sf-arrows">
        @foreach($items as $item)
            <li class="{{ $item['active'] ?? false ? 'megamenu-container active' : '' }}">
                <a href="{{ route($item['href']) }}" class="sf-with-ul" title="{{ $item['label'] }} page">
                    {{ $item['label'] }}
                </a>
                @if(isset($item['megamenu']))
                    <div
                        class="megamenu {{ $item['label'] === 'Shop' ? 'megamenu-md' : ($item['label'] === 'Product' ? 'megamenu-sm' : 'demo') }}">
                        <div
                            class="{{ $item['label'] === 'Shop' || $item['label'] === 'Product' ? 'row no-gutters' : 'menu-col' }}">
                            @if($item['label'] === 'Home')
                                <div class="menu-title">{{ $item['megamenu']['title'] }}</div><!-- End .menu-title -->
                                <div class="demo-list">
                                    @foreach($item['megamenu']['items'] as $demo)
                                        <div class="demo-item">
                                            <a href="{{ route($demo['href']) }}" title="{{ $demo['title'] }}">
                                                <span class="demo-bg" style="background-image: url({{ asset($demo['image']) }});"
                                                    aria-hidden="true"></span>
                                                <span class="demo-title">{{ $demo['title'] }}</span>
                                            </a>
                                        </div><!-- End .demo-item -->
                                    @endforeach
                                </div><!-- End .demo-list -->
                                <div class="megamenu-action text-center">
                                    <a href="{{ route($item['megamenu']['action']['href']) }}"
                                        class="btn btn-outline-primary-2 view-all-demos"
                                        title="{{ $item['megamenu']['action']['label'] }}">
                                        <span>{{ $item['megamenu']['action']['label'] }}</span>
                                        <i class="{{ $item['megamenu']['action']['icon'] }}" aria-hidden="true"></i>
                                    </a>
                                </div><!-- End .text-center -->
                            @elseif($item['label'] === 'Shop' || $item['label'] === 'Product')
                                <div class="col-md-{{ $item['label'] === 'Shop' ? '8' : '6' }}">
                                    <div class="menu-col">
                                        <div class="row">
                                            @foreach($item['megamenu']['sidebar'] as $section)
                                                <div class="col-md-6">
                                                    <div class="menu-title">{{ $section['title'] }}</div><!-- End .menu-title -->
                                                    <ul>
                                                        @foreach($section['items'] as $subItem)
                                                            <li>
                                                                <a href="{{ route($subItem['href']) }}" title="{{ $subItem['label'] }}">
                                                                    {{ $subItem['label'] }}
                                                                    @if(isset($subItem['badge']))
                                                                        <span
                                                                            class="tip tip-{{ strtolower($subItem['badge']) }}">{{ $subItem['badge'] }}</span>
                                                                    @endif
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div><!-- End .row -->
                                    </div><!-- End .menu-col -->
                                </div><!-- End .col-md -->
                                <div class="col-md-{{ $item['label'] === 'Shop' ? '4' : '6' }}">
                                    <div class="banner banner-overlay">
                                        <a href="{{ route($item['megamenu']['banner']['href']) }}" class="banner banner-menu"
                                            title="{{ $item['megamenu']['banner']['title'] }}">
                                            <img src="{{ asset($item['megamenu']['banner']['image']) }}"
                                                alt="{{ $item['megamenu']['banner']['title'] }} Banner">
                                            <div
                                                class="banner-content banner-content-{{ $item['label'] === 'Shop' ? 'top' : 'bottom' }}">
                                                <div class="banner-title text-white">
                                                    {{ $item['megamenu']['banner']['title'] }}
                                                    @if($item['label'] === 'Product')
                                                        <br><span><strong>spring 2019</strong></span>
                                                    @endif
                                                </div><!-- End .banner-title -->
                                            </div><!-- End .banner-content -->
                                        </a>
                                    </div><!-- End .banner -->
                                </div><!-- End .col-md -->
                            @elseif($item['label'] === 'Pages' || $item['label'] === 'Blog' || $item['label'] === 'Elements')
                                <div class="menu-col">
                                    <ul>
                                        @foreach($item['megamenu']['sidebar'] as $section)
                                            <li>
                                                <a href="#" class="sf-with-ul">{{ $section['title'] }}</a>
                                                <ul>
                                                    @foreach($section['items'] as $subItem)
                                                        <li>
                                                            <a href="{{ route($subItem['href']) }}" title="{{ $subItem['label'] }}">
                                                                {{ $subItem['label'] }}
                                                                @if(isset($subItem['badge']))
                                                                    <span
                                                                        class="tip tip-{{ strtolower($subItem['badge']) }}">{{ $subItem['badge'] }}</span>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div><!-- End .menu-col -->
                            @endif
                        </div><!-- End .row or .menu-col -->
                    </div><!-- End .megamenu -->
                @endif
            </li>
        @endforeach
    </ul><!-- End .menu -->
</nav><!-- End .main-nav -->