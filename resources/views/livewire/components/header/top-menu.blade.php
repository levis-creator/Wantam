<?php
use Livewire\Volt\Component;

new class extends Component {
    public $items;
}
?>

<ul class="top-menu">
    <li>
        <a href="#" aria-label="Top menu links">Links</a>
        <ul>
            @foreach($items as $item)
                <li>
                    <a href="{{ $item['href'] === 'tel:+0123456789' ? $item['href'] : route($item['href']) }}"
                        @if(isset($item['data-toggle'])) data-toggle="{{ $item['data-toggle'] }}" @endif
                        title="{{ $item['title'] }}">
                        @if($item['icon'])
                            <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                        @endif
                        {{ $item['label'] }}
                        @if(isset($item['badge']))
                            <span>({{ $item['badge'] }})</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
</ul><!-- End .top-menu -->