<?php
use Livewire\Volt\Component;

new class extends Component {
    public $currencies;
    public $selectedCurrency = 'USD';

    public function selectCurrency($currency)
    {
        $this->selectedCurrency = $currency;
        session(['currency' => $currency]);
    }
}
?>

<div class="header-dropdown" x-data="{ open: false }">
    <a href="#" x-on:click.prevent="open = !open" aria-label="Select currency" title="Choose your currency">
        {{ $selectedCurrency }}
    </a>
    <div class="header-menu" x-show="open" x-on:click.outside="open = false">
        <ul>
            @foreach($currencies as $currency)
                <li>
                    <a href="#" wire:click="selectCurrency('{{ $currency }}')" title="Switch to {{ $currency }} currency">
                        {{ $currency }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div><!-- End .header-menu -->
</div><!-- End .header-dropdown -->