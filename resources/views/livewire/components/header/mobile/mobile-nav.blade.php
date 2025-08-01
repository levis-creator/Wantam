<?php
use Livewire\Volt\Component;

new class extends Component {
    public $items = [];

    public function mount($items)
    {
        $this->items = $items;
    }
}; ?>

<nav class="mobile-nav" aria-label="Mobile navigation">
    <ul class="mobile-menu">
        @foreach($items as $item)
            <li class="{{ $item['active'] ? 'active' : '' }}">
                <a href="{{ $item['href'] }}" title="{{ $item['label'] }} page">{{ $item['label'] }}</a>
                @if(isset($item['megamenu']) && $item['megamenu'])
                    <ul>
                        @foreach($item['megamenu']['sidebar'] as $section)
                            <li>
                                <a href="#" title="{{ $section['title'] }}">{{ $section['title'] }}</a>
                                <ul>
                                    @foreach($section['items'] as $subItem)
                                        <li>
                                            <a href="{{ $subItem['href'] }}" title="{{ $subItem['label'] }}">{{ $subItem['label'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav><!-- End .mobile-nav -->
